<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoinLog;
use Illuminate\Http\Request;
use Services\WalletService;

class TransactionController extends Controller
{
    public function showAllTransections()
    {
        $transactions = CoinLog::with(['receiverUser' => function ($query) {
            $query->withTrashed();
        }, 'senderUser' => function ($query) {
            $query->withTrashed();
        }])->orderBy('created_at', 'DESC')->paginate(15);
        
        return view('transaction.transaction_details')->with('transactions', $transactions);
        
        // $tansactions = CoinLog::orderBy('created_at','DESC')->paginate(15);
        // return view('transaction.transaction_details')->with('transactions',$tansactions);
    }

    public function getDetailsOfTransaction($transactionId){
        $tansaction = CoinLog::find($transactionId);
        return view('transaction.details')->with('transaction',$tansaction);
    }

    public function allEarnings(Request $request){
        $dates = WalletService::setDates($request);
        $type = $request['type'] ? $request['type']:null;
        $expected = WalletService::expectedPlatformEarnings($dates, $type);
        $earning_types = WalletService::allTransactionTypes();
        $earnings = WalletService::totalPlatformEarnings($dates, $type);

        return view('my_earnings.index')->with(compact('expected', 'earnings', 'earning_types'));
    }
}
