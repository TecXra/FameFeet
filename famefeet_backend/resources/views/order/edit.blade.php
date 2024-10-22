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
                    <h5 class="title">{{ __('Edit Fan') }}</h5>
                </div>
            @if(session()->get('success'))
                <div class="alert alert-success">
                  {{ session()->get('success') }}
                </div><br />
              @endif
                <form method="post" action="{{ route('order.update',$order->id) }}" autocomplete="off">
                    <div class="card-body">
                            @csrf
                            @method('put')
                                <div class="mb-3">
                                  <label for="exampleInputEmail1" class="form-label">User Name :</label>
                                  <input type="text" name="name" value="{{ $order->name }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">

                                </div>

                                  <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Phone Number :</label>
                                    <input type="text" name="phone_number" value="{{ $order->phone_number }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Country :</label>
                                    <input type="text" name="country" value="{{ $order->country }}" class="form-control" >
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">State :</label>
                                    <input type="text" name="state" value="{{ $order->state }}" class="form-control" >
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">City :</label>
                                    <input type="text" name="city" value="{{ $order->city }}" class="form-control" >
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Zipcode :</label>
                                    <input type="text" name="zipcode" value="{{ $order->zipcode }}" class="form-control" >
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Address :</label>
                                    <input type="text" name="address" value="{{ $order->address }}" class="form-control" >
                                </div>


                                  <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Change Order Status :</label>
                                    <select name="status" id="status" class="form-control">
                                        <option style="background:rgb(33, 32, 32)" value="{{ $order->status }}" selected >{{ $order->status }}</option>
                                        <option style="background:rgb(33, 32, 32)" value="pending">Pending</option>
                                        <option style="background:rgb(33, 32, 32)" value="in_progress">In Progress</option>
                                        <option style="background:rgb(33, 32, 32)" value="complete">Complete</option>
                                        <option style="background:rgb(33, 32, 32)" value="cancel">Cancel</option>
                                    </select>
                                  </div>
                                <div class="mb-3">

                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
