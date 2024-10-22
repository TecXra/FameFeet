@extends('layouts.app', ['page' => __('Shop'), 'pageSlug' => 'shop'])
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>

@section('content')
<div class="row">
    <div class="col-md-9 mb-3">
        <form action="" class="form-inline">
            <input id="myInput" class="form-control mr-sm-2" type="search" name="search" value="" placeholder="Search" aria-label="Search" style="width: 60%">
            {{-- <input class="form-control mr-sm-2" type="search" name="search" value="{{ $search }}" placeholder="Search" aria-label="Search" style="width: 60%"> --}}
            {{-- <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button> --}}
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
        <h4 class="card-title">All Shops</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table tablesorter " id="">
            <thead class=" text-primary">
              <tr>
                <th>Title</th>
                <th>Price</th>
                <th>Description</th>
                <th>Condition</th>
                <th>Quantity</th>
                <th>Shop Listing Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="myTable">
                @foreach ($shops as $shop)
                <tr>
                <td>{{$shop->title}}</td>
                <td>{{$shop->price}}</td>
                <td>{{(Str::length($shop->description) > 50) ? Str::substr($shop->description, 0,50).'...':$shop->description}}</td>
                <td>{{$shop->condition}}</td>
                <td>{{$shop->quantity }}</td>
                <td>{{date("F j, Y, g:i a", strtotime($shop->created_at))}}</td>
                <td>
                    <a href="{{ route('shop.edit', $shop->id) }}" class="btn-sm btn-primary">Edit</a>
                    <a href="{{ route('shop.show',$shop->id) }}" class="btn-sm btn-success">Details</a>
                </td>
                </tr>
                @endforeach
            </tbody>
          </table>
          {{ $shops->links('pagination::bootstrap-4'); }}
        </div>
      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function(){
      $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
</script>
@endsection
