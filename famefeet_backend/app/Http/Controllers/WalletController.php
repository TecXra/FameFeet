<?php

namespace App\Http\Controllers;

use App\Models\CoinLog;
use App\Models\Redeem;
use App\Models\ReferUser;
use App\Models\Wallet;
use App\Models\ReferralBonousLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Services\RedeemService;
use Services\WalletService;
use App\Models\User;
class WalletController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'to_amount' => 'required|numeric|min:1',
            'to_currency' => 'required',
            'log_type'  => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
      $wallet = WalletService::coinsGenrator($request);
      return $wallet;
    }
    public function checkBalanceAvailable(Request $request) {
        $authUser = Auth::user();
        return WalletService::checkBalanceAvailable($authUser, $request);
    }


   public function getWalletFanSide(Request $request){
    $id = Auth::user()->id;
    $dates = WalletService::setDates($request);
    $type = $request['type'] != 'all' ? $request['type']:null;
    $wallet = Wallet::where('user_id',$id)->first();
    $total_coins = 0;
    if(isset($wallet)){
        $coinLogs = CoinLog::query()
            ->with(['receiverUser'=> function($query){
            $query->withTrashed()->select('id','username','avatar','user_type')->with('celebrity:id,user_id');
            }])
           ->where('sender_wallet_id',$wallet->id)
            ->where('sender_user_id',$id)
            ->orWhere('receiver_user_id',$id)
            ->orWhere('receiver_wallet_id',$wallet->id)
            ->orderBy('id','DESC')
            ->get();
        $coinLogs = WalletService::filteredData($coinLogs, $type, $dates);

        if(count($coinLogs) > 0){
            foreach ($coinLogs as $coinLog) {
                $log_id = $coinLog->id;
                $log_type = getLogTypeName($coinLog->log_type);
            
                $from_amount = $coinLog->from_amount;
                if ($log_type === 'Order Refund') {
                    $total_coins -= (2 * $from_amount);
                }
                $total_coins += $from_amount;
                $created_at = $coinLog->created_at;
                if(isset($coinLog->receiverUser)){
                    if($coinLog->receiverUser->user_type == config('famefeet.user_type.celebrity')){
                        $user_id =  $coinLog->receiverUser->id;
                        $user_name = $coinLog->receiverUser->username;
                        $user_avatar = $coinLog->receiverUser->avatarURL;
                        $celebrity_id = $coinLog->receiverUser->celebrity->id;
                        $celebrity_user = [
                            "id" => $user_id,
                            'username' => $user_name,
                            'avatar' => $user_avatar,
                            'celebrity_id' => $celebrity_id,
                        ];
                    }else{
                        $celebrity_user = [];
                    }
                }else{
                    $celebrity_user = [];
                }

                $coinlog[] =
                [
                    "id" => $log_id,
                    "log_type" => $log_type,
                    "from_amount" => $from_amount,
                    "created_at" => $created_at,
                    "celebrity_user" => $celebrity_user
                ];
            }

          return $data = [
            "id" => $wallet->id,
            "remaining_coins" => $wallet->available_coins,
            "total_spent_coins" => $total_coins,
            'coinlog' => $coinlog,
           ];
        }else{
           return $data = [
            "id" => $wallet->id,
               "remaining_coins" => $wallet->available_coins,
               "total_spent_coins" => $total_coins,

               'coinlog' => [],
           ];
        }

    }else{
       return  $data = [];
    }

   }

   public function getWalletCelebritySide(Request $request){
    $id = Auth::user()->id;
    $dates = WalletService::setDates($request);
 
    $type = $request['type'] != 'all' ? $request['type']:null;

    $wallet = Wallet::where('user_id', $id)->first();

    if (isset($wallet)) {

        $totalAvailableCoins = $wallet->available_coins;
        $totalCoins = $wallet->total_coins;
        $totalEarnExpected = 0;
        $totalRedeemCoinPendingStatus = 0;
        $totalWithdrawnCoins = RedeemService::allWithdrawals($id);
        $formatedCoinLogs = [];

        $filter = ['dates'=>['start_date'=>$dates[0],'end_date'=>$dates[1]],'log_type' => $type]; 
    
        $celebCoinLogs = celebrityCoinLogsByUserId($id,$filter);
        
        $creditedCoinLogsSum = creditedCoinLogsSumForCelebrity($celebCoinLogs);    
        $debitedCoinLogsSum = debitedCoinLogsSumForCelebrity($celebCoinLogs);

        // $totalOrderAmount = $creditedCoinLogsSum['totalOrderAmount']+$debitedCoinLogsSum['totalOrderAmount'];
        // $totalServiceCharges = $creditedCoinLogsSum['totalServiceCharges']+$debitedCoinLogsSum['totalServiceCharges'];
        // $totalShippingCharges = $creditedCoinLogsSum['totalShippingCharges']+$debitedCoinLogsSum['totalShippingCharges'];
        // $totalCelebrityCharges = $creditedCoinLogsSum['totalCelebrityCharges']+$debitedCoinLogsSum['totalCelebrityCharges'];
       $coinLogs = array_merge($creditedCoinLogsSum['coinLogs'],$debitedCoinLogsSum['coinLogs']);


        $orderEarning = WalletService::expectedEarningOrder($celebCoinLogs);
        $totalEarnExpected = $orderEarning[0]+$orderEarning[1]+WalletService::expectedEarningOffers($celebCoinLogs);
        // return  [$orderEarning[0],$orderEarning[1],WalletService::expectedEarningOffers($celebCoinLogs)];

        if (count($coinLogs) > 0) {
            $total_shipping = null;

            
            foreach ($coinLogs as $coinLog) 
            {
                $user =  null;
                $log = CoinLog::find($coinLog['id']);
                if (isset($log->senderUser) && $log->senderUser->user_type == config('famefeet.user_type.fan')) {
                    $user = [
                        "id" => $log->senderUser->id,
                        "username" => $log->senderUser->username,
                        "avatar" => $log->senderUser->avatarURL,
                    ];
                }
                if (isset($coinLog->log_type) == config('famefeet.log_type.referral_bonus') ) {

                    $referralBonous=ReferralBonousLog::where('coin_log_id',$coinLog->id)->first();
                    $cleb_User = User::where('id', $referralBonous->user_id ?? '')->first();
                    $user = [
                        "id" =>   $cleb_User->id ?? '',
                        "username" => $cleb_User->username ?? '',
                        "avatar" => $cleb_User->avatar ?? '',
                    ];
                }        

                $coinLog['user'] = $user;
                $formatedCoinLogs[] = $coinLog;
            }


            // $available_total =  WalletService::availableEarnings($coinLogs)[0]+WalletService::availableEarnings($coinLogs)[1] +
            //     WalletService::remainingAvailable($coinLogs)+
            //     WalletService::availableOfferEarnings($coinLogs);
            //// $total_withdrawan_td = RedeemService::allWithdrawals();
            
            // $data = [
            //     "id" => $wallet->id,
            //     "available_coins" =>$wallet->available_coins,
            //     "total_coins" => $wallet->total_coins,//$total_earnings,
            //     "expected"=>$total_expected,//$total_earnings- $available_total,
            //     "pending"=>Redeem::where('user_id', $wallet->user_id)->where('status', 'pending')->sum('coins'),//,
            //     "total_shipments"=>$total_shipping,
            //     "withdrawn_td"=>$total_withdrawan_td,
            //     'coinlog' => $coinlog,
            // ];
        }

        $data = [
            "id" => $wallet->id,
            "available_coins" =>$totalAvailableCoins,
            "total_coins" => $totalCoins,
            "expected"=>$totalEarnExpected,
            "withdrawn_td"=>$totalWithdrawnCoins,
            'coinlog' => $formatedCoinLogs,
        ];
        return $data;
    } 
    else {
        return [];
    }


   }

   public function logTypes(){
       return WalletService::allTransactionTypes();
   }

   public function fanTopUps(Request $request){
       $id = Auth::id();
       return WalletService::fanTopUps($id, $request);
   }

   public function allIncomingPlatform(Request $request)
   {
        $dates = WalletService::setDates($request);
        $incomes = WalletService::allFanTopUps($dates);
        $type = $request['type'] ? $request['type']:null;
        $availableTransaction = WalletService::availableTransaction($dates, $type);
        $totalTransaction = WalletService::totalTransaction($dates, $type);
        return view('transactions.incoming')->with(compact('incomes', 'totalTransaction','availableTransaction'));
   }

   public function allOutGoingPlatform(Request $request){
       $dates = WalletService::setDates($request);
       $outgoing = WalletService::allWithdraws($dates);
       $type = $request['type'] ? $request['type']:null;
       $userWithdrawRequestPending = RedeemService::userWithdrawRequestPending($dates);
       $totalWithdrawals = WalletService::totalWithdrawals($dates, $type);



       return view('transactions.outgoing')->with(compact('outgoing','totalWithdrawals','userWithdrawRequestPending'));
   }

   public function allTransactions(Request $request){
       $dates = WalletService::setDates($request);
       $all = WalletService::allCoinlogs($dates);
       $type = $request['type'] ? $request['type']:null;
       $availableBuysellTransaction = WalletService::availableBuysellTransaction($dates, $type);
       $totalBuysellTransaction = WalletService::totalBuysellTransaction($dates, $type);

     return view('transactions.all')->with(compact('all','totalBuysellTransaction','availableBuysellTransaction'));
   }




   public function allOutGoingPlatformDatatables(Request $request){
    $dates = WalletService::setDates($request);
    $type = $request['type'] ? $request['type']:null;
    $allOutGoingPlatformPagination = WalletService::allOutGoingPlatformPagination($dates, $type);
      return $allOutGoingPlatformPagination;
   }

   public function allPlatformDatatables(Request $request){
    $dates = WalletService::setDates($request);
    $type = $request['type'] ? $request['type']:null;
    $allPlatformPagination = WalletService::allPlatformPagination($dates, $type);
      return $allPlatformPagination;
   }

   public function allIncomingPlatformDatatables(Request $request){
    $dates = WalletService::setDates($request);
    $type = $request['type'] ? $request['type']:null; 
    $allIncomingPlatformPagination = WalletService::allIncomingPlatformPagination($dates, $type);
    return $allIncomingPlatformPagination;
   }


}
