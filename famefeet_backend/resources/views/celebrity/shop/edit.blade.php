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
                    <h5 class="title">{{ __('Edit Shop Item') }}</h5>
                </div>
            @if(session()->get('success'))
                <div class="alert alert-success">
                  {{ session()->get('success') }}
                </div><br />
              @endif
                <form method="post" action="{{ route('celebrity.shop.update',$shop->id) }}" autocomplete="off">
                    <div class="card-body">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Title :</label>
                                <input type="text" name="title" value="{{ $shop->title }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">

                              </div>

                                <div class="mb-3">
                                  <label for="exampleInputEmail1" class="form-label">Price :</label>
                                  <input type="text" name="price" value="{{ $shop->price }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                  <div class="mb-3">
                                      <label for="exampleInputEmail1" class="form-label">Description :</label>
                                      <input type="text" name="description" value="{{ $shop->description }}" class="form-control" >
                                    </div>
                                   </div>
                                   <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Shop Item Quantity :</label>
                                    <input type="text" name="quantity" value="{{ $shop->quantity }}" class="form-control" disabled>
                                  </div>
                                  <div class="mb-3">
                                  <label for="exampleInputEmail1" class="form-label">Selected Condition :</label>
                                  <select name="condition" id="gender" class="form-control" disabled>
                                      <option style="background:rgb(33, 32, 32)" value="{{ $shop->condition }}" selected >{{ $shop->condition }}</option>
                                      <option style="background:rgb(33, 32, 32)" value="old">Old</option>
                                      <option style="background:rgb(33, 32, 32)" value="new">New</option>
                                  </select>
                                  </div>
                                 </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
