@extends('layouts.app',['page' => __('Edit'), 'pageSlug' => 'edit'])

@section('content')
     <div>
        @if (count($errors) > 0)
        <div class="alert alert-danger col-md-4">
           <ul>
               @foreach ($errors->all() as $error)
                   <li>{{ $error }}</li>
               @endforeach
           </ul>
        </div>
        @endif
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Edit Testimonial') }}</h5>
                </div>
            @if(session()->get('success'))
              @endif
                <form method="POST" action="{{route('update.testimonial',$testimonial->id)}}">
                    <div class="card-body">
                            @csrf
                            @method('put')
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Name</label>
                                    <input type="text" name="name" value="{{ $testimonial->name }}" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Rating</label>
                                    <input type="number" name="rating" value="{{ $testimonial->rating }}" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Review</label>
                                    <input type="text" name="review" value="{{ $testimonial->review }}" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
