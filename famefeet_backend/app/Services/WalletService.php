<?php

namespace Services;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Redeem;
use App\Models\CoinLog;
use App\Models\ReferralBonousLog;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Cron\AbstractField;
use Illuminate\Support\Facades\Auth;
use DataTables;




class WalletService
{
    public static function coinsGenrator($request){
        // return $request['to_amount'];
        $exchange_rate = config('famefeet.exchange_rate');
        // return $exchange_rate;
        $getUserWallet = Wallet::where('user_id',auth()->user()->id)->first();

        if(is_null($getUserWallet)){
            $wallet = Wallet::create([
                'user_id' => Auth::user()->id
            ]);
            if($request['log_type'] == config('famefeet.log_type_buy') && $request['to_currency'] == '$')
            {
                if($request['to_amount'] > 0){

                    $coinLog = new CoinLog();
                    $coinLog->log_type = config('famefeet.log_type.buy_coins');
                    $coinLog->to_amount = $request['to_amount'];
                    $coinLog->to_currency = $request['to_currency'];
                    $coinLog->from_amount = $exchange_rate*$request['to_amount'];
                    $coinLog->from_currency = 'Famefeet Coins';
                    $coinLog->service_charges_percentage =  0;//serviceChagesPercentageOfFamefeet();
                    $coinLog->celebrity_charges_percentage =  0;//celebrityChagesPercentageOfFamefeet();
                    $coinLog->service_charges_price = 0;//serviceChagesOfFamefeet($coinLog->from_amount);
                    $coinLog->celebrity_charges_price = 0;// - serviceChagesOfFamefeet($coinLog->from_amount);
                    // $coinLog->celebrity_charges_price =$coinLog->from_amount;// - serviceChagesOfFamefeet($coinLog->from_amount);
                    $coinLog->exchange_rate =$exchange_rate;
                    $coinLog->sender_wallet_id =config('famefeet.platform_name.gateway');
                    $coinLog->sender_user_id =config('famefeet.platform_name.gateway');
                    $coinLog->receiver_wallet_id =$wallet->id;
                    $coinLog->receiver_user_id =$wallet->user_id;
                    $coinLog->transaction_id = $request['transaction_id'];
                    $coinLog->save();

                    $new_from_amount = $coinLog->from_amount;
                    $old_total_coins = $wallet->total_coins;
                    $old_available_coins = $wallet->available_coins;
                    $wallet->update([
                        'total_coins' => $old_total_coins + $new_from_amount,
                        'available_coins' => $old_available_coins + $new_from_amount,
                    ]);
                    return response()->json([
                        'message' => 'Wallet created successfully!'
                    ],200);
                }else{
                    return response()->json([
                        'message' => 'Enter Amount must be greater then Zero'
                    ],401);
                }

            }
        }else{
            if($request['log_type'] == config('famefeet.log_type_buy') && $request['to_currency'] == '$')
            {
                if($request['to_amount'] > 0){
                    // return 'no';
                    $coinLog = new CoinLog();
                    // $coinLog->log_name = "Coins";
                    $coinLog->log_type = config('famefeet.log_type.buy_coins');
                    $coinLog->to_amount = $request['to_amount'];
                    $coinLog->to_currency = $request['to_currency'];
                    $coinLog->from_amount = $exchange_rate*$request['to_amount'];
                    $coinLog->from_currency = 'Famefeet Coins';
                    // $coinLog->service_charges_percentage = serviceChagesPercentageOfFamefeet();
                    // $coinLog->celebrity_charges_percentage = celebrityChagesPercentageOfFamefeet();
                    // $coinLog->service_charges_price =serviceChagesOfFamefeet($coinLog->from_amount);
                    // $coinLog->celebrity_charges_price =$coinLog->from_amount - serviceChagesOfFamefeet($coinLog->from_amount);
                    $coinLog->service_charges_percentage = 0;
                    $coinLog->celebrity_charges_percentage = 0;
                    $coinLog->service_charges_price = 0;
                    $coinLog->celebrity_charges_price = 0;

                    $coinLog->exchange_rate =$exchange_rate;
                    $coinLog->sender_wallet_id =config('famefeet.platform_name.gateway');
                    $coinLog->sender_user_id =config('famefeet.platform_name.gateway');
                    $coinLog->receiver_wallet_id =$getUserWallet->id;
                    $coinLog->receiver_user_id =$getUserWallet->user_id;
                    $coinLog->transaction_id = $request['transaction_id'];
                    $coinLog->save();

                    if(!is_null($coinLog))
                    {
                        $new_from_amount = $coinLog->from_amount;
                        // $walletObj = $coinLog->wallet;
                        $old_total_coins = $getUserWallet->total_coins;
                        $old_available_coins = $getUserWallet->available_coins;
                        $getUserWallet->update([
                            'total_coins' => $old_total_coins + $new_from_amount,
                            'available_coins' => $old_available_coins + $new_from_amount,
                        ]);
                        return response()->json([
                            'message' => 'Wallet balance updated successfully!'
                        ],200);
                    }else{
                        return response()->json([
                            'message' => 'Something Wrong!'
                        ],404);
                    }
                }else{
                    return response()->json([
                        'message' => 'Enter Amount must be greater then Zero'
                    ],401);
                }

            }elseif($request->log_type == config('famefeet.log_type_sell') && $request->to_currency == 'Famefeet Coins')
            {
                if($request->to_amount > 0){
                    // return 'yes';
                    if($getUserWallet->available_coins >= $request->to_amount){
                        $redeem = RedeemService::saveRedeemRequest($request->to_amount,$getUserWallet['user_id']);

                        $coinLog = new CoinLog();
                        $coinLog->log_type = config('famefeet.log_type.sell_coins');
                        $coinLog->to_amount = $request['to_amount'];
                        $coinLog->to_currency = $request['to_currency'];
                        $coinLog->from_amount = $request['to_amount'] / $exchange_rate;
                        $coinLog->from_currency = '$';
                        // $coinLog->service_charges_percentage = serviceChagesPercentageOfFamefeet();
                        // $coinLog->celebrity_charges_percentage = celebrityChagesPercentageOfFamefeet();
                        // $coinLog->service_charges_price =serviceChagesOfFamefeet($coinLog->from_amount);
                        // $coinLog->celebrity_charges_price =$coinLog->from_amount - serviceChagesOfFamefeet($coinLog->from_amount);
                        $coinLog->service_charges_percentage = 0;
                        $coinLog->celebrity_charges_percentage = 0;
                        $coinLog->service_charges_price = 0;
                        $coinLog->celebrity_charges_price = 0;

                        $coinLog->exchange_rate =$exchange_rate;
                        $coinLog->sender_wallet_id =$getUserWallet->id;
                        $coinLog->sender_user_id =$getUserWallet->user_id;
                        $coinLog->receiver_wallet_id = config('famefeet.platform_name.gateway');
                        $coinLog->receiver_user_id = config('famefeet.platform_name.gateway');
                        $coinLog->referral_table_name = 'redeems';
                        $coinLog->referral_table_id = $redeem->id;
                        // return $coinLog;
                        $coinLog->save();

                        // $walletObj = $coinLog->wallet;
                        $old_available_coins = $getUserWallet->available_coins;
                        $getUserWallet->update([
                            'available_coins' => $old_available_coins - $request->to_amount,
                        ]);
                        return response()->json([
                            'message' => 'Your request submited successfully!'
                        ],200);
                    }else{
                        return response()->json([
                            'message' => 'Sorry. Insufficient Balance!'
                        ],404);
                    }
                }else{
                    return response()->json([
                        'message' => 'Enter Amount must be greater then Zero'
                    ],401);
                }
            }
        }
    }

