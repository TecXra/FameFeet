@extends('fan.show')
@section('fansection')
<div class="row mt-2">

    {{-- <div class="col-md-9 mb-3">
        <form action="" class="form-inline">
            <input class="form-control mr-sm-2" type="search" name="search" value="{{ $search }}" placeholder="Search" aria-label="Search" style="width: 60%">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
    </div> --}}

  <div class="col-md-12">
    <div class="col-5">
        @if(session()->get('success'))
        <div class="alert alert-success">
            <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
              <i class="tim-icons icon-simple-remove"></i>
            </button>
            <span>
              <b> {{ session()->get('success') }}</span>
          </div>
      @endif
    </div>
    <div class="card ">
      <div class="card-header">
        <h4 class="card-title">Subscribe Users</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table tablesorter ">
            <thead class=" text-primary">
              <tr>
                <th>User Name</th>
                <th>Subscription Price</th>
                <th>Subscription Start Date</th>
                <th>Subscription End Date</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                  @foreach ($subscribeUsers as $subscribeUser)
                  <tr>
                        <td>
                            <img src="/{{ $subscribeUser->subscription->celebrity->user->avatar }}" alt=""
                                style="border-radius: 5.2857rem;
                                width: 40px;">
                            {{$subscribeUser->subscription->celebrity->user->username}}
                        </td>
                        <td>{{ $subscribeUser->coins }} FameFeet Coins</td>

                        <td>{{date("F j, Y, g:i a", strtotime($subscribeUser->subscription_start_date))}}</td>
                        <td>{{date("F j, Y, g:i a", strtotime($subscribeUser->subscription_end_date ))}}</td>

                        {{-- <td>{{ $subscribeUser->status }}</td> --}}
                        {{-- <td>{{ $offer->fan->user->username }}</td> --}}
                        @if ($subscribeUser->status == true)
                            <td>Enable</td>
                        @else
                            <td>Disable</td>
                        @endif

                        @if ($subscribeUser->status == true )
                            <td>
                                <a href="{{ route('celebrity.subscribe.user.status',$subscribeUser->id) }}"
                                    style="color:#a8729a; font-size: 16px;
                                    font-weight: bold;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-toggle-on" viewBox="0 0 16 16">
                                        <path d="M5 3a5 5 0 0 0 0 10h6a5 5 0 0 0 0-10H5zm6 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/>
                                    </svg></a></td>
                        @elseif ($subscribeUser->status == false)
                            <td><a href="{{ route('celebrity.subscribe.user.status',$subscribeUser->id) }}"
                                style="color:#a8729a; font-size: 16px;
                                font-weight: bold;">  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-toggle-off" viewBox="0 0 16 16">
                                <path d="M11 4a4 4 0 0 1 0 8H8a4.992 4.992 0 0 0 2-4 4.992 4.992 0 0 0-2-4h3zm-6 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8zM0 8a5 5 0 0 0 5 5h6a5 5 0 0 0 0-10H5a5 5 0 0 0-5 5z"/>
                               </svg>
                            </a></td>
                        @endif

                    </tr>
                  @endforeach
            </tbody>
          </table>
          {{ $subscribeUsers->links('pagination::bootstrap-4'); }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
