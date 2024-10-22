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
                @foreach ($celebritySendOffer->media as $media)
                    <div class="card" style="width:18rem; margin-left:15px">
                        @if ($celebritySendOffer->content_type == config('famefeet.content_type.videos'))
                        <video width="320" height="240" controls preload="none">
                            <source src="{{ asset($media->file_path) }}" type="video/mp4">
                          </video>

                        <video width="100%" height="264" controls preload="none">
                            <source src="/{{ $media->file_path }}" type="video/mp4">
                            <source src="/{{ $media->file_path }}" type="video/ogg" />
                            Your browser does not support the video tag.
                        </video>
                        
                        @else
                           <img class="card-img-top" src="/{{ $media->file_path }}" alt="Card image cap" height="360px">
                        @endif

                    </div>

                @endforeach
            </div>
        </div>
    </div>


    <div class="col-md-3">
        <div class="card text-center" style="margin-top: 20px">
            <div class="card-body">
                <h4 class="card-title">{{ $celebritySendOffer->title }}</h4>
                <p class="card-text">{{ $celebritySendOffer->description }}</p>
                <div class="card-body">
                    <a href="#" class="card-link">Price : {{ $celebritySendOffer->price }}</a>
                    <a href="#" class="card-link">Quantity : {{ count($celebritySendOffer->media) }}</a>
                </div>
                <!-- <a href="{{ route('single.celebrity.offers.to.fan',$celebritySendOffer->celebrity_id) }}" class="btn btn-primary">Back</a> -->

                <a href="javascript:history.back()" class="btn btn-primary">Back</a>

            </div>
        </div>
    </div>
</div>

@endsection