    public static function checkBalanceAvailable($auth_user, $request) {
        if( $request->charges != null)
        {
            $wallet = Wallet::where('user_id',$auth_user->id)->first();
            if(isset($wallet))
            {
                if($wallet->available_coins > $request->charges)
                {
                    return response()->json([
                        'message' => 'Balance available.'
                    ],200);
                }
                else
                {
                    return response()->json([
                        'message' => 'Insufficient Balance!'
                    ],555);
                }
            }
            else
            {
                return response()->json([
                    'message' => 'Please create wallet first.'
                ],555);
            }    
        }
        else
        {
            return response()->json([
                'message' => true
            ],200);
        }
    }

    public static function buySellLog($log_type,$to_amount,$sender_wallet,$receiver_wallet,$service_charges,$referral_table_name,$referral_table_id){
        $coinLog = new CoinLog();
        // $coinLog->log_name = $log_name;
        $coinLog->log_type = $log_type;
        $coinLog->to_amount = $to_amount;
        $coinLog->to_currency = "Famefeet Coins";
        $coinLog->from_amount = $to_amount;
        $coinLog->from_currency = 'Famefeet Coins';
        $coinLog->service_charges_percentage = serviceChagesPercentageOfFamefeet();
        $coinLog->celebrity_charges_percentage = celebrityChagesPercentageOfFamefeet();
        $coinLog->service_charges_price =$service_charges;
        $coinLog->celebrity_charges_price = $to_amount - $service_charges;
        $coinLog->sender_wallet_id =$sender_wallet->id;
        $coinLog->sender_user_id =$sender_wallet->user_id;
        $coinLog->receiver_wallet_id =$receiver_wallet->id;
        $coinLog->receiver_user_id =$receiver_wallet->user_id;
        $coinLog->referral_table_name = $referral_table_name;
        $coinLog->referral_table_id =  $referral_table_id;
        $coinLog->save();
        return $coinLog;
    }

