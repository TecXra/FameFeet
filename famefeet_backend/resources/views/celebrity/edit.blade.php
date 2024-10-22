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
                    <h5 class="title">{{ __('Edit Celebrity') }}</h5>
                </div>
            @if(session()->get('success'))
                <div class="alert alert-success">
                  {{ session()->get('success') }}
                </div><br />
              @endif
                <form method="post" action="{{ route('celebrity.update',$celebrity->id) }}" autocomplete="off">
                    <div class="card-body">
                            @csrf
                            @method('put')
                                <div class="mb-3">
                                  <label for="exampleInputEmail1" class="form-label">User Name :</label>
                                  <input type="text" name="username" value="{{ $celebrity->user->username }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" disabled>

                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Bio :</label>
                                    <input type="text" name="bio" value="{{ $celebrity->bio }}" class="form-control" >
                                  </div>

                              {{-- <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Location :</label>
                                <input type="text" name="location" value="{{ $celebrity->location }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                              </div> --}}
                              <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Selected Gender :</label>
                                <select name="gender" id="gender" class="form-control">
                                    {{-- <option style="background:rgb(33, 32, 32)" value="{{ $celebrity->gender }}" selected >{{ $celebrity->gender }}</option> --}}
                                    <option  style="background:rgb(33, 32, 32)" value="male" {{ $celebrity->gender == 'male' ? "selected" : "" }}>Male</option>
                                    <option style="background:rgb(33, 32, 32)" value="female" {{ $celebrity->gender == 'female' ? "selected" : "" }}>Female</option>
                                    <option style="background:rgb(33, 32, 32)" value="trans" {{ $celebrity->gender == 'trans' ? "selected" : "" }}>Transgender</option>
                                    <option style="background:rgb(33, 32, 32)" value="nonbinary" {{ $celebrity->gender == 'nonbinary' ? "selected" : "" }}>Nonbinary</option>
                                </select>
                              </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">User Type :</label>
                                    <select class="form-control" id="type" name="user_type">
                                        <option value="2" {{ $celebrity->user->user_type == 1 ? 'selected' : '' }}>Celebrity</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Select Categories :</label>
                                    <select name="category_id[]" class="form-control"  multiple>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->text }}</option>
                                        @endforeach
                                        </select>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Feet Size :</label>
                                    <select name="feet_id" class="form-control">
                                        @foreach ($feets as $feet)
                                            <option style="background:rgb(33, 32, 32)" value="{{ $feet->id }}">{{ $feet->size }}</option>
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
