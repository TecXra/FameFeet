@extends('layouts.app', ['page' => __('Show'), 'pageSlug' => 'show'])
@section('content')
<div>
    <h4>Shop Item Details</h4>
  </div>
<div class="row">
  <div class="col-md-9">
      <div class="card text-center">
          <h4 style="margin-top: 10px">Shop Item Pics</h4>
           <div class="row" style="margin-left: 20px">
              @foreach ($shop->media as $media)
                  <div class="card" style="width:18rem; margin-left:15px">
                      <img class="card-img-top"src="/{{$media->file_path}}" alt="Card image cap">
                  </div>
              @endforeach
          </div>
      </div>
  </div>
  <div class="col-md-3">
      <div class="card text-center" style="margin-top: 20px">
          <div class="card-body">
              <h4 class="card-title">{{ $shop->title }}</h4>
              <p class="card-text">{{ $shop->description }}</p>
              <div class="card-body">
                  <a class="card-link" style="color: white">Price : {{ $shop->price }}</a>
                  <a class="card-link" style="color: white">Quantity :{{ $shop->quantity }}</a>
              </div>
              <a href="{{ route('single.celebrity.shops',$shop->celebrity_id) }}" class="btn btn-primary">Back</a>
            </div>
      </div>
  </div>
</div>
@endsection
