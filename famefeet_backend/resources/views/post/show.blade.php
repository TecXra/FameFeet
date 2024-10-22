@extends('layouts.app', ['page' => __('Show'), 'pageSlug' => 'show'])
@section('content')
    <div>
      <h4>Post With All Its Media Content</h4>
    </div>
<div class="row">
    <div class="col-md-9">
        <div class="card text-center">
            <h4 style="margin-top: 10px">Post Media</h4>
             <div class="row" style="margin-left: 20px">
                @foreach ($post->media as $media)
                    <div class="card" style="width:18rem; margin-left:15px">
                        {{-- {{ $post->content_type }} --}}
                        @if ($post->content_type == config('famefeet.content_type.videos'))
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
                <h4 class="card-title">{{ $post->title }}</h4>
                <p class="card-text">{{ $post->description }}</p>
                <div class="card-body">
                    <a href="#" class="card-link">Price :{{ $post->price }}</a>
                    <a href="#" class="card-link">Quantity :{{ count($post->media) }}</a>
                  </div>
                @if($post->lock_media == true)
                      <p>This Post Media is Locked From Posted User</p>
                @endif
                <a href="{{ route('post.all') }}" class="btn btn-primary">Back</a>
              </div>
        </div>
    </div>
</div>

@endsection
