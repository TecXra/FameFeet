<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuthProvider;
use App\Models\Fan;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use Services\FanService;

class SocialAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();

            $finduser = User::where('google_id', $user->id)->first();

            if($finduser){
                // return "user already exist";
                Auth::login($finduser);

                return redirect()->intended('dashboard');

            }else{
                // return "new user";
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'password' => encrypt('123456dummy')
                ]);

                Auth::login($newUser);

                return redirect()->intended('dashboard');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }


    //Api routes code fore google login
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function handleProviderCallback($provider)
    {
            try{
                 $user = Socialite::driver($provider)->stateless()->user();
            }catch(ClientException $exception){
                return response()->json(['error'=>'Invalid Credentials'],422);
            }

            $findUser = User::where('email',$user->getEmail())->first();

            if(isset($findUser)){
            //    return "finderuser";
                if($findUser->account_status != config('famefeet.account_status.active')){
                    $tokenResult = $findUser->createToken('Personal Access Token');
                    $token = $tokenResult->accessToken;
                    return redirect(config('famefeet.client_base_url').'auth/social-callback?token='.$token.'&status='.false);
                }

                $authProvider = AuthProvider::where('user_id',$findUser->id)->first();
                if(isset($authProvider)){
                   $this->socialSignUpAndLogIn($user,$provider);
                }

                $tokenResult = $findUser->createToken('Personal Access Token');
                $token = $tokenResult->accessToken;
                return redirect(config('famefeet.client_base_url').'auth/social-callback?token='.$token.'&status='.true);
            }

            $userCreated = User::updateOrCreate(
                [
                    'email'=>$user->getEmail()
                ],
                [
                    'username' =>  str_replace(' ', '', $user->getName()),
                    'full_name' => $user->getName(),
                    'user_type' => config('famefeet.user_type.fan'),
                    'email_verified_at' => Carbon::now(),
                    'account_status' => config('famefeet.account_status.active'),
                    'is_online' => true,
                ]
            );
            Fan::updateOrCreate(
                [
                    'user_id'=>$userCreated->id,
                ],
                [
                    'user_id'=>$userCreated->id,
                ]
            );
            $slug = createSlug($userCreated->username,$userCreated->id);
            $userCreated->slug = $slug;
            $userCreated->save();

          $userCreated->authProviders()->updateOrCreate(
                [
                    'provider'=>$provider,
                    'provider_id'=>$user->getId(),
                ],
                [
                    'avatar'=>$user->getAvatar(),
                    'provider'=>$provider,
                    'provider_id'=>$user->getId(),
                ]
            );

            $tokenResult = $userCreated->createToken('Personal Access Token');
            $token = $tokenResult->accessToken;
            return redirect(config('famefeet.client_base_url').'auth/social-callback?token='.$token.'&status='.true);


    }

    public function socialSignUpAndLogIn($user,$provider){
        $userCreated = User::updateOrCreate(
                [
                    'email'=>$user->getEmail()
                ],
                [
                    'username' =>  str_replace(' ', '', $user->getName()),
                    'full_name' => $user->getName(),
                    'user_type' => config('famefeet.user_type.fan'),
                    'email_verified_at' => Carbon::now(),
                    'account_status' => config('famefeet.account_status.active'),
                    'is_online' => true,
                ]
            );
            $fan = Fan::updateOrCreate(
                [
                    'user_id'=>$userCreated->id,
                ],
                [
                    'user_id'=>$userCreated->id,
                ]
            );
            $slug = createSlug($userCreated->username,$userCreated->id);
            $userCreated->slug = $slug;
            $userCreated->save();

          $test =  $userCreated->authProviders()->updateOrCreate(
                [
                    'provider'=>$provider,
                    'provider_id'=>$user->getId(),
                ],
                [
                    'avatar'=>$user->getAvatar(),
                    'provider'=>$provider,
                    'provider_id'=>$user->getId(),
                ]
            );
            ;
            $tokenResult = $userCreated->createToken('Personal Access Token');
            $token = $tokenResult->accessToken;
            return redirect(config('famefeet.client_base_url').'auth/social-callback?token='.$token.'&status='.true);
    }
}
