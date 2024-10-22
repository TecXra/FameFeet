<?php
namespace Services;
use App\Models\ReportedUser;
use Illuminate\Support\Facades\Auth;

class ReportUserService{
     public static function report($request){
        
        if(checkUserAccountStatus($request->reported_user_id))
        {
            return getUserAccountResponse();
        }

        $alredy_report = ReportedUser::where('user_id',auth()->user()->id)->where('reported_user_id',$request->reported_user_id)
                                //  ->orWhere('user_id',$request->reported_user_id)
                                //  ->orWhere('reported_user_id',auth()->user()->id)
                                ->first();

        // return #
        if(is_null($alredy_report)){
            if(Auth::user()->id == $request->reported_user_id){
                return response()->json([
                    'message' => 'Somethig Wrong!'
                ]);
            }else{
                $report = new ReportedUser();
                $report->message = $request->message;
                $report->user_id = auth()->user()->id;
                $report->reported_user_id = $request->reported_user_id;
                $report->save();
                return response()->json([
                    'message' => 'You have reported the user successfully!'
                ]);
            }
        }else{
            return response()->json([
                'message' => 'You already have reported this user!'
            ],400);
        }

     }

}
