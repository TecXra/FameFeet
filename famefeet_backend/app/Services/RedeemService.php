<?php
namespace Services;

use App\Models\BankAccountDetail;
use App\Models\CoinLog;
use App\Models\Redeem;
use App\Models\CustomerProfile;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;


class RedeemService{

    public static function saveRedeemRequest($amount,$userId){
        $redeem = new Redeem();
        $redeem->coins = $amount;
        $redeem->user_id = $userId;
        $redeem->status = false;
        $redeem->save();
        return $redeem;
    }
    private static function createUserInGateway($bankAccountDetail,$requestObj)
    {
        $user_id= $bankAccountDetail->user_id;
        $clebUser = User::find($user_id);
        $fullName = $clebUser->full_name;
        $email = $clebUser->email; 
        // API endpoint for creating a new user
        if (config('famefeet.app_env') == 'production') {
            $apiEndpoint = config('famefeet.paynote_api_endpoint') . '/user';
            $headers = [
                'Authorization:' . config('famefeet.paynote_secret_key'), // Replace with your actual API token
                'Content-Type: application/json',
            ];
        }
        else
        {
            $apiEndpoint = config('famefeet.paynote_sandbox_api_endpoint') . '/user';
            $headers = [
                'Authorization:' . config('famefeet.paynote_sandbox_secret_key'), // Replace with your actual API token
                'Content-Type: application/json',
            ];
        }
        // Data for the user creation request
        // $requestData = [
        //     'user_id' => $userId,

        //     // Add any other required parameters based on the API documentation
        // ];
        $requestData = [
            // 'user_id' => $user_id, // Replace with the actual recipient name
           
           'email' => $email,
           'firstName' => $fullName,
           'lastName' => "celebrity",
        ];
    
        // Convert the request data to JSON format
        $requestDataJson = json_encode($requestData);
   
        // Initialize cURL session
        $ch = curl_init($apiEndpoint);
    
        // Set cURL options for the user creation request
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestDataJson);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        // Execute cURL session and get the response
        $response = curl_exec($ch);
    
        // Check for cURL errors
        if (curl_errno($ch)) {
            // Handle the error, e.g., log it or return an error response
            return false;
        }
    
        // Close cURL session
        curl_close($ch);
    
        // Process the API response
        $responseData = json_decode($response, true);
       
