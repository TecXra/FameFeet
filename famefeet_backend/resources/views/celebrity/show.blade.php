@extends('layouts.app', ['page' => __('Show'), 'pageSlug' => 'show'])


@section('content')
   <div class="row">
        <div class="col-md-6">
            <img src="/{{ $celebrity->user->avatar }}" alt="img" width="100px" height="100px"
            style="border: 4px solid;
                   border-radius: 70px;">
            <p class= "mt-2 ml-2">{{ $celebrity->user->username }}</p>
            <a class="ml-2" href="">{{ $celebrity->user->email }}</a>
        </div>
        <div class="col-md-6" >
            <img src="{{ asset('black/img/wallet.png') }}" alt="" width="90px" height="90px">
            <p class="mt-2">Total FameFeet Coins : {{ $celebrity->user->wallet->total_coins }} </p>
            <p class="mt-2">Available FameFeet Coins : {{ $celebrity->user->wallet->available_coins }} </p>
        </div>
   </div>
   <div>
    @include('celebrity.navbar')
    @yield('subsection')
   </div>
@endsection