    public static function referralBonusOfFamefeet($log_type,$price,$referred_user){

        $referral_bonus_price = referralBonusOfFamefeet($price);

        $referred_user_wallet  = Wallet::where('user_id',$referred_user->referred_user_id)->first();

       $b= $referred_user_wallet->update([
            'total_coins' => $referred_user_wallet['total_coins'] + $referral_bonus_price,
            'available_coins' => $referred_user_wallet['available_coins'] + $referral_bonus_price,
        ]);
        // return $b;


        $coinLog = new CoinLog();
        $coinLog->log_type = $log_type;
        $coinLog->to_amount = $referral_bonus_price;
        $coinLog->to_currency = "FameFeet Coins";
        $coinLog->from_amount = $referral_bonus_price;
        $coinLog->from_currency =  'Famefeet Coins';
        $coinLog->celebrity_charges_price = $referral_bonus_price;
        $coinLog->sender_wallet_id =config('famefeet.platform_name.gateway');
        $coinLog->sender_user_id =config('famefeet.platform_name.gateway');
        $coinLog->receiver_wallet_id =$referred_user_wallet->id;
        $coinLog->receiver_user_id =$referred_user->referred_user_id;
        $coinLog->referral_table_name = 'refer_users';
        $coinLog->referral_table_id =  $referred_user->id;
        $coinLog->save();

        $refferalCoinLog = new ReferralBonousLog();
        $refferalCoinLog->coin_log_id =  $coinLog->id;
        $refferalCoinLog->referred_user_id = $referred_user->referred_user_id;
        $refferalCoinLog->user_id =  $referred_user->user_id;
        $refferalCoinLog->save();


        return $coinLog;
        // $coinLog->save();
        // return $coinLog;
    }


    public static function buyCoins($request,$exchange_rate,$wallet){

        $coinLog = new CoinLog();
        $coinLog->log_type = config('famefeet.log_type.buy_coins');
        $coinLog->to_amount = $request['to_amount'];
        $coinLog->to_currency = $request['to_currency'];
        $coinLog->from_amount = $exchange_rate*$request['to_amount'];
        $coinLog->from_currency = 'Famefeet Coins';
        $coinLog->service_charges_percentage = 0;//serviceChagesPercentageOfFamefeet();
        $coinLog->celebrity_charges_percentage = 0;//celebrityChagesPercentageOfFamefeet();
        $coinLog->service_charges_price = 0;//serviceChagesOfFamefeet($coinLog->from_amount);
        $coinLog->celebrity_charges_price =0;//$coinLog->from_amount - serviceChagesOfFamefeet($coinLog->from_amount);
        $coinLog->exchange_rate =$exchange_rate;
        $coinLog->sender_wallet_id =config('famefeet.platform_name.gateway');
        $coinLog->sender_user_id =config('famefeet.platform_name.gateway');
        $coinLog->receiver_wallet_id =$wallet->id;
        $coinLog->receiver_user_id =$wallet->user_id;
        $coinLog->save();

        return $coinLog;
    }


