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
                    <h5 class="title">{{ __('Edit Post') }}</h5>
                </div>
            @if(session()->get('success'))
                <div class="alert alert-success">
                  {{ session()->get('success') }}
                </div><br />
              @endif
                <form method="post" action="{{ route('post.update',$post->id) }}" autocomplete="off">
                    <div class="card-body">
                            @csrf
                            @method('put')
                                <div class="mb-3">
                                  <label for="exampleInputEmail1" class="form-label">Title</label>
                                  <input type="text" name="title" value="{{ $post->title }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">

                                </div>

                                  <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Price</label>
                                    <input type="text" name="price" value="{{ $post->price }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Description</label>
                                        <input type="text" name="description" value="{{ $post->description }}" class="form-control" >
                                      </div>
                                  </div>
                                  <div class="mb-3">
                                    <select name="category_id[]" class="form-control"  multiple>
                                        @foreach ($categories as $category)
                                            <option  value="{{ $category->id }}">{{ $category->text }}</option>
                                        @endforeach
                                        </select>
                                </div>


                                <button type="submit" class="btn btn-primary" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
