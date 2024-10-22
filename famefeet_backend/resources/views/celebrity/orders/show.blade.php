@extends('layouts.app', ['page' => __('Show'), 'pageSlug' => 'show'])

@section('content')
<h3>Order Detail Page</h3>
<div>
  <div class="row d-flex justify-content-center align-items-center h-100">
    <div class="col-lg-10 col-xl-8">
      <div class="card" style="border-radius: 10px;">
        <div class="card-header px-4 py-5">
          <h4 class="mb-0">Order Details of , <span style="color: #a8729a;">{{ $subOrder->celebrity->user->username }}</span>!</h4>
        </div>
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 style="color: #a8729a;">Item Details</h4>
            <h5>Buyer : {{ $subOrder->name }}</h5>
          </div>
          @foreach ($subOrder->orderItem as $item)
            <div class="card shadow-0 border mb-4">
                <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                    <img src="/{{ $item->shop->media[0]->file_path }}"
                        class="img-fluid" alt="Phone">
                    </div>
                    <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                    <p class="mb-0">{{ $item->item_name }}</p>
                    </div>
                    <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                        <p class="mb-0">Item Price : ${{ $item->per_item_price }}</p>
                    </div>
                    <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                    <p class="mb-0">Service Charges: ${{ $item->service_charges_price }}</p>
                    </div>
                    <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                    <p class="mb-0">Qty : {{ $item->item_quantity }}</p>
                    </div>
                    <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                    <p class="mb-0">${{ $item->total_price }}</p>
                    </div>
                 </div>
                 <hr class="mb-2" style="background-color: #e0e0e0; opacity: 1;">
                   <p style="color: #a8729a;">Description:</p>
                   <p class="mb-0">{{ $item->item_description }}</p>

                </div>
            </div>
          @endforeach

          <div class="d-flex justify-content-between pt-2">
            <h4 class="mb-0"><span style="color: #a8729a;">Order Details</span></h4>
          </div>

          <div class="d-flex justify-content-between pt-2">
            <p class="mb-0">Status : {{ $subOrder->status }} </p>
            <p class="mb-0"><span class="fw-bold me-4">Shipping Charges : </span>${{ $subOrder->shipping_charges }}</p>
          </div>

          <div class="d-flex justify-content-between">
            <p class="mb-0">
                <span class="fw-bold me-4"> Date : </span>{{date("F j, Y, g:i a", strtotime($subOrder->created_at))}}
            </p>
            <p class="mb-0"><span class="fw-bold me-4">Amount Transfer To Seller : </span>${{ $subOrder->celebrity_charges_price + $subOrder->shipping_charges }}</p>
          </div>

          <div class="d-flex justify-content-between mb-5">
            <p class="mb-0">Traking Number : <a href="#">{{ $subOrder->tracking_number }}</a></p>
            <p class="mb-0"><span class="fw-bold me-4">Service Charges : </span> ${{ $subOrder->service_charges_price }}</p>
            {{-- <p class="mb-0"><span class="fw-bold me-4">Delivery Charges</span> Free</p> --}}
          </div>
        </div>
        <div class="card-footer border-0 px-4 py-5"
          style="background-color: #a8729a; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
          <h3 class="d-flex align-items-center justify-content-end text-white text-uppercase mb-0">Total
            price : <span class="h3 mb-0 ms-2"> ${{ $subOrder->total_price }}</span></h5>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection
