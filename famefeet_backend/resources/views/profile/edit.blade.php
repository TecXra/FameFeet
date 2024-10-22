@extends('layouts.app', ['page' => __('User Profile'), 'pageSlug' => 'profile'])

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="display: flex;justify-content: space-between;">
                    <h5 class="title">{{ __('Edit Profile') }}</h5>
                    {{-- <a href="{{ route('admin.view') }}"
                        style="border: 1px solid;
                        padding: 6px;
                        border-radius: 25px;">Add Admin</a> --}}
                </div>
                <form method="post" action="{{ route('profile.update') }}" autocomplete="off">
                    <div class="card-body">
                            @csrf
                            @method('put')
                            @include('alerts.success')

                            <div class="form-group{{ $errors->has('username') ? ' has-danger' : '' }}">
                                <label>{{ __('Name') }}</label>
                                <input type="text" name="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name', auth()->user()->username) }}">
                                {{-- @include('alerts.feedback', ['field' => 'username']) --}}
                            </div>

                            <div class="form-group{{ $errors->has('email1') ? ' has-danger' : '' }}">
                                <label>{{ __('Email address') }}</label>
                                <input type="email" name="email" class="form-control{{ $errors->has('email1') ? ' is-invalid' : '' }}" placeholder="{{ __('Email address') }}" value="{{ old('email', auth()->user()->email) }}">
                                {{-- @include('alerts.feedback', ['field' => 'email']) --}}
                            </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Password') }}</h5>
                </div>
                <form method="post" action="{{ route('profile.password') }}" autocomplete="off">
                    <div class="card-body">
                        @csrf
                        @method('put')

                        @include('alerts.success', ['key' => 'password_status'])

                        <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                            <label>{{ __('Current Password') }}</label>
                            <input type="password" name="old_password" class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}" placeholder="{{ __('Current Password') }}" value="" required>
                            @include('alerts.feedback', ['field' => 'old_password'])
                        </div>

                        <div class="form-group{{ $errors->has('new_password') ? ' has-danger' : '' }}">
                            <label>{{ __('New Password') }}</label>
                            <input type="password" name="new_password" class="form-control{{ $errors->has('new_password') ? ' is-invalid' : '' }}" placeholder="{{ __('New Password') }}" value="" required>
                            @include('alerts.feedback', ['field' => 'new_password'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Confirm New Password') }}</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="{{ __('Confirm New Password') }}" value="" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;">{{ __('Change password') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-user">

                <div class="card-body">
                    <p class="card-text">
                        <div class="author">
                            <div class="block block-one"></div>
                            <div class="block block-two"></div>
                            <div class="block block-three"></div>
                            <div class="block block-four"></div>
                            <h4>ADD New Admin</h4>
                        </div>
                    </p>

                    <form method="post" action="{{ route('add.admin') }}" autocomplete="off">
                        <div class="card-body">
                            @csrf
                            @method('post')



                            <div class="form-group{{ $errors->has('username') ? ' has-danger' : '' }}">
                                <label>{{ __('Name') }}</label>
                                <input type="text" name="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="{{ __('username') }}"  required>
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
                                <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" value="" autocomplete="new-password" required>
                                @include('alerts.feedback', ['field' => 'password'])
                            </div>
                            <div class="form-group">
                                <label>{{ __('Confirm Password') }}</label>
                                <input type="password" name="confirm_password" class="form-control" placeholder="{{ __('Confirm Password') }}"  required>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-fill btn-primary" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;">{{ __('Add Admin') }}</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
