@extends('layouts.app', ['page' => __('Show'), 'pageSlug' => 'show'])


@section('content')
   <div class="row">
        <div class="col-md-6">
            @if(isset($fan->user))
            <img src="/{{ $fan->user->avatar }}" alt="img" width="100px" height="100px"
            style="border: 4px solid;
                   border-radius: 70px;">
            @endif
            <p class= "mt-2 ml-2">{{ $fan->user->username }}</p>
            <a class="ml-2" href="">{{ $fan->user->email }}</a>
        </div>
        <div class="col-md-6" >
            <img src="{{ asset('black/img/wallet.png') }}" alt="" width="90px" height="90px">
            <p class="mt-2">Total FameFeet Coins : {{ $fan->user->wallet->total_coins ?? 0 }} </p>
            <p class="mt-2">Available FameFeet Coins : {{ $fan->user->wallet->available_coins ?? 0 }} </p>
        </div>
   </div>
   <div>
    @include('fan.navbar')
    @yield('fansection')
   </div>
@endsection
