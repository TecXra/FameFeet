<?php

use App\Models\Celebrity;
use App\Models\ReferUser;
use App\Models\ServiceCharges;
use App\Models\CustomerProfile;
use App\Models\BankAccountDetail;
use App\Models\Shop;
use App\Models\PGFundingSourceProfile;
use Facades\Services\BankAccountDetailService;
use Carbon\Carbon;
use App\Models\User;

if (!function_exists('getBankAccountTypes'))
{
    function getBankAccountTypes() {
        return config('famefeet.bank_account_types');
    }
}


if (!function_exists('getDefaultBankAccountType'))
{
    function getDefaultBankAccountType() {
        return config('famefeet.bank_account_type.checking');
    }
}


if (!function_exists('getPaynoteBaseApiEndPoint'))
{
    function getPaynoteBaseApiEndPoint() {
        $apiEndpoint = config('famefeet.paynote_sandbox_api_endpoint');
        if (config('famefeet.app_env') == 'production') {
            $apiEndpoint = config('famefeet.paynote_api_endpoint');
        }
        return $apiEndpoint;
    }
}


if (!function_exists('getPaynoteCurlRequestHeader'))
{
    function getPaynoteCurlRequestHeader() {
        $headers = [
            'Authorization:' . config('famefeet.paynote_sandbox_secret_key'),
            'Content-Type: application/json',
        ];
        if (config('famefeet.app_env') == 'production') {
            $headers = [
                'Authorization:' . config('famefeet.paynote_secret_key'),
                'Content-Type: application/json',
            ];
        }
        return $headers;
    }
}


if (!function_exists('getPGCustomerProfileByBaDetailId'))
{
    function getPGCustomerProfileByBaDetailId($baDetailId) {
        $pg_customer_profile = CustomerProfile::where('bank_account_detail_id',$baDetailId)->first();
        
        if(isset($pg_customer_profile)){
            return $pg_customer_profile;
        }
        $pg_customer_profile = BankAccountDetailService::createCelebrityPGCustomerProfile(getBankAccountDetailById($baDetailId));
        if(isset($pg_customer_profile['success']) && $pg_customer_profile['success'] == true){
            return $pg_customer_profile['data'];
        }
        return null;
    }
}



if (!function_exists('getBankAccountDetailById'))
{
    function getBankAccountDetailById($baDetailId) {
        return BankAccountDetail::find($baDetailId);
    }
}


if (!function_exists('getPGFundingSourceProfileByBaDetailId'))
{
    function getPGFundingSourceProfileByBaDetailId($baDetailId) {
        
        return PGFundingSourceProfile::where('bank_account_detail_id',$baDetailId)->first();
    }
}


if (!function_exists('getPaynoteCurlRequestPostInstance'))
{
    function getPaynoteCurlRequestPostInstance($requestData,$endPoint) {
        $ch = curl_init(getPaynoteBaseApiEndPoint().'/'.$endPoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, getPaynoteCurlRequestHeader());
        return $ch;
    }
}



if (!function_exists('errorResponse'))
{
    function errorResponse($data,$code=500) {
        return response()->json($data,$code);
    }
}


if (!function_exists('parseValidatorErrorResponse'))
{
    function parseValidatorErrorResponse($data) {
        $response_data = json_decode($data, true);
        $first_error_message = null;
        foreach ($response_data as $key => $value) {
            if (is_array($value) && count($value) > 0) {
                $first_error_message = $value[0];
                break;
            }
        }

        return $first_error_message;
    }
}




if (!function_exists('parsePGErrorResponse'))
{
    function parsePGErrorResponse($error) {
        if(isset($error['messages'])){
            return $error['messages'][0];
        }
        if(isset($error['message'])){
            return $error['message'];
        }
        return null;
    }
}







if (!function_exists('getFormatedErrorResponse'))
{
    function getFormatedErrorResponse($errMsg,$code=500) {
        return ['error'=>true,'message'=>$errMsg,'code'=>$code];
    }
}

if (!function_exists('getFormatedSuccessResponse'))
{
    function getFormatedSuccessResponse($data) {
        return ['success'=>true,'data'=>$data];
    }
}


if (!function_exists('sendPaynoteErrorLogToAdmins'))
{
    function sendPaynoteErrorLogToAdmins($error,$subjectText='') {
        $admins = User::where('user_type', config('famefeet.user_type.admin'))->where('account_status', config('famefeet.account_status.active'))->get();
        $subject = 'Famefeet Paynote error ' . Carbon::now()->toDateTimeString();
        if($subjectText != ''){
            $subject = $subject.' :: '.$subjectText;
        }
        foreach ($admins as $key => $admin) {
            \Mail::raw($error, function ($message) use ($admin, $subject)  {
                $message->to($admin->email)
                ->subject($subject);
            });
        }
        return true;
    }
}


//  $user_id= $bankAccountDetail->user_id;
//         $clebUser = User::find($user_id);
//         $fullName = $clebUser->full_name;
//         $email = $clebUser->email; 
//         // API endpoint for creating a new user
//         if (config('famefeet.app_env') == 'production') {
//             $apiEndpoint = config('famefeet.paynote_api_endpoint') . '/user';
//             $headers = [
//                 'Authorization:' . config('famefeet.paynote_secret_key'), // Replace with your actual API token
//                 'Content-Type: application/json',
//             ];
//         }
//         else
//         {
//             $apiEndpoint = config('famefeet.paynote_sandbox_api_endpoint') . '/user';
//             $headers = [
//                 'Authorization:' . config('famefeet.paynote_sandbox_secret_key'), // Replace with your actual API token
//                 'Content-Type: application/json',
//             ];
//         }
//         // Data for the user creation request
//         // $requestData = [
//         //     'user_id' => $userId,

//         //     // Add any other required parameters based on the API documentation
//         // ];
//         $requestData = [
//             // 'user_id' => $user_id, // Replace with the actual recipient name
           
//            'email' => $email,
//            'firstName' => $fullName,
//            'lastName' => "celebrity",
//         ];
    
//         // Convert the request data to JSON format
//         $requestDataJson = json_encode($requestData);
   
//         // Initialize cURL session
//         $ch = curl_init($apiEndpoint);
    
//         // Set cURL options for the user creation request
//         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
//         curl_setopt($ch, CURLOPT_POSTFIELDS, $requestDataJson);
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
//         // Execute cURL session and get the response
//         $response = curl_exec($ch);
    
//         // Check for cURL errors
//         if (curl_errno($ch)) {
//             // Handle the error, e.g., log it or return an error response
//             return false;
//         }
    
//         // Close cURL session
//         curl_close($ch);
    
//         // Process the API response
//         $responseData = json_decode($response, true);
       
//         // Check if the response is successful
//         if (isset($responseData['success']) && $responseData['success'] === true) {
//             $userDetails = $responseData['user'];
          
//             if (isset($userDetails['user_id'])) {
//                 $gatewayUserId = $userDetails['user_id'];

// //

//                  CustomerProfile::create([
//                     //   'user_id' => $user_id,          // Assuming this is the user's ID in your system
//                       'customer_id' => $gatewayUserId,
//                       'user_id' => $bankAccountDetail->user_id,
//                       'payment_gateway' => 'paynote',
//                       'bank_account_detail_id'=> $bankAccountDetail->id,
//                       ]);
//             }
                 
//             return true; // User creation successful
//         } else {
//             // Handle API error, e.g., log it or return an error response
//             return false;
//         }


