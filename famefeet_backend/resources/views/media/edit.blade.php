@extends('layouts.app',['page' => __('Edit'), 'pageSlug' => 'edit'])

@section('content')
     <div>
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
                <form method="post" action="{{ route('fan.update',$fan->id) }}" autocomplete="off">
                    <div class="card-body">
                            @csrf
                            @method('put')
                                <div class="mb-3">
                                  <label for="exampleInputEmail1" class="form-label">User Name</label>
                                  <input type="text" name="username" value="{{ $fan->user->username }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                </div>
                                  <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Phone Number</label>
                                    <input type="text" name="phone_number" value="{{ $fan->user->phone_number }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Last Name</label>
                                        <input type="text" name="date_of_birth" value="{{ $fan->user->date_of_birth }}" class="form-control" >
                                      </div>
                                  </div>
                                  <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                                    <input type="email" name="email" value="{{ $fan->user->email }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" disabled >
                                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                                  </div>
                                <div class="mb-3">
                                    <select class="form-control" id="type" name="user_type">
                                        <option value="2" {{ $fan->user->user_type == 2 ? 'selected' : '' }}>Fan</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
