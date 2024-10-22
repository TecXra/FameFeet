@extends('layouts.app', ['page' => __('Order'), 'pageSlug' => 'order'])
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>


@section('content')
<div class="row">
    <div class="col-md-9">
        <form action="" class="form-inline">
            <input class="form-control mr-sm-2" type="search" name="search" value="{{ $search }}" placeholder="Search" aria-label="Search" style="width: 60%">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
    </div>

  <div class="col-md-12">
    <div class="col-5">
        @if(session()->get('success'))
        <div class="alert alert-success">
            <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
              <i class="tim-icons icon-simple-remove"></i>
            </button>
            <span>
              <b> {{ session()->get('success') }}</span>
          </div>
      @endif
    </div>
    <div class="card ">
      <div class="card-header">
        <h4 class="card-title"> Fans Table</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table tablesorter " id="">
            <thead class=" text-primary">
              <tr>

                <th>Name</th>
                <th>Phone Number</th>
                <th>State</th>
                <th>City</th>
                <th>Address</th>
                <th>Zipcode</th>
                <th>Total Price</th>
                <th>status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>

                @foreach ($orders as $order)

                <tr>
                <td>{{$order->name}}</td>
                <td>{{$order->phone_number}}</td>
                <td>{{ $order->state }}</td>
                <td>{{ $order->city }}</td>
                <td>{{(Str::length($order->address) > 50) ? Str::substr($order->address, 0,50).'...':$order->address}}</td>
                <td>{{$order->zipcode}}</td>
                <td>{{ $order->total_coins }}</td>
                <td>{{ $order->status }}</td>
                <td>
                    <a href="{{ route('order.edit',$order->id) }}" class="btn-sm btn-primary">Edit</a>
                      <!-- <button type="button" width="40px" height = "20px" class="btn-sm btn-danger servideletebtn">Remove</button> -->
                    <a href="{{ route('order.show',$order->id) }}" class="btn-sm btn-success">Details</a>
                </td>
                </tr>
                @endforeach
            </tbody>
          </table>
          {{ $orders->links('pagination::bootstrap-4'); }}
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
