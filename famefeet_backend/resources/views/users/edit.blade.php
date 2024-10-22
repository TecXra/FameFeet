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
                    <h5 class="title">{{ __('Edit User') }}</h5>
                </div>
            @if(session()->get('success'))
                <div class="alert alert-success">
                  {{ session()->get('success') }}
                </div><br />
              @endif

                <form id="myForm" method='Post' action="{{ route('user.update',$user->id) }}" autocomplete="off">
                    <div class="card-body">
                            @csrf
                            @method('Put')
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">User Name :</label>
                                <input type="text" name="username" value="{{ $user->username }}" class="form-control" >
                              </div>
                                <div class="mb-3">
                                  <label for="exampleInputEmail1" class="form-label">Email address :</label>
                                  <input type="email" name="email" value="{{ $user->email }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                  <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>

                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">User Type :</label>
                                    <select class="form-control" id="type" name="user_type">
                                        <option  style="background:rgb(33, 32, 32)" value="1" {{ $user->user_type == 1 ? 'selected' : '' }}>Celebrity</option>
                                        <option style="background:rgb(33, 32, 32)"  value="2" {{ $user->user_type == 2 ? 'selected' : '' }}>Fan</option>
                                        <option style="background:rgb(33, 32, 32)"  value="9" {{ $user->user_type == 9 ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
