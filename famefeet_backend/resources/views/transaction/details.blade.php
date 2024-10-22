@extends('layouts.app', ['page' => __('Transaction Details'), 'pageSlug' => 'details'])
@section('content')

<div class="col-md-9">
            <div class="card card-user">
                <div class="card-body">
                    <p class="card-text">
                        <div class="author">
                            <div class="block block-one"></div>
                            <div class="block block-two"></div>
                            <div class="block block-three"></div>
                            <div class="block block-four"></div>
                            <h4>Transaction Details</h4>
                        </div>
                    </p>
                    <hr style="background:aliceblue">
                    <div style="text-align:center" class="mt-2">
                        <div class="mt-4">
                            <h5>Total Amount</h5>
                            <p style="color: #a8729a;font-size:18px;margin-top: -10px;">{{ $transaction->to_amount }} $</p>
                        </div>
                        <div class="mt-4">
                            <h5>Sender</h5>
                            @if($transaction->sender_user_id == config('famefeet.platform_name.gateway'))
                                    <p style="color: #a8729a;font-size:18px;margin-top: -10px;">Gateway<p>
                            @else
                                <p style="color: #a8729a;font-size:18px;margin-top: -10px;"><img src="/{{ $transaction->senderUser->avatar }}" alt=""
                                    style="border-radius: 5.2857rem;
                                    width: 30px;">
                                    {{ $transaction->senderUser->email ."(". $transaction->senderUser->user_type_name. ")" }}
                                </p>
                            @endif
                        </div>
                        <div class="mt-4">
                            <h5>Recipient</h5>
                            @if ($transaction->receiver_user_id == config('famefeet.platform_name.gateway'))
                                <p style="color: #a8729a;font-size:18px;margin-top: -10px;">Gateway</p>
                            @else
                                <p style="color: #a8729a;font-size:18px;margin-top: -10px;"> <img src="/{{ $transaction->receiverUser->avatar }}" alt=""
                                    style="border-radius: 5.2857rem;
                                    width: 30px;">
                                {{ $transaction->receiverUser->email ."(". $transaction->receiverUser->user_type_name .")" }}
                                </p>
                            @endif
                        </div>
                        <div class="mt-4">
                            <h5>Transaction ID</h5>
                            <p style="color: #a8729a;font-size:18px;margin-top: -10px;">{{ $transaction->transaction_id ?? "---" }} </p>
                        </div>
                        <div class="mt-4">
                            <h5>Transaction Type</h5>
                            <p style="color: #a8729a;font-size:18px;margin-top: -10px;">{{ getLogTypeName($transaction->log_type)}} </p>
                        </div>
                    </div>
                    <hr style="background:aliceblue" class="mt-4">
                    <div class="row mt-2" style="padding: 20px;">
                        <div class="col-md-3">
                            <h5>Transaction Date</h5>
                            <p style="color: #a8729a;font-size:18px;margin-top: -10px;">
                                {{ date("F j, Y, g:i a", strtotime($transaction->created_at)) }}
                            </p>
                        </div>
                        <div class="col-md-3" style="border-left: 1px solid;">
                            <h5>Transfer amount</h5>
                            <p style="color: #a8729a;font-size:18px;margin-top: -10px;">{{ $transaction->celebrity_charges_price }} $</p>
                        </div>
                        <div class="col-md-3" style="border-left: 1px solid;">
                            <h5>Service Charges</h5>
                            <p style="color: #a8729a;font-size:18px;margin-top: -10px;">{{ $transaction->service_charges_price }} $</p>
                        </div>
                        <div class="col-md-3" style="border-left: 1px solid;">
                            <h5>Exchange Rate</h5>
                            <p style="color: #a8729a;font-size:18px;margin-top: -10px;">{{ $transaction->exchange_rate }} $</p>
                        </div>
                    </div>
                    <hr style="background:aliceblue" class="mt-2">
                    @if($transaction->referral_table_name == 'posts')
                    <div style="padding-left: 20px;" class="mt-2">
                        <h4 style="color: #a8729a;">Content:</h4>
                        <h5>Title: {{ $transaction->post->title }}</h5>
                        <div class="row">
                            @foreach ($transaction->post->media as $media)
                                <div class="card" style="width:18rem; margin-left:15px">
                                    @if ($transaction->post->content_type == config('famefeet.content_type.videos'))
                                    <video width="320" height="240" controls>
                                        <source src="/{{ $media->file_path }}" type="video/mp4">
                                    </video>
                                    @else
                                    <img class="card-img-top" src="/{{ $media->file_path }}" alt="Card image cap">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    {{-- shop item --}}
                    @if ($transaction->referral_table_name == 'shops')
                    <div style="padding-left: 20px;" class="mt-2">
                        <h5 style="color: #a8729a;">Shop Item:</h5>
                        <h5>Title: {{ $transaction->shop->title }}</h5>
                        <div class="row">
                            @foreach ($transaction->shop->media as $media)
                                <div class="card" style="width:18rem; margin-left:15px">
                                    <img class="card-img-top" src="/{{ $media->file_path }}" alt="Card image cap">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    {{-- offer --}}
                    @if ($transaction->referral_table_name == 'offers')
                    <div style="padding-left: 20px;" class="mt-2">
                        <h4 style="color: #a8729a;">Offer Content:</h4>
                        <h5>Title: {{ $transaction->offer->title }}</h5>
                        <div class="row">
                            @foreach ($transaction->offer->media as $media)
                                <div class="card" style="width:18rem; margin-left:15px">
                                    @if ($transaction->offer->content_type == config('famefeet.content_type.videos'))
                                    <video width="320" height="240" controls>
                                        <source src="/{{ $media->file_path }}" type="video/mp4">
                                    </video>
                                    @else
                                    <img class="card-img-top" src="/{{ $media->file_path }}" alt="Card image cap">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    {{-- celebrity send offer  --}}
                    @if ($transaction->referral_table_name == "celebrity_send_offers")
                    <div style="padding-left: 20px;" class="mt-2">
                        <h5 style="color: #a8729a;">Celebrity Offer Content</h5>
                        <h5>Title: {{ $transaction->celebritySendOffer->title }}</h5>
                        <div class="row">
                            @foreach ($transaction->celebritySendOffer->media as $media)
                                <div class="card" style="width:18rem; margin-left:15px">
                                    @if ($transaction->celebritySendOffer->content_type == config('famefeet.content_type.videos'))
                                    <video width="320" height="240" controls>
                                        <source src="/{{ $media->file_path }}" type="video/mp4">
                                    </video>
                                    @else
                                    <img class="card-img-top" src="/{{ $media->file_path }}" alt="Card image cap">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    {{-- user Card details --}}
                    @if ($transaction->transaction_id != null && $transaction->referral_table_name == null)

                      <h4 style="padding-left: 20px; color: #a8729a;">User Card Details:</h4>
                      <div class="row mt-2" style="padding-left: 20px;">
                        <div class="col-md-3">
                            <h5>Transaction ID</h5>
                            <p style="color: #a8729a;font-size:18px;margin-top: -10px;">
                                {{ $transaction->transaction_id }}
                            </p>
                        </div>
                        <div class="col-md-3" style="border-left: 1px solid;">
                            <h5>Customer Payment Profile ID</h5>
                            <p style="color: #a8729a;font-size:18px;margin-top: -10px;">{{ $transaction->transactionLog->userCardDetail->customer_payment_profile_id }} </p>
                        </div>
                        <div class="col-md-3" style="border-left: 1px solid;">
                            <h5>Card Holder Name</h5>
                            <p style="color: #a8729a;font-size:18px;margin-top: -10px;">{{ $transaction->transactionLog->userCardDetail->card_holder_name }} </p>
                        </div>
                        <div class="col-md-3" style="border-left: 1px solid;">
                            <h5>Card Number</h5>
                            <p style="color: #a8729a;font-size:18px;margin-top: -10px;">XXXXXXXXXXXX{{ $transaction->transactionLog->userCardDetail->card_number }} </p>
                        </div>
                    </div>
                    @endif
                    <hr style="background:aliceblue;margin-bottom: 65px;" class="mt-4">
                </div>
            </div>
        </div>
@endsection
