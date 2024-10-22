
@extends('fan.show')
@section('fansection')

<div class="row mt-2">
  <div class="col-md-12">
    <div class="col-5">
        @if(session()->get('success'))
            <div class="alert alert-success">
                <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                <i class="tim-icons icon-simple-remove"></i>
                </button>
                <span>
                <b> {{ session()->get('success') }}
                </span>
            </div>
        @endif
        @if(session()->get('error'))
            <div class="alert alert-danger">
            <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                <i class="tim-icons icon-simple-remove"></i>
            </button>
            <span>
                <b> {{ session()->get('error') }}
            </span>
            </div>
        @endif
    </div>
    <div class="card ">
      <div class="card-header">
        <h4 class="card-title">All Shop Items Orders</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table tablesorter ">
            <thead class=" text-primary">
              <tr>
                <th>name</th>
                <th>Mobile Number</th>
                <th>Address</th>
                <th>Total Price</th>
                <th>Shiping Charges</th>
                <th>Amount Of Celebrity</th>
                <th>Service Charges</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($subOrders as $subOrder)
                <tr>
                <td>{{$subOrder->name}}</td>
                <td>{{ $subOrder->mobile_number }}</td>
                {{-- {{ $subOrder->address_line_one }} --}}
                <td>{{(Str::length($subOrder->address_line_one) > 30) ? Str::substr($subOrder->address_line_one, 0,30).'...':$subOrder->address_line_one}}</td>

                <td>{{$subOrder->total_price}}</td>
                <td>{{$subOrder->shipping_charges}}</td>
                <td>{{$subOrder->celebrity_charges_price + $subOrder->shipping_charges}}</td>
                <td>{{ $subOrder->service_charges_price }}</td>
                <td>{{ $subOrder->status }}</td>
                <td>{{date("F j, Y", strtotime($subOrder->created_at))}}</td>
                <td>
                  @if($subOrder->status == 'deliver')
                    <a href="{{ route('celebrity.complete.order',$subOrder->id) }}" class="btn-sm btn-primary">Complete</a>
                  @endif
                    <a href="{{ route('celebrity.order.detail',$subOrder->id) }}" class="btn-sm btn-success">Details</a>
                </td>
                </tr>
                @endforeach
            </tbody>
          </table>
          {{ $subOrders->links('pagination::bootstrap-4'); }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
