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
    <p class="text-center">User Details</p>
    <header class="header">
        <div class="details">
          <img src="/{{ $user->avatar }}" alt="{{ $user->username }}" class="profile-pic">
          <h1 class="heading">{{ $user->username }}</h1>
          <div class="location">
            <i class="tim-icons icon-email-85"></i>
            <p>{{ $user->email }}</p>
          </div>
          <div class="stats">
            <div class="col-4" style="margin-top: 10px">
                <p>Phone Number</p>
              <h4>{{ $user->phone_number }}</h4>
            </div>
            <div class="col-4" style="margin-top: 10px">
                <p>Date Of Birth</p>
              <h4>{{ $user->date_of_birth }}</h4>
            </div>
            <div class="col-4" style="margin-top: 10px">
                <p>User Type</p>
              <h4>{{ $user->user_type_name }}</h4>
            </div>
          </div>
          @if(count($user->report) > 0)
          <h2 class="heading">Reported User</h2>
          <div class="stats">
          <div class="col-6" style="margin-top: 10px">
              <p>Name</p>
           </div>
           <div class="col-6" style="margin-top: 10px">
              <p>Message</p>
           </div>
          </div>
          @foreach($user->report as $report)
          <div class="stats">
            <div class="col-6" style="margin-top: 10px">
              <h4>{{ $report->reported->username }}</h4>
           </div>
           <div class="col-6" style="margin-top: 10px">
              <h4>{{ $report->message }}</h4>
           </div>
         </div>
         @endforeach
         @else
                <h2 class="heading">No Reported Users</h2>
            @endif
        </div>
      </header>
@endsection