    public static function setDates($dates){
       

        $start_date = Carbon::today()->subDay(90);
        $end_date =Carbon::today()->addDay(1);

        if($dates['start_date'] && $dates['end_date']){
            $start_date = Carbon::parse($dates['start_date']);
            $end_date = Carbon::parse($dates['end_date']);
        }elseif ($dates['start_date']) {
            $start_date = Carbon::parse($dates['start_date']);
        } 
        elseif ($dates['end_date']) { 
            $end_date = Carbon::parse($dates['end_date']);
            
        }
        return [$start_date, $end_date];
    }

    public static function filterType($data){
        $types = config('famefeet.log_types');
        foreach($types as $type=>$value){
            if($value['id'] == $data){
                return $value['name'];
            }
        }
        return null;
    }

    public static function availableEarnings($coinlogs){
        $celeb_charges_orders = 0;
        $celeb_charges_shipping = 0;
        foreach($coinlogs as $coinLog){
            if(isset($coinLog->subOrder) && $coinLog->referral_table_name == 'sub_orders'){
                $order_id = $coinLog->subOrder->order_id;

                $order_status = Order::where('id', $order_id)->pluck('is_complete');

                if($order_status[0] == 'complete'){
                    $celeb_charges_orders += $coinLog->subOrder->celebrity_charges_price;
                    $celeb_charges_shipping += $coinLog->subOrder->shipping_charges;
                }
            }
        }
        return [$celeb_charges_orders, $celeb_charges_shipping];
    }

    public static function availableOfferEarnings($coinlogs){
        $celeb_charges_offers = 0;
        foreach($coinlogs as $coinlog){
            if($coinlog->offer && $coinlog->referral_table_name =='offers' ){
                $offer_status = Offer::where('id', $coinlog->referral_table_id)->pluck('status');
                if($offer_status[0] == 'accept'){
                    $celeb_charges_offers+= $coinlog->celebrity_charges_price;
                }
            }
        }
        return $celeb_charges_offers;
    }

    public static function remainingAvailable($coinlogs){
        $remaining = 0;
        foreach($coinlogs as $coinlog){
            if(in_array($coinlog->log_type, [3,7,13] )){
                $remaining += $coinlog->celebrity_charges_price;
            }
        }
        return $remaining;
    }

    public static function allTransactionTypes(){
        return config('famefeet.log_types');
    }



    public static function fanTopUps($id, $request){
        $topup_history = CoinLog::where('receiver_user_id', $id)
            ->where('log_type', config('famefeet.log_type.buy_coins'))
            ->get();
        $data = self::setTopups($topup_history);
        return $data;
    }

    public static function setTopups($topup_history){
        $data = [];

        if($topup_history){
            foreach($topup_history as $topup){
                $data[] = [
                    'total_amount'=>$topup->to_amount,
                    'date'=>$topup->created_at
                ];
            }
        }
        return $data;
    }


    public static function allIncomingPlatform(){
        $all = User::with('wallet')
            ->where('user_type', config('famefeet.user_type.fan'))
            ->select('id', 'username', 'full_name')
            ->get();


        return $all;
    }

    public static function allFanTopUps($dates){
        $allFansCoinLogs = CoinLog::query()
            ->with(['receiverUser'=> function($query){
            $query->select('id','username','avatar')
                ->where('user_type', config('famefeet.user_type.fan'))
                ->withTrashed();
        }])
            ->where('log_type', config('famefeet.log_type.buy_coins'))
            ->whereBetween('created_at', [$dates[0], $dates[1]])
            ->orderBy('id','DESC')
            ->get();
        $data = [];
        foreach($allFansCoinLogs as $coinLog){
            $data[] = [
                'from_amount'=>$coinLog->from_amount,
                'created_at'=>Carbon::parse($coinLog->created_at)->format('m-d-Y'),
                'exchange_rate'=>$coinLog->exchange_rate,
                'user_name'=>$coinLog->receiverUser->username
            ];

        }
        return $data;
    }


