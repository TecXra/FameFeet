<?php

use Illuminate\Support\Carbon;

return [

    'exchange_rate' =>  env('CURRENCY_TO_COINS_EXCHANGE_RATE'),
    'authorize_login_id' => env('AUTHORIZENET_LOGIN_ID'),
    'authorize_transactoin_id'=>env('AUTHORIZENET_TRANSACTION_ID'),

    'paynote_api_endpoint' =>  env('PAYNOTE_API_ENDPOINT'),
    'paynote_publishable_key' =>  env('PAYNOTE_PUBLISHABLE_KEY'),
    'paynote_secret_key' =>  env('PAYNOTE_SECRET_KEY'),

    'paynote_sandbox_api_endpoint' =>  env('PAYNOTE_SANDBOX_API_ENDPOINT'),
    'paynote_sandbox_publishable_key' =>  env('PAYNOTE_SANDBOX_PUBLISHABLE_KEY'),
    'paynote_sandbox_secret_key' =>  env('PAYNOTE_SANDBOX_SECRET_KEY'),

    'percentage_transfer_to_celebrity' => 0.8,
    'percentage_transfer_to_admin' => 20,
    'referral_bonus_percentage' => 10,
    'referral_expire_date' => Carbon::now()->addMonths(6),
    'order_complete_days' => 6,
    'before_auto_subscribe_days' => 6,
    'show_per_page' => 12,

    'app_env' => env('APP_ENV'),

    'client_base_url' => env('CLIENT_BASE_URL'),
    'support_email' => env('SUPPORT_EMAIL'),

    'platform_name' =>  ['gateway'=>0],
    'platform_names' => [
        ['id'=>0,'name'=>'Gateway']
    ],

    'account_status' =>  ['active'=> 1, 'suspend' => 2 , 'block' => 3 , 'deleted' => 4],
    'account_status_names' => [
        ['id'=> 1,'name'=>'Active'],
        ['id'=> 2,'name'=>'Suspend'],
        ['id'=> 3,'name'=>'Block'],
        ['id'=> 4,'name'=>'Deleted'],
    ],

    'log_type' => [
        'send_message_text' => 1,
        'send_tip_text' =>2,
        'receive_tip_text'=>3,
        'place_order_text' =>4,
        'cancel_order' => 5,
        'subscription_text' => 6,
        'renew_subscription' => 7,
        'post_content' => 8,
        'send_offer' => 9,
        'cancel_offer' => 10,
        'buy_coins' => 11,
        'sell_coins' => 12,
        'referral_bonus' => 13,
     ],
     'log_types' => [
        ['id'=>1,'name'=>'Message Charges'],
        ['id'=>2,'name'=>'Tip'],
        ['id'=>3,'name'=>'Received Tip'],
        ['id'=>4,'name'=>'Placed Sock Order'],
        ['id'=>5,'name'=>'Order Refund'],
        ['id'=>6,'name'=>'Bought Subscription'],
        ['id'=>7,'name'=>'Subscription Renewed'],
        ['id'=>8,'name'=>'Bought Post Content'],
        ['id'=>9,'name'=>'Sent Custom Offer '],
        ['id'=>10,'name'=>'Cancel Custom Offer'],
        ['id'=>11,'name'=>'Bought Coins'],
        ['id'=>12,'name'=>'Coins Withdrawn'],
        ['id'=>13,'name' => 'Referral Bonus']
    ],
    [
        'celebrity_log'=>
            ['id'=>2,'name'=>'Tip'],
            ['id'=>7,'name'=>'Subscription Renewed'],
            ['id'=>12,'name'=>'Coins Withdrawn'],
            ['id'=>13,'name' => 'Referral Bonus'],
            ['id'=>5,'name'=>'Order Refund'],
            ['id'=>6,'name'=>'Subscription Purchased'],
            ['id'=>1,'name'=>'Message Charges'],
            ['id'=>4,'name'=>'Placed Sock Order'],
            ['id'=>10,'name'=>'Cancel Custom Offer'],



    ],
    'log_type_sell' => 'sell',
    'log_type_buy' => 'buy',

    'user_type' => ['celebrity'=>1, 'fan'=>2, 'admin'=>9],
    'user_types' => [
        ['id'=>1,'name'=>'Celebrity'],
        ['id'=>2,'name'=>'Fan'],
        ['id'=>9,'name'=>'Admin'],
    ],

    'category_type' => ['old' => 3, 'new'=> 4 ],
    'category_types' => [
              ['id' => 3 , 'name' => 'Old' ],
              ['id' => 4 , 'name' => 'New'],
    ],

    'content_type' => ['images' => 5, 'videos'=> 6 ],
    'content_types' => [
              ['id' => 5 , 'name' => 'Images' ],
              ['id' => 6 , 'name' => 'Videos'],
    ],

    'message_type' => ['subscribe_only' => 0, 'anyone' => 1, 'pay_per_message' => 2 ],
    'message_types' => [
                ['id' => 0, 'name' => 'Subscribe Only'],
                ['id' => 1, 'name' =>'Anyone'],
                ['id' => 2, 'name' => 'Pay Per Message'],
    ],

    'experience_type' => ['mature' => 0, 'beginner' => 1, 'professional' => 2],
    'experience_types' =>[
        ['id' => 0, 'name' => 'Mature'],
        ['id' => 1, 'name' => 'Beginner'],
        ['id' => 2, 'name' => 'Professional'],
    ],

    'notification_type' => ['email' => 0, 'text' => 1, 'both' => 2],
    'notification_types' =>[
        ['id' => 0, 'name' => 'Email'],
        ['id' => 1, 'name' => 'Text'],
        ['id' => 2, 'name' => 'Both'],
    ],

    'offer_type' => ['subscribers_only' => 0, 'anyone' => 1],
    'offer_types' =>[
        ['id' => 0, 'name' => 'Subscribers Only'],
        ['id' => 1, 'name' => 'Anyone'],
    ],

    'review_type' => ['offer' => 1, 'shop' => 2, 'order_item' => 3],
    'review_types' =>[
        ['id' => 1, 'name' => 'Offer'],
        ['id' => 2, 'name' => 'Shop'],
        ['id' => 3, 'name' => 'Sub Order'],
    ],

    // 'currency_type' => ['fame'=>1, 'fan'=>2, 'admin'=>9],
    // 'currency_types' => [
    //     ['id'=>1,'name'=>'Celebrity'],
    //     ['id'=>2,'name'=>'Fan'],
    //     ['id'=>9,'name'=>'Admin'],
    // ],


    'bank_account_types' => ['saving','checking'],
    'bank_account_type' => ['saving' => 'saving', 'checking' => 'checking'],

    'redeem_request_status_list'=>['pending','accepted','rejected'],
    'redeem_request_status'=>['pending'=>'pending','accepted'=>'accepted','rejected'=>'rejected'],
];
