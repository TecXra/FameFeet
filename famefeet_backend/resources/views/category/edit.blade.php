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
                    <h5 class="title">{{ __('Edit Category') }}</h5>
                </div>

                <form method="POST" action="{{route('category.update',$category->id)}}">
                    <div class="card-body">
                            @csrf
                            @method('put')
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Category Name</label>
                                    <input type="text" name="text" value="{{ $category->text }}" class="form-control" >
                                </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
