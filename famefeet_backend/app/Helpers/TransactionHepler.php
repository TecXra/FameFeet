<?php

use App\Models\CoinLog;
use App\Models\Wallet;

if (!function_exists('getWalletByUserId'))
{
    function getWalletByUserId($user_id) {
        
        return Wallet::where('user_id', $user_id)->first();
    }
}

if (!function_exists('celebrityCoinLogsByUserId'))
{
	function celebrityCoinLogsByUserId($user_id,$filters=[]) {
		
        $celeb = getCelebrityByUserId($user_id);
        if(isset($celeb)){
            return celebrityCoinLogsByCelebrityId($celeb->id,$filters);
        }
        return [];
	}
}

if (!function_exists('celebrityCoinLogs'))
{
    function celebrityCoinLogsByCelebrityId($celeb_id,$filters = []) {
        
        $celebrity = getCelebrityById($celeb_id);
        $wallet = getWalletByUserId($celebrity->user_id);

        $coinLogs = CoinLog::query()->with(['senderUser' => function ($query) {
                                    $query->withTrashed()->select('id', 'username', 'avatar', 'user_type')->with('celebrity:id,user_id');
                                }]);

        if(count($filters) > 0){
            
            if(isset($filters['dates'])){
                $dates = $filters['dates'];
                $coinLogs = $coinLogs->whereBetween('created_at', [$dates['start_date'], $dates['end_date']]);
            }
            
            if(isset($filters['log_type'])){
                $log_type = $filters['log_type'];
                $coinLogs = $coinLogs->where('log_type', $log_type);
            }

        }

        $coinLogs = $coinLogs->with(['senderUser' => function ($query) {
                        $query->withTrashed()->select('id', 'username', 'avatar', 'user_type')->with('celebrity:id,user_id');
                    }])
                    ->whereNot('log_type', config('famefeet.log_type.sell_coins'))
                    ->where(function ($query) use ($celebrity, $wallet) {
                        $query->where('sender_wallet_id', $wallet->id)
                            ->where('sender_user_id', $celebrity->user_id)
                            ->orWhere('receiver_user_id', $celebrity->user_id)
                            ->orWhere('receiver_wallet_id', $wallet->id);
                        })
                    ->orderBy('id', 'DESC')
                    ->get();
        return $coinLogs;
    }
}


if (!function_exists('arrayGroupBySpecificKey'))
{
    function arrayGroupBySpecificKey($arr,$key) {
        $return = array();
        foreach($arr as $val) {
            $return[$val[$key]][] = $val;
        }
        return $return;
    }
}


if (!function_exists('mergeCoinLogsResult'))
{
    function mergeCoinLogsResult($coinlogs1,$coinlogs2) {
        return [
            'totalOrderAmount' => $coinlogs1['totalOrderAmount']+$coinlogs2['totalOrderAmount'],
            'totalServiceCharges'=> $coinlogs1['totalServiceCharges']+$coinlogs2['totalServiceCharges'], 
            'totalShippingCharges'=> $coinlogs1['totalShippingCharges']+$coinlogs2['totalShippingCharges'],
            'totalCelebrityCharges'=> $coinlogs1['totalCelebrityCharges']+$coinlogs2['totalCelebrityCharges'],
            'coinLogs' => array_merge($coinlogs1['coinLogs'],$coinlogs2['coinLogs'])
        ];
    }
}



