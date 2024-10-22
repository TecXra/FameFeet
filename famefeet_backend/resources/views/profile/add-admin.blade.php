@extends('layouts.app', ['page' => __('Add Admin'), 'pageSlug' => 'admin'])

@section('content')

        <div class="col-md-4">
            @if(session()->get('addAdmin'))
                <div class="alert alert-success">
                    <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="tim-icons icon-simple-remove"></i>
                    </button>
                    <span>
                    <b> {{ session()->get('addAdmin') }}
                    </span>
                </div>
            @endif
            <div class="card">
                <div class="card-header mt-2" style="text-align:center">
                    <h4 class="title">{{ __('Add New Admin') }}</h4>
                </div>

                <form method="post" action="{{ route('add.admin') }}" autocomplete="off">
                    <div class="card-body">
                        @csrf
                        @method('post')



                        <div class="form-group{{ $errors->has('username') ? ' has-danger' : '' }}">
                            <label>{{ __('Name') }}</label>
                            <input type="text" name="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" >
                            @include('alerts.feedback', ['field' => 'username'])
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <label>{{ __('Email') }}</label>
                            <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Enter Email') }}" value="" required>
                            @include('alerts.feedback', ['field' => 'email'])
                        </div>
                        <div class="form-group{{ $errors->has('phone_number') ? ' has-danger' : '' }}">
                            <label>{{ __('Phone Number') }}</label>
                            <input type="number" name="phone_number" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" placeholder="{{ __('Enter Phone number') }}" value="" required>
                            @include('alerts.feedback', ['field' => 'phone_number'])
                        </div>
                        <div class="form-group{{ $errors->has('date_of_birth') ? ' has-danger' : '' }}">
                            <label>{{ __('Date Of Birth') }}</label>
                            <input type="date" name="date_of_birth" class="form-control{{ $errors->has('date_of_birth') ? ' is-invalid' : '' }}"  value="" required>
                            @include('alerts.feedback', ['field' => 'date_of_birth'])
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <label>{{ __('Password') }}</label>
                            <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" value="" required>
                            @include('alerts.feedback', ['field' => 'password'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Confirm Password') }}</label>
                            <input type="password" name="confirm_password" class="form-control" placeholder="{{ __('Confirm Password') }}"  required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary">{{ __('Add Admin') }}</button>
                    </div>
                </form>
            </div>
        </div>

@endsection
