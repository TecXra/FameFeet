<?php

namespace App\Http\Controllers;

use App\Models\FanRating;
use App\Models\User;
use App\Events\CelebrityRateEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\BannedUser;
use Illuminate\Support\Facades\Auth;

class FanRatingController extends Controller
{
    //
    public function fanRating(Request $request){
        $validate = Validator::make($request->all(),[
            'rating' => 'required',
            'message' => 'required',
            'rated_user_id' => 'required',
        ]);


        if($validate->fails()){
          return response()->json($validate->errors(),400);
        }

        $fan_ban_celeb=BannedUser::where('user_id', auth()->user()->id)->where('banned_user_id',$request->rated_user_id)->first();
        $celeb_ban_fan=BannedUser::where('user_id',$request->rated_user_id)->where('banned_user_id', auth()->user()->id)->first();
        $del_user=User::where('account_status',4)->where('id',$request->rated_user_id)->first();

        if(!$del_user){

if(!$fan_ban_celeb && !$celeb_ban_fan){
        $alredy_rate = FanRating::where('user_id',auth()->user()->id)
                        ->where('rated_user_id',$request->rated_user_id)
                        ->first();
        $user_id = Auth()->user()->id;
        // $rating = $request->rating;
        $user = User::find($request->rated_user_id);
        $sender = Auth::user();
        if (!is_null($user)) {
            if (is_null($alredy_rate)) {
                $fanRating = FanRating::create([
                    'rating' => $request->rating,
                    'message' => $request->message,
                    'user_id' => $user_id,
                    'rated_user_id' => $request->rated_user_id,
                 ]);
                event(new CelebrityRateEvent($fanRating,$sender,$user));

                 return response()->json([
                   'message' => 'Your review sent successfully!'
                 ]);
            }else{
                return response()->json([
                    'message' => 'You already rate this User!'
                ],400);
            }
        }else{
            return response()->json([
               'message' => 'Something Wrong!'
            ],400);
        }
    }else{
        return response()->json([
            'error' => 'You can not rate because you are blocked!'

        ],401);
    }
        }else{
            return response()->json([
                'message' => 'Your account has been deleted. You cannot perform this action.'

            ],401);
        }
     }

     public function getFanRating(){
        $fanRating = FanRating::query() ->with(['user'=> function($query){
                        $query->withTrashed()->select('id','username','avatar','user_type','account_status')
                        ->with('celebrity:id,user_id')
                        ->get();}])
                     ->where('rated_user_id',auth()->user()->id)
                     ->get();
        return $fanRating;
     }

    public function getFanRatingOnCelebritySide($userId)
    {
        $fanRating = FanRating::query() ->with(['user'=> function($query){
            $query->select('id','username','avatar','user_type')
            ->with('celebrity:id,user_id')
            ->get();}])
         ->where('rated_user_id',$userId)
         ->get();
        return $fanRating;
    }
}