        // Check if the response is successful
        if (isset($responseData['success']) && $responseData['success'] === true) {
            $userDetails = $responseData['user'];
          
            if (isset($userDetails['user_id'])) {
                $gatewayUserId = $userDetails['user_id'];

//

                 CustomerProfile::create([
                    //   'user_id' => $user_id,          // Assuming this is the user's ID in your system
                      'customer_id' => $gatewayUserId,
                      'user_id' => $bankAccountDetail->user_id,
                      'payment_gateway' => 'paynote',
                      'bank_account_detail_id'=> $bankAccountDetail->id,
                      ]);
            }
                 
            return true; // User creation successful
        } else {
            // Handle API error, e.g., log it or return an error response
            return false;
        }
    }
    public static function sendDirectDeposit($id,$bankAccountDetail, $requestObj)
    {
        $clebUser = User::find($bankAccountDetail->user_id);
        $dateAndTime =Carbon::now()->toDateTimeString();
        // $description = "Payment sent into ".$clebUser->full_name." $dateAndTime";
        $description = "Payment sent to ".$clebUser->full_name." $dateAndTime";
        $userExists = CustomerProfile::where('user_id',$bankAccountDetail->user_id)
        ->where('payment_gateway', 'paynote')->where('bank_account_detail_id',$bankAccountDetail->id)->first();
        $requestData = [
            'recipient' => $clebUser->email, 
            'name' => $clebUser->full_name, 
            'description' => $description,
            "bank_account_number"=> $bankAccountDetail->account_number,
            "routing_number"=> $bankAccountDetail->routing_number,
            "bank_account_type"=> $bankAccountDetail->account_type,
            'amount' => $requestObj->coins
        ];
        $mail_message = null;

        $adminUsersList = User::where('user_type', config('famefeet.user_type.admin'))->where('account_status', config('famefeet.user_type.account_status'))->get();
        //end new code

        if (config('famefeet.app_env') == 'production') {
            $apiEndpoint = config('famefeet.paynote_api_endpoint') . '/check/send';
            $headers = [
                'Authorization:' . config('famefeet.paynote_secret_key'), // Replace with your actual API token
                'Content-Type: application/json',
            ];
        }
        else
        {
            $apiEndpoint = config('famefeet.paynote_sandbox_api_endpoint') . '/check/send';
            $headers = [
                'Authorization:' . config('famefeet.paynote_sandbox_secret_key'), // Replace with your actual API token
                'Content-Type: application/json',
            ];
        }

        if ($userExists) {
            $clebUser = User::find($bankAccountDetail->user_id);
            if ($clebUser) {
                $dateAndTime =Carbon::now()->toDateTimeString();
                // $description = "Payment sent into ".$clebUser->full_name." $dateAndTime";
                $description = "Payment sent to " . $clebUser->full_name . " on " . $dateAndTime;
                // Data for the Direct Deposit request
                $requestData = [
                    'recipient' => $clebUser->email,
                    'name' => $clebUser->full_name,
                    'description' => $description,
                    "bank_account_number"=> $bankAccountDetail->account_number,
                    "routing_number"=> $bankAccountDetail->routing_number,
                    "bank_account_type"=> $bankAccountDetail->account_type,
                    'amount' => $requestObj->coins,
                ];
            }else {
                return Redirect::back()->withErrors(['error' => 'User not found!']);
            }
        } else {
            $result = self::createUserInGateway($bankAccountDetail,$requestObj);
        }
    
        
        // Convert the request data to JSON format
        $requestDataJson = json_encode($requestData);
        // return $requestDataJson;
        // Initialize cURL session
        $ch = curl_init($apiEndpoint);
        // Set cURL options for the Direct Deposit request
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestDataJson);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        // return $requestDataJson;
        // Execute cURL session and get the response
        $response = curl_exec($ch);

        $responseData = json_decode($response, true);
        
        // return $responseData['error'];
        // Check for cURL errors
        if (curl_errno($ch)) {
            // Handle the error, e.g., log it or return an error response
            $mail_message = curl_error($ch);

            for ($i=0; $i < count($adminUsersList); $i++) { 
                Mail::raw($mail_message, function ($message) {
                    $message->to($adminUsersList[$i]->email)
                    ->subject('Issues during payment withdrawl');
                });
            }


            return Redirect::back()->with('error', 'cURL Error: ' . curl_error($ch));
        }
        // return $response;
        // Close cURL session
        curl_close($ch);
        // Process the API response
        $responseData = json_decode($response, true);
        // Check if the response is successful

        // return $responseData;
        if (isset($responseData['success']) && $responseData['success'] === true) {
            $userCheckDetail = $responseData['check'];
            if (isset($userCheckDetail['check_id'])) {
                $gatewayCheckId = $userCheckDetail['check_id'];                
                $redeem = Redeem::find($id);
                $redeem->status = 'accepted';
                $redeem->save();
                self::updateCoinLogs($id, $redeem,$gatewayCheckId);
            }
            return Redirect::back()->with('success', 'Direct Deposit sent successfully');
        } else {
            // Handle API error, e.g., log it or return an error response
            $mail_message = $responseData['message'];

            for ($i=0; $i < count($adminUsersList); $i++) { 
                Mail::raw($mail_message, function ($message) {
                    $message->to($adminUsersList[$i]->email)
                    ->subject('Issues during payment withdrawl');
                });
            }

            return Redirect::back()->withErrors($responseData['message']);
            // return Redirect::back()->with('error', 'Direct Deposit sending failed. ' . $responseData['message']);
        }
    }
    public static function creditBankAccount($bankAccountDetail,$requestObj)
    {
        // return $requestObj;
        $merchantAuthentication = PaymentService::merchantCredentional();

        // Set the transaction's refId
        $refId = 'ref' . time();
        $bankAccount = new AnetAPI\BankAccountType();
        $bankAccount->setAccountType($bankAccountDetail->account_type);
        // see eCheck documentation for proper echeck type to use for each situation
        // $bankAccount->setEcheckType('WEB');
        $bankAccount->setRoutingNumber($bankAccountDetail->routing_number); //('122235821'); //('');
        $bankAccount->setAccountNumber($bankAccountDetail->account_number);
        $bankAccount->setNameOnAccount($bankAccountDetail->name_on_account);
        $bankAccount->setBankName($bankAccountDetail->bank_name);

        $paymentBank= new AnetAPI\PaymentType();
        $paymentBank->setBankAccount($bankAccount);
        // Order info
        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber("101");
        $order->setDescription("Golf Shirts");

        //create a bank credit transaction

        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("refundTransaction");
        $transactionRequestType->setAmount($requestObj->coins);
        $transactionRequestType->setPayment($paymentBank);
        $transactionRequestType->setOrder($order);
        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setTransactionRequest($transactionRequestType);
        $controller = new AnetController\CreateTransactionController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
//        return $response;
        if ($response != null) {
            if ($response->getMessages()->getResultCode() == "Ok") {
                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getMessages() != null) {
                    // $result = [
                    //     "Transaction Response code" => $tresponse->getResponseCode(),
                    //     "Credit Bank Account AUTH CODE" =>  $tresponse->getAuthCode(),
                    //     "Credit Bank Account TRANS ID"  => $tresponse->getTransId(),
                    //     "Code" => $tresponse->getMessages()[0]->getCode(),
                    //     "Description" => $tresponse->getMessages()[0]->getDescription()

                    // ];

                    return Redirect::back()->with('success',$tresponse->getMessages()[0]->getDescription());

                } else {
                    // if($tresponse->getErrors() != null){
                    //     $result = [
                    //         "message" => "Transaction Failed",
                    //         "Error code" => $tresponse->getErrors()[0]->getErrorCode(),
                    //         "Error message" => $tresponse->getErrors()[0]->getErrorText(),
                    //      ];
                    //     return $result;
                    // }
                    // return "Transaction Failed";
                    return Redirect::back()->with('error',$tresponse->getErrors()[0]->getErrorText());
                }
            } else {
                $tresponse = $response->getTransactionResponse();
                if ($tresponse != null && $tresponse->getErrors() != null) {
                    // $result = [
                    //     "message" => "Transaction Failed",
                    //     "Error code" => $tresponse->getErrors()[0]->getErrorCode(),
                    //     "Error message" => $tresponse->getErrors()[0]->getErrorText(),
                    //  ];
                    // return $result;
                    return Redirect::back()->with('error',$tresponse->getErrors()[0]->getErrorText());
                } else {
                //     $result = [
                //         "message" => "Transaction Failed",
                //         "Error code" =>  $response->getMessages()->getMessage()[0]->getCode() ,
                //         "Error message" => $response->getMessages()->getMessage()[0]->getText(),
                //      ];
                //    return $result;
                   return Redirect::back()->with('error', $response->getMessages()->getMessage()[0]->getText());

                }
                return Redirect::back()->with('error',"Transaction Failed");

            }
        } else {
            return Redirect::back()->with('error',"Transaction Failed");
        }
        return Redirect::back()->with('error',$response);
    }

  public static  function debitBankAccount($requestObj)
    {
        // return $request;
        $amount = $requestObj->coins;
        /* Create a merchantAuthenticationType object with authentication details
            retrieved from the constants file */
        $merchantAuthenticationResult = PaymentService::merchantCredentional();

        // Set the transaction's refId
        $refId = 'ref' . time();

        //Generate random bank account number
        $randomAccountNumber= rand(100000000,9999999999);

        // Create the payment data for a Bank Account
        $bankAccount = new AnetAPI\BankAccountType();
        $bankAccount->setAccountType('checking');
        // see eCheck documentation for proper echeck type to use for each situation
        $bankAccount->setEcheckType('WEB');
        $bankAccount->setRoutingNumber('122000661');

        $bankAccount->setAccountNumber(rand(10000,999999999999));

        $bankAccount->setNameOnAccount('John Doe');
        $bankAccount->setBankName('Wells Fargo Bank NA');

        $paymentBank= new AnetAPI\PaymentType();
        $paymentBank->setBankAccount($bankAccount);

        // Order info
        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber("101");
        $order->setDescription("Golf Shirts");

        //create a bank debit transaction

        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($amount);
        $transactionRequestType->setPayment($paymentBank);
        $transactionRequestType->setOrder($order);
        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($merchantAuthenticationResult);
        $request->setRefId($refId);
        $request->setTransactionRequest($transactionRequestType);
        $controller = new AnetController\CreateTransactionController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

        if ($response != null) {
            if ($response->getMessages()->getResultCode() == "Ok") {
                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getMessages() != null) {
                    return Redirect::back()->with('success',$tresponse->getMessages()[0]->getDescription());
                    // echo " Transaction Response code : " . $tresponse->getResponseCode() . "\n";
                    // echo " Debit Bank Account APPROVED  :" . "\n";
                    // echo " Debit Bank Account AUTH CODE : " . $tresponse->getAuthCode() . "\n";
                    // echo " Debit Bank Account TRANS ID  : " . $tresponse->getTransId() . "\n";
                    // echo " Code : " . $tresponse->getMessages()[0]->getCode() . "\n";
                    // echo " Description : " . $tresponse->getMessages()[0]->getDescription() . "\n";
                } else {
                    return Redirect::back()->with('error',$tresponse->getErrors()[0]->getErrorText());

                    // echo "Transaction Failed \n";
                    // if ($tresponse->getErrors() != null) {
                    //     echo " Error code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
                    //     echo " Error message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";
                    // }
                }
            } else {
                // echo "Transaction Failed \n";
                $tresponse = $response->getTransactionResponse();
                if ($tresponse != null && $tresponse->getErrors() != null) {
                    // echo " Error code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
                    // echo " Error message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";
                   return Redirect::back()->with('error', $tresponse->getMessages()->getMessage()[0]->getText());

                } else {
                    // echo " Error code  : " . $response->getMessages()->getMessage()[0]->getCode() . "\n";
                    // echo " Error message : " . $response->getMessages()->getMessage()[0]->getText() . "\n";
                   return Redirect::back()->with('error', $response->getMessages()->getMessage()[0]->getText());

                }
            }
        } else {
            return Redirect::back()->with('error',"Transaction Failed");
        }

        return Redirect::back()->with('error',$response);
    }

    public static function celebrityWithdrawalRequests($data){
        $id = Auth::user()->id;
        $dates = WalletService::setDates($data);
        $type = $data['type'];;
        $requests = Redeem::where('user_id', $id)
            ->whereBetween('created_at', [$dates[0], $dates[1]])
            ->when($type, function($query) use($type){
                $query->where('status', $type);
            })
            ->get();
//        return $type;
        $celebRequests = [];
        foreach($requests as $request){
            $celebRequests[] = [
                'amount'=>$request['coins'],
                'status'=>$request['status'],
                'req_date'=>$request['created_at']
            ];
        }
        return $celebRequests;
    }

    public static function allWithdrawals($user_id){
        $accepted_reqs = Redeem::where('user_id', $user_id)
            ->where('status', 'accepted')
            ->sum('coins');
        return $accepted_reqs;
    }

    public static function userWithdrawRequestAccept($id){
        $redeem = Redeem::find($id);
        $bankAccountDetail = BankAccountDetail::find($redeem->bank_account_detail_id);
        // $result = self::creditBankAccount($bankAccountDetail,$redeem);
        $result = self::sendDirectDeposit($id,$bankAccountDetail,$redeem);
      
        //   $gatewayCheckId= $result;
         
        // if($result){
        //     $redeem->status = 'accepted';
        //     $redeem->save();

        // }
        //  self::updateCoinLogs($id, $redeem,$gatewayCheckId);
         return $result;
    }

    public static function autoAcceptWithdrawRequest(){
        $redeems = Redeem::where('status', 'pending')
            ->get();
        foreach($redeems as $redeem) {
            if($redeem->created_at < Carbon::today()->subDay(3)){
                $bankAccountDetail = BankAccountDetail::find($redeem->bank_account_detail_id);
                $result = self::creditBankAccount($bankAccountDetail, $redeem);
                if ($result) {
                    $redeem->status = 'accepted';
                    $redeem->save();

                }
                self::updateCoinLogs($redeem->id, $redeem);
                return true;
            }

        }
    }

    public static function userWithdrawRequestReject($id){
        $redeem = Redeem::find($id);
        $bankAccountDetail = BankAccountDetail::find($redeem->bank_account_detail_id);
        $redeem->status = 'rejected';
        $redeem->save();
        $gatewayCheckId=null;
        return self::updateCoinLogs($id, $redeem,$gatewayCheckId);
    }


    public static function updateCoinLogs($id, $redeem,$gatewayCheckId){
        
        $exchange_rate = config('famefeet.exchange_rate');
        $bankAccountDetailId = BankAccountDetail::where('user_id', $redeem->user_id)->pluck('id');
        $getUserWallet = Wallet::where('user_id',$redeem->user_id)->first();
                $coinLog = new CoinLog();
                $coinLog->log_type = config('famefeet.log_type.sell_coins');
                $coinLog->to_amount = $redeem->coins;
                $coinLog->to_currency = 'Famefeet Coins';
                $coinLog->from_amount = $redeem->coins / $exchange_rate;
                $coinLog->from_currency = '$';
                $coinLog->service_charges_percentage = 0;
                $coinLog->celebrity_charges_percentage = 100;
                $coinLog->service_charges_price =0;
                $coinLog->celebrity_charges_price =$coinLog->from_amount;
                $coinLog->exchange_rate =$exchange_rate;
                $coinLog->sender_wallet_id =$redeem->status == 'accepted' ? config('famefeet.platform_name.gateway') :$getUserWallet->id;
                $coinLog->sender_user_id =$redeem->status == 'accepted' ?config('famefeet.platform_name.gateway'): $getUserWallet->user_id ;
                $coinLog->receiver_wallet_id = $redeem->status == 'accepted' ?  $getUserWallet->id:config('famefeet.platform_name.gateway');
                $coinLog->receiver_user_id = $redeem->status == 'accepted' ?  $getUserWallet->user_id:config('famefeet.platform_name.gateway');
                $coinLog->referral_table_name = 'redeems';
                $coinLog->referral_table_id = $redeem->id;
                if ($redeem->status == 'accepted') {
                    $coinLog->transaction_id = $gatewayCheckId;
                }
               $coinLog->save();
                $old_available_coins = $getUserWallet->available_coins;
                 $result = $getUserWallet->update([
                //   'available_coins' => $redeem->status == 'accepted' ? $old_available_coins - $redeem->coins: $old_available_coins + $redeem->coins,
                  'available_coins' => $redeem->status == 'accepted' ? $old_available_coins : $old_available_coins + $redeem->coins,

                  ]);
                 return $result;
    }

    public static function userWithdrawRequestPending($dates){
        $coinLogSum = Redeem::whereBetween('created_at', [$dates[0], $dates[1]])
        ->where('status', 'pending')
        ->sum('coins');
        return $coinLogSum;

    }

}