    public static function allWithdraws($dates)
    {
        $allOutgoing = CoinLog::query()
            ->with(['receiverUser' => function ($query) {
                $query->select('id', 'username', 'avatar')
                    ->where('user_type', config('famefeet.user_type.celebrity'));
            }])
            ->where('log_type', config('famefeet.log_type.sell_coins'))
            ->whereBetween('created_at', [$dates[0], $dates[1]])
            ->orderBy('id', 'DESC')
            ->get();

        $data = [];

        foreach($allOutgoing as $coinLog){
            if($coinLog->receiverUser !=null) {
                $data[] = [
                    'from_amount' => $coinLog->from_amount,
                    'created_at' => Carbon::parse($coinLog->created_at)->format('m-d-Y'),
                    'exchange_rate' => $coinLog->exchange_rate,
                    'user_name' => $coinLog->receiverUser->username
                ];
            }

        }
        return $data;
    }

    public static function allCoinlogs($dates){
        $coinLogs =  CoinLog::query()
            ->with(['receiverUser' => function ($query) {
                $query->select('id', 'username', 'avatar')
                    ->where('user_type', config('famefeet.user_type.celebrity'));
            }])
            ->whereNot('log_type', config('famefeet.log_type.sell_coins'))
            ->whereNot('log_type', config('famefeet.log_type.buy_coins'))
            ->whereBetween('created_at', [$dates[0], $dates[1]])
            ->orderBy('id', 'DESC')
            ->get();
        $data = [];
        foreach($coinLogs as $coinLog){
            if($coinLog->receiverUser !=null) {
                $data[] = [
                    'log_type' =>getLogTypeName($coinLog->log_type),
                    'total_amount' => $coinLog->from_amount,
                    'service_charges' => $coinLog->service_charges_price,
                    'celebrity_charges' => $coinLog->celebrity_charges_price,
                    'created_at' => Carbon::parse($coinLog->created_at)->format('m-d-Y'),
                    'exchange_rate' => $coinLog->exchange_rate,
                    'user_name' => $coinLog->receiverUser->username
                ];
            }

        }
        return $data;
    }


    public static function filteredData($data, $type, $dates){
        return  $data->where('log_type','!=', config('famefeet.log_type.buy_coins'))->when($type, function($query2) use ($type){
            return $query2->where('log_type', $type);
        })->whereBetween('created_at', [$dates[0], $dates[1]])->flatten(1);

    }

    public static function expectedEarningOffers($coinlogs){
        $celeb_charges_offers = 0;
        foreach($coinlogs as $coinlog){
            if($coinlog->offer && $coinlog->referral_table_name =='offers' ){
                $offer_status = Offer::where('id', $coinlog->referral_table_id)->pluck('status');
                if($offer_status[0] == 'pending'){
                    $celeb_charges_offers+= $coinlog->celebrity_charges_price;
                }
            }
        }

        return $celeb_charges_offers;
    }

    public static function expectedEarningOrder($coinlogs){
        
        $celeb_charges_orders = 0;
        $celeb_charges_shipping = 0;
        foreach($coinlogs as $coinLog){
            if($coinLog->log_type == 4 && isset($coinLog->subOrder) && $coinLog->referral_table_name == 'sub_orders'){
                $order_status = Order::find($coinLog->subOrder->order_id);
                if(isset($order_status) && $order_status->is_complete == 'pending'){
                    $celeb_charges_orders += $coinLog->subOrder->celebrity_charges_price;
                    $celeb_charges_shipping += $coinLog->subOrder->shipping_charges;
                }
            }
        }
        return [$celeb_charges_orders, $celeb_charges_shipping];
    }

    public static function totalPlatformEarnings($dates, $type){
        $coinLogSum = CoinLog::whereNot('log_type', 'famefeet.log_type.sell_coins')
            ->whereBetween('created_at', [$dates[0], $dates[1]])
            ->when($type, function($query) use ($type){
                $query->where('log_type', $type);
            })
            ->sum('service_charges_price');
        return $coinLogSum;

    }

