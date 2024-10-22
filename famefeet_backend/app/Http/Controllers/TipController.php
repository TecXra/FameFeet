<?php

namespace App\Http\Controllers;

use App\Events\SendTipEvent;
use App\Models\Tip;
use App\Models\User;
use App\Models\Wallet;
use App\Models\BannedUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Services\WalletService;

class TipController extends Controller
{
    public function sendTip(Request $request)
    {
        if(checkUserAccountStatus($request->receiver_id))
        {
            return getUserAccountResponse();
        }
        $receiver = User::find($request->receiver_id);

        $sender = auth()->user();

        $fan_ban_celeb=BannedUser::where('user_id',$sender->id)->where('banned_user_id',$receiver->id)->first();
        $celeb_ban_fan=BannedUser::where('user_id', $receiver->id)->where('banned_user_id',$sender->id)->first();
        $del_user=User::where('account_status',4)->where('id',$receiver->id)->first();

        if(!$del_user)
        {
            if(!$fan_ban_celeb && !$celeb_ban_fan)
            {
                $validator = Validator::make($request->all(), [
                    'coins' => 'required|numeric|min:1'
                ]);
                if ($validator->fails())
                {
                    return response()->json($validator->errors(), 400);
                }

                $walletSender = Wallet::where('user_id',auth()->user()->id)->first();
                if(is_null($walletSender))
                {
                    return response()->json([
                        'message' => 'Create Wallet first to send tip!'
                    ],400);
                }

                $walletReceiver = Wallet::where('user_id',$request->receiver_id)->first();
                
                if(is_null($walletReceiver))
                {
                    return response()->json([
                        'message' => 'Something Wrong At Receiver Side!'
                    ],400);
                }
                
                if(auth()->user()->id == $request->receiver_id)
                {
                    return response()->json([
                        'message' => 'Sorry. SomeThing Wrong!'
                    ],400);
                } elseif($walletSender->available_coins >= $request->coins)
                {
                    if($sender->user_type == 2 && $receiver->user_type == 2)
                    {
                        return response()->json([
                            'message' => 'Sorry. You can not send the tip this particuler user!'
                        ],400);
                    } else
                    {
                        $tip = new Tip();
                        $tip->coins = $request->coins;
                        $tip->sender_id =auth()->user()->id;
                        $tip->receiver_id = $request->receiver_id;
                        $tip->save();

                        $referral_table_name =  'tips';
                        $referral_table_id = $tip->id;
                        $service_charges = serviceChagesOfFamefeet($tip->coins);
                        $coinsTransferToCelebrity = $tip->coins - $service_charges;

                        //Transection History
                        WalletService::buySellLog(config('famefeet.log_type.send_tip_text'),$tip->coins,$walletSender,$walletReceiver,$service_charges,$referral_table_name,$referral_table_id);

                        //Referred user charges
                        $referredUser = getReferredUser($tip->receiver_id);
                        if(isset($referredUser)){
                            WalletService::referralBonusOfFamefeet(config('famefeet.log_type.referral_bonus'),$tip->coins,$referredUser);
                        }

                        $walletSender->update([
                            'total_coins' => $walletSender['total_coins'] - $tip['coins'],
                            'available_coins' => $walletSender['available_coins'] - $tip['coins'],
                           ]);
                        $walletReceiver->update([
                            'total_coins' => $walletReceiver['total_coins'] + $coinsTransferToCelebrity,
                            'available_coins' => $walletReceiver['available_coins'] + $coinsTransferToCelebrity,
                           ]);

                        event(new SendTipEvent($tip,$sender,$receiver));
                           return response()->json([
                            'message' => 'Tip sent Successfully!'
                        ],200);
                    }
                } else
                {
                    return response()->json([
                        'message' => 'Sorry. Insufficient Balance!'
                    ],400);
                }
            } else
            {
                return response()->json([
                    'message' => 'you can not send tip because you are blocked!'
                ],400);
            }
        } else
        {
            return response()->json([
                'message' => 'Your account has been deleted. You cannot perform this action.'
            ]);
        }
    }
}
