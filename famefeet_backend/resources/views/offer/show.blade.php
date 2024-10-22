@extends('layouts.app', ['page' => __('Show'), 'pageSlug' => 'show'])
@section('content')
    <div>
      <h4>Custom Offer With All Its Media Content</h4>
    </div>
<div class="row">
    <div class="col-md-9">
        <div class="card text-center">
            <h4 style="margin-top: 10px">Custom Offer Media</h4>
             <div class="row" style="margin-left: 20px">
                @foreach ($offer->media as $media)
                    <div class="card" style="width:18rem; margin-left:15px">
                        @if ($offer->content_type == config('famefeet.content_type.videos'))
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
    </div>


    <div class="col-md-3">
        <div class="card text-center" style="margin-top: 20px">
            <div class="card-body">
                <h4 class="card-title">{{ $offer->title }}</h4>
                <p class="card-text">{{ $offer->description }}</p>
                <div class="card-body">
                    <a href="#" class="card-link">Price : {{ $offer->coins }}</a>
                    <a href="#" class="card-link">Quantity : {{ count($offer->media) }}</a>
                  </div>
                {{-- @if($post->lock_media == true)
                      <p>This Post Media is Locked From Posted User</p>
                @endif --}}
                <a href="{{ route('offer.all') }}" class="btn btn-primary">Back</a>
              </div>
        </div>
    </div>
</div>

@endsection