    public static function expectedPlatformEarnings($dates, $type){
        $coinLogs =CoinLog::whereNot('log_type', 'famefeet.log_type.sell_coins')
            ->whereBetween('created_at', [$dates[0], $dates[1]])
            ->when($type, function($query) use ($type){
                $query->where('log_type', $type);
            })
            ->get();
        $orderExpected = self::expectedEarningOrder($coinLogs)[0];
        $offerExpected = self::expectedEarningOffers($coinLogs);
        $total = $orderExpected + $offerExpected;
        return $total;
    }



    public static function totalTransaction($dates, $type){
        $coinLogSum = Wallet::whereBetween('created_at', [$dates[0], $dates[1]])
        ->sum('total_coins');
        return $coinLogSum;

    }

    public static function availableTransaction($dates, $type){
        $coinLogSum = Wallet::whereBetween('created_at', [$dates[0], $dates[1]])
        ->sum('available_coins');
        return $coinLogSum;
    }

    public static function totalWithdrawals($dates, $type){
        $coinLogSum = CoinLog::whereBetween('created_at', [$dates[0], $dates[1]])
        ->where('log_type', config('famefeet.log_type.sell_coins'))
        ->sum('from_amount');
        return $coinLogSum;
    }



    public static function totalBuysellTransaction($dates, $type){
        $coinLogSum = CoinLog::whereBetween('created_at', [$dates[0], $dates[1]])
        ->whereNot('log_type', config('famefeet.log_type.sell_coins'))
        ->whereNot('log_type', config('famefeet.log_type.buy_coins'))
        ->sum('from_amount');
        return $coinLogSum;
    }

    public static function availableBuysellTransaction($dates, $type){
        $coinLogs =CoinLog::whereNot('log_type', 'famefeet.log_type.sell_coins')
        ->whereBetween('created_at', [$dates[0], $dates[1]])
        ->when($type, function($query) use ($type){
            $query->where('log_type', $type);
        })
        ->get();
    $orderExpected = self::expectedEarningOrder($coinLogs)[0];
    $offerExpected = self::expectedEarningOffers($coinLogs);
    $total = $orderExpected + $offerExpected;
    return $total;

    }

    public static function allOutGoingPlatformPagination(){

            $allOutgoing = CoinLog::all();
            $data = [];
            foreach($allOutgoing as $coinLog){
                if($coinLog->receiverUser !=null) {
                    $data[] = [
                        'user_name' => $coinLog->receiverUser->username,
                        'from_amount' => $coinLog->from_amount,
                        'created_at' => Carbon::parse($coinLog->created_at)->format('m-d-Y'),
                        'exchange_rate' => $coinLog->exchange_rate,

                    ];
                }

            }
            return DataTables::of($data)->addIndexColumn()->make(true);
        return($data);


     }


     public static function allPlatformPagination(){

        $allOutgoing = CoinLog::all();
        $data = [];
        foreach($allOutgoing as $coinLog){
            if($coinLog->receiverUser !=null) {
                $data[] = [
                    'log_type' =>getLogTypeName($coinLog->log_type),
                    'total_amount' => $coinLog->from_amount,
                    'service_charges' => $coinLog->service_charges_price,
                    'celebrity_charges' => $coinLog->celebrity_charges_price,
                    'created_at' => Carbon::parse($coinLog->created_at)->format('m-d-Y'),
                    'exchange_rate' => $coinLog->exchange_rate,
                    'user_name' => $coinLog->receiverUser->username
                ];
            }

        }
        return DataTables::of($data)->addIndexColumn()->make(true);
    return($data);


 }



 public static function allIncomingPlatformPagination(){

    // $allFansCoinLogs = CoinLog::all();
    $allFansCoinLogs = CoinLog::with(['receiverUser' => function ($query) {
        $query->withTrashed(); // Include soft-deleted users
    }])->get();
    $data = [];
        foreach($allFansCoinLogs as $coinLog){
            
            if($coinLog->receiverUser !=null) {
            $data[] = [
                'from_amount'=>$coinLog->from_amount,
                'created_at'=>Carbon::parse($coinLog->created_at)->format('m-d-Y'),
                'exchange_rate'=>$coinLog->exchange_rate,
                'user_name'=>$coinLog->receiverUser->username
            ];
        }

        }
    return DataTables::of($data)->addIndexColumn()->make(true);
    return($data);


}



}
