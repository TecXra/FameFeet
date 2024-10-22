<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerifyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Carbon\Carbon;
use App\Models\User;
use App\Models\VerifyUser as ModelsVerifyUser;
// use Illuminate\Support\Facades\Log;
use Services\FanService;
use Services\CelebrityService;
use Illuminate\Routing\Route;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Services\ReferralUserService;
use Illuminate\Support\Str;
use Services\UserStatusService;

class AuthController extends Controller
{

    protected $client;

    public function __construct()
    {
        $this->client = \Laravel\Passport\Client::where('password_client', 1)->first();
        $this->middleware('auth:api', ['only' => 'logoutUser']);
        // $this->middleware('auth:api')->except(['forgotPassword', 'loginUser']);
    }




    public function isUsernameAvailable(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|between:4,100|unique:users',
        ]);
        if ($validator->fails()) {
            return 0;
        }
        return 1;
    }



    public function registerFanUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|between:4,100|unique:users|regex:/^[a-zA-Z0-9_]+$/',
            'email' => 'required|string|email|max:100|unique:users|regex:/^[^\.]+(\.[^\.]+)*@[^\.]+\.[^\.]+$/',
            'password' => 'min:8|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:8',
            'phone_number' => 'required|string|min:11',
            'date_of_birth' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        if($request->has('used_referral_code') && $request->used_referral_code != '')
        {
             $referral = User::select('referral_code')
                         ->where('referral_code',$request->used_referral_code)
                         ->get();
            if(!$referral->count())
                {
                    return response()->json([
                        'message' => ["Referral Code Not Exist"]
                    ],401);
                }else{
                    $userFan = FanService::createFanUser($request);
                    /// slug ////
                    $slug = createSlug($userFan->username,$userFan->id);
                    $userFan->slug = $slug;
                    $userFan->used_referral_code = $request->used_referral_code;
                    $userFan->save();

                    $verifyUser = UserStatusService::varifyUserEmail($userFan);
                    Mail::to($userFan->email)->send(new VerifyUser($userFan,$verifyUser));

                    return $this->loginUser($request);
                }
        }else{
                $userFan = FanService::createFanUser($request);
                $slug = createSlug($userFan->username,$userFan->id);
                $userFan->slug = $slug;
                $userFan->save();

                $verifyUser =  UserStatusService::varifyUserEmail($userFan);

                Mail::to($userFan->email)->send(new VerifyUser($userFan,$verifyUser));
                return $this->loginUser($request);
        }
      //  return $user;

    }
    // to Register CelebrityUser
    public function registerCelebrityUser(Request $request){

        $validator = Validator::make($request->all(),[
            'username' => 'required|string|min:4|max:100|not_in:email|unique:users|regex:/^[a-zA-Z0-9_]+$/',
            'email'  => 'required|string|email|max:100|unique:users|regex:/^[^\.]+(\.[^\.]+)*@[^\.]+\.[^\.]+$/',
            'password' => 'required|string|min:8',
            'password' => 'min:8|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:8',
            'full_name' => 'required',
            'phone_number' => 'required|string|min:11',
            'date_of_birth' => 'required',
            'front_id_pic' => 'required',
            'back_id_pic' =>'required',
            'state' => 'required|string',
            'zipcode' => 'required|min:5',


        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        // return "hi";
        if($request->has('used_referral_code') && $request->used_referral_code != '')
        {
            // return "referral";
            $referral = User::where('referral_code',$request->used_referral_code)->get();
            // return $referral;
            if(!$referral->count())
            {
                return response()->json([
                    'message' => ["Referral Code Not Exist"]
                ],401);
            }else{
                // return "exist";
                $userCelebrity = CelebrityService::createCelebrityUser($request->all());
                /// slug ////
                $slug = createSlug($userCelebrity->username,$userCelebrity->id);
                $userCelebrity->slug = $slug;
                $userCelebrity->used_referral_code = $request->used_referral_code;
                $userCelebrity->save();
                ReferralUserService::saveReferralUserDetails($userCelebrity->id,$referral[0]->id);
                $verifyUser = UserStatusService::varifyUserEmail($userCelebrity);
                Mail::to($userCelebrity->email)->send(new VerifyUser($userCelebrity,$verifyUser));

                return $this->loginUser($request);
            }
        }else{
            // return 'hello';
            $userCelebrity = CelebrityService::createCelebrityUser($request->all());
            $slug = createSlug($userCelebrity->username,$userCelebrity->id);
            $userCelebrity->slug = $slug;
            $userCelebrity->save();

            $verifyUser = UserStatusService::varifyUserEmail($userCelebrity);
            Mail::to($userCelebrity->email)->send(new VerifyUser($userCelebrity,$verifyUser));

            return $this->loginUser($request);
        }


    }

    // Login user
    public function loginUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $credentials = [
            'email'      => $request->email,
            'password'    => $request->password,

        ];

        $user = User::withTrashed()->where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => ['Account not found']
            ], 401);
        }


        if ($user->account_status == config('famefeet.account_status.deleted')) {
            return response()->json([
                'message' => ['Your account was deleted. Please contact support for help.']
            ], 401);
        }
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => ['Invalid Credentials']
            ], 401);
        }

        //prevent Same user login from multiple devices
        // Auth::logoutOtherDevices($request->password);

        $user = $request->user();
        if($user->account_status != config('famefeet.account_status.active')){
            return response()->json([
                'message' => ['user status inactive']
            ], 403);
        }
        $request->user()->update(['is_online' => true]);
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            if ($request->remember_me)
                $token->expires_at = Carbon::now()->addYears(1);
            $token->save();
            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logoutUser(Request $request)
    {
       $request->user()->update(['is_online' => false]);

        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function refreshToken(Request $request)
    {
        $request->request->add([
            'grant_type'    => 'refresh_token',
            'refresh_token' => $request->refresh_token,
            'client_id'     => $this->client->id,
            'client_secret' => $this->client->secret,
            'scope'         => '',
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        return Route::dispatch($proxy);
    }


    public function deleteUserAccount() {
        $user = Auth::user();
        $user->account_status = config('famefeet.account_status.deleted');
        $user->save();
        $user->delete();
        return response()->json([
            'message'  =>  'Your account has been deleted successfully.'
        ]);
    }

    public function verifyUserEmail($token){
         $verifyUser = ModelsVerifyUser::where('token',$token)->first();
         if(isset($verifyUser)){
           $user = $verifyUser->user;
           if(!$user->email_verified_at){
            $user->email_verified_at = Carbon::now();
            $user->save();
            return true;
           }
           return true;
        }
        return false;
    }

    public function resendUserEmailVerificationEmail(Request $request){
        $user = User::where('email',$request->email)->first();
        if(isset($user)){
            $verifyUser=ModelsVerifyUser::updateOrCreate(
                ['user_id' => $user->id,],
                [
                    'token' => Str::random(40),
                    'email' => $user->email,
                ]
            );
            Mail::to($user->email)->send(new VerifyUser($user,$verifyUser));
            return response()->json([
                'message' => "Please check your email to verify."
            ]);
        }else{
            return response()->json([
                'message' => "This email not found"
            ],400);
        }

    }

}
