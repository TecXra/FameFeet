@extends('layouts.app', ['page' => __('Show'), 'pageSlug' => 'show'])
@section('content')
<div>
    <h4>Order With All Details</h4>
  </div>

<div class="col-md-12">
    <div class="card text-center">
        <h4 style="margin-top: 10px">Shop Items</h4>
         <div class="row" style="margin-left: 20px">
            @foreach ($order->orderDetail as $detail)
                <div class="card" style="width:18rem; margin-left:15px">
                    {{-- <p>{{ $detail->shop->title }}</p> --}}
                    <div class="card" style="width: 18rem;">
                        @foreach ($detail->shop->media as $image)
                            @php
                                $images[] = $image->file_path;
                            @endphp
                        @endforeach
                        {{-- {{ $images[0] }} --}}
                        <img class="card-img-top" src="/{{ $images[0] }}" alt="Card image cap">
                        <div class="card-body">
                          <h4 class="card-title">{{ $detail->shop->title }}</h4>
                          <p class="card-text">{{ $detail->shop->description }}</p>
                        </div>
                        <div class="card-body">
                          <a href="#" class="card-link">Price : {{ $detail->item_coins }}</a>
                          <a href="#" class="card-link">Quantity : {{ $detail->quantity }}</a>
                        </div>


                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
