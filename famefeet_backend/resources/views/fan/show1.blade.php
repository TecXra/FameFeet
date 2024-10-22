@extends('layouts.app', ['page' => __('Show'), 'pageSlug' => 'show'])
<style>
 @import url("https://fonts.googleapis.com/css?family=Lato:400,400i,700");

body {
  margin: 0;
  font-family: 'Lato', sans-serif;
}

.header {
  min-height: 60vh;
  background: #009FFF;
background: linear-gradient(to right, #ec2F4B, #009FFF);
  color: white;
  clip-path: ellipse(100vw 60vh at 50% 50%);
  display: flex;
  align-items: center;
  justify-content: center;
}

.details {
  text-align: center;
}

.profile-pic {
  height: 12rem;
  width: 12rem;
  object-fit: center;
  border-radius: 50%;
  border: 2px solid #fff;
}

.location p {
  display: inline-block;
}

.location svg {
  vertical-align: middle;
}

.stats {
  display: flex;
}

.stats .col-4 {
  width: 10rem;
  text-align: center;
}

.heading {
  font-weight: 400;
  font-size: 1.3rem;
  margin: 1rem 0;
}

</style>
@section('content')
    <p class="text-center">Fan Details</p>
    <header class="header">
        <div class="details">
          <img src="https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-0.3.5&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ&s=b38c22a46932485790a3f52c61fcbe5a" alt="John Doe" class="profile-pic">
          <h1 class="heading">{{ $fans->user->username }}</h1>
          <div class="location">
            <i class="tim-icons icon-email-85"></i>
            <p>{{ $fans->user->email }}</p>
          </div>
          <div class="stats">
            <div class="col-4" style="margin-top: 10px">
                <p>Phone Number</p>
              <h4>{{ $fans->user->phone_number }}</h4>
            </div>
            <div class="col-4" style="margin-top: 10px">
                <p>Date Of Birth</p>
              <h4>{{ $fans->user->date_of_birth }}</h4>
            </div>
            <div class="col-4" style="margin-top: 10px">
                <p>User Type</p>
              <h4>{{ $fans->user->user_type_name }}</h4>
            </div>
          </div>
        </div>
      </header>
@endsection
