@extends('layouts.app',['page' => __('Edit '), 'pageSlug' => 'edit'])

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
                    <h5 class="title">{{ __('Edit Socks Size') }}</h5>
                </div>
            @if(session()->get('success'))
                <div class="alert alert-success">
                  {{ session()->get('success') }}
                </div><br />
              @endif
                <form method="post" action="{{ route('socks.update',$socks->id) }}" autocomplete="off">
                    <div class="card-body">
                            @csrf
                            @method('put')
                                <div class="mb-3">
                                  <label for="exampleInputEmail1" class="form-label">Socks Size :</label>
                                  <input type="text" name="socks_size_name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $socks->socks_size_name }}">
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Gender :</label>
                                    <select class="form-control" id="type" name="gender">
                                        <option style="background:rgb(33, 32, 32)" value="male" {{ $socks->gender == 'male' ? 'selected' : '' }}>Male</option>
                                        <option style="background:rgb(33, 32, 32)" value="female" {{ $socks->gender == 'female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
