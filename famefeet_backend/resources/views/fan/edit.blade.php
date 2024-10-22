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
                <form method="post" action="{{ route('fan.update',$fan->id) }}" autocomplete="off">
                    <div class="card-body">
                            @csrf
                            @method('put')
                                <div class="mb-3">
                                  <label for="exampleInputEmail1" class="form-label">User Name :</label>
                                  <input type="text" name="username" value="{{ $fan->user->username }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" disabled>

                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Bio :</label>
                                    <input type="text" name="bio" value="{{ $fan->bio }}" class="form-control" >
                                </div>

                                  <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Location :</label>
                                    <input type="text" name="location" value="{{ $fan->location }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                  </div>
                                  <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Selected Gender :</label>
                                    <select name="gender" id="gender" class="form-control">
                                        <option style="background:rgb(33, 32, 32)" value="{{ $fan->gender }}" selected >{{ $fan->gender }}</option>
                                        <option style="background:rgb(33, 32, 32)" value="male">Male</option>
                                        <option style="background:rgb(33, 32, 32)" value="female">Female</option>
                                        <option style="background:rgb(33, 32, 32)" value="trans">Transgender</option>
                                        <option style="background:rgb(33, 32, 32)" value="nonbinary">Nonbinary</option>
                                    </select>
                                  </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">User Type</label>
                                    <select class="form-control" id="type" name="user_type">
                                        <option value="2" {{ $fan->user->user_type == 2 ? 'selected' : '' }}>Fan</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