if (!function_exists('creditedCoinLogsSumForCelebrity'))
{
    function creditedCoinLogsSumForCelebrity($coinLogs) {
        $groupedCoinlogs = arrayGroupBySpecificKey($coinLogs,'log_type');

        $formatedCoinlogs = [
            'totalOrderAmount' => 0,
            'totalServiceCharges'=> 0, 
            'totalShippingCharges'=> 0,
            'totalCelebrityCharges'=> 0,
            'coinLogs' => []
        ];

        if(isset($groupedCoinlogs[2])){
            $tipLogs = formatCreditCoinsLogType($groupedCoinlogs[2]);
            if(isset($tipLogs)){
                $formatedCoinlogs = mergeCoinLogsResult($formatedCoinlogs,$tipLogs);
            }
        }

        if(isset($groupedCoinlogs[6])){
            $newSubscriptionLogs = formatCreditCoinsLogType($groupedCoinlogs[6]);
            if(isset($newSubscriptionLogs)){
                $formatedCoinlogs = mergeCoinLogsResult($formatedCoinlogs,$newSubscriptionLogs);
            }
        }

        if(isset($groupedCoinlogs[7])){
            $renewSubscriptionLogs = formatCreditCoinsLogType($groupedCoinlogs[7]);
            if(isset($renewSubscriptionLogs)){
                $formatedCoinlogs = mergeCoinLogsResult($formatedCoinlogs,$renewSubscriptionLogs);
            }    
        }
        
        if(isset($groupedCoinlogs[13])){
            $referalBonusLogs = formatCreditCoinsLogType($groupedCoinlogs[13]);
            if(isset($referalBonusLogs)){
                $formatedCoinlogs = mergeCoinLogsResult($formatedCoinlogs,$referalBonusLogs);
            }    
        }

        if(isset($groupedCoinlogs[1])){
            $messagesLogs = formatCreditCoinsLogType($groupedCoinlogs[1]);
            if(isset($messagesLogs)){
                $formatedCoinlogs = mergeCoinLogsResult($formatedCoinlogs,$messagesLogs);
            }    
        }
        
        if(isset($groupedCoinlogs[4])){
            $orderPlaceLogs = formatOrderPlaceLogType($groupedCoinlogs[4]);
            if(isset($orderPlaceLogs)){
                $formatedCoinlogs = mergeCoinLogsResult($formatedCoinlogs,$orderPlaceLogs);
            }    
        }

        if(isset($groupedCoinlogs[9])){
            $customOfferLogs = formatCreditCoinsLogType($groupedCoinlogs[9]);
            if(isset($customOfferLogs)){
                $formatedCoinlogs = mergeCoinLogsResult($formatedCoinlogs,$customOfferLogs);
            }
        }

        if(isset($groupedCoinlogs[8])){
            $boughtPostContentLogs = formatCreditCoinsLogType($groupedCoinlogs[8]);
            if(isset($boughtPostContentLogs)){
                $formatedCoinlogs = mergeCoinLogsResult($formatedCoinlogs,$boughtPostContentLogs);
            }    
        }


        return $formatedCoinlogs;
    }
}

if (!function_exists('formatCreditCoinsLogType'))
{
    function formatCreditCoinsLogType($coinLogs) {

        $formatedCoinLogs = [];
        $totalOrderAmount = 0;
        $totalServiceCharges = 0;
        $totalShippingCharges = 0;

        foreach ($coinLogs as $coinLog) {
            $user = null;
           
            $totalOrderAmount += $coinLog->from_amount;
            $totalServiceCharges += $coinLog->service_charges_price;
            
            $formatedCoinLogs[]=[
                "id" => $coinLog->id,
                "created_at" => $coinLog->created_at,
                "user" => $user,
                "log_type" => getLogTypeName($coinLog->log_type),
                "log_type_id" =>$coinLog->log_type,
                "total_amount" => $coinLog->from_amount,
                "service_charges" => $coinLog->service_charges_price,
                "shipping_charges" => 0,
                "total_earned" => $coinLog->celebrity_charges_price,
            ];
        }


        return [
            'totalOrderAmount' => $totalOrderAmount,
            'totalServiceCharges'=> $totalServiceCharges, 
            'totalShippingCharges'=> $totalShippingCharges,
            'totalCelebrityCharges'=> 0,
            'coinLogs' => $formatedCoinLogs
        ];
    }
}


if (!function_exists('formatOrderPlaceLogType'))
{
    function formatOrderPlaceLogType($coinLogs) {

        $formatedCoinLogs = [];
        $totalOrderAmount = 0;
        $totalServiceCharges = 0;
        $totalShippingCharges = 0;

        foreach ($coinLogs as $coinLog) {
            $user = null;
           
            $totalOrderAmount += $coinLog->subOrder->total_price;
            $totalServiceCharges += $coinLog->subOrder->service_charges_price;
            $totalShippingCharges += $coinLog->subOrder->shipping_charges;
            
            $formatedCoinLogs[]=[
                "id" => $coinLog->id,
                "created_at" => $coinLog->created_at,
                "user" => $user,
                "log_type" => getLogTypeName($coinLog->log_type),
                "log_type_id" =>$coinLog->log_type,
                "order_status" => $coinLog->subOrder->status,
                "total_amount" => $coinLog->from_amount,
                "service_charges" => ($coinLog->subOrder->status == 'cancel')?0:$coinLog->subOrder->service_charges_price,
                "shipping_charges" => ($coinLog->subOrder->status == 'cancel')?0:$coinLog->subOrder->shipping_charges,
                "total_earned" => ($coinLog->subOrder->status == 'cancel')?0:$coinLog->subOrder->celebrity_charges_price,
            ];
        }


        return [
            'totalOrderAmount' => $totalOrderAmount,
            'totalServiceCharges'=> $totalServiceCharges, 
            'totalShippingCharges'=> $totalShippingCharges,
            'totalCelebrityCharges'=> 0,
            'coinLogs' => $formatedCoinLogs
        ];
    }
}




if (!function_exists('debitedCoinLogsSumForCelebrity'))
{
    function debitedCoinLogsSumForCelebrity($coinLogs) {
        $groupedCoinlogs = arrayGroupBySpecificKey($coinLogs,'log_type');

        // coins logs that excluded from list for subtraction  12,5,10 

        $formatedCoinLogs = [
            'totalOrderAmount' => 0,
            'totalServiceCharges'=> 0, 
            'totalShippingCharges'=> 0,
            'totalCelebrityCharges'=> 0,
            'coinLogs' => []
        ];

        if(isset($groupedCoinlogs[5])){
            $orderRefundLogs = formatOrderRefundLogType($groupedCoinlogs[5]);
            if(isset($orderRefundLogs)){
                $formatedCoinLogs = mergeCoinLogsResult($formatedCoinLogs,$orderRefundLogs);
            }
        }

        if(isset($groupedCoinlogs[10])){
            $cancelOfferLogs = formatCancelOfferLogType($groupedCoinlogs[10]);
            if(isset($cancelOfferLogs)){
                $formatedCoinLogs = mergeCoinLogsResult($formatedCoinLogs,$cancelOfferLogs);
            }
        }

        return $formatedCoinLogs;

    }
}




if (!function_exists('formatOrderRefundLogType'))
{
    function formatOrderRefundLogType($coinLogs) {

        $formatedCoinLogs = [];
        $totalOrderAmount = 0;
        $totalServiceCharges = 0;
        $totalShippingCharges = 0;

        foreach ($coinLogs as $coinLog) {
            $user = null;

            $totalOrderAmount += $coinLog->subOrder->total_price;
            $totalServiceCharges += $coinLog->subOrder->service_charges_price;
            $totalShippingCharges += $coinLog->subOrder->shipping_charges;
            $formatedCoinLogs[]=[
                "id" => $coinLog->id,
                "created_at" => $coinLog->created_at,
                "user" => $user,
                "log_type" => getLogTypeName($coinLog->log_type),
                "log_type_id" =>$coinLog->log_type,
                "order_status" => $coinLog->subOrder->status,
                "total_amount" => $coinLog->from_amount,
                "service_charges" => 0, // $coinLog->subOrder->service_charges_price,
                "shipping_charges" => 0, // $coinLog->subOrder->shipping_charges,
                "total_earned" => 0,
            ];
        }


        return [
            'totalOrderAmount' => $totalOrderAmount,
            'totalServiceCharges'=> $totalServiceCharges, 
            'totalShippingCharges'=> $totalShippingCharges,
            'totalCelebrityCharges'=> 0,
            'coinLogs' => $formatedCoinLogs
        ];
    }
}



if (!function_exists('formatCancelOfferLogType'))
{
    function formatCancelOfferLogType($coinLogs) {

        $formatedCoinLogs = [];
        $totalOrderAmount = 0;
        $totalServiceCharges = 0;
        $totalShippingCharges = 0;

        foreach ($coinLogs as $coinLog) {
            $user = null;
           
            $totalOrderAmount += $coinLog->from_amount;
            $totalServiceCharges += $coinLog->service_charges_price;
            $formatedCoinLogs[]=[
                "id" => $coinLog->id,
                "created_at" => $coinLog->created_at,
                "user" => $user,
                "log_type" => getLogTypeName($coinLog->log_type),
                "log_type_id" =>$coinLog->log_type,
                "total_amount" => $coinLog->from_amount,
                "service_charges" => 0,
                "shipping_charges" => 0,
                "total_earned" => 0,
            ];
        }


        return [
            'totalOrderAmount' => $totalOrderAmount,
            'totalServiceCharges'=> $totalServiceCharges, 
            'totalShippingCharges'=> $totalShippingCharges,
            'totalCelebrityCharges'=> 0,
            'coinLogs' => $formatedCoinLogs
        ];

    }
}


