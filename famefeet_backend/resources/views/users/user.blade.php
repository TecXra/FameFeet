@extends('layouts.app', ['page' => __('User'), 'pageSlug' => 'user'])
{{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
{{-- <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
@section('content')
<div class="row">
    <div class="col-md-9">
        {{-- <input class="form-control" id="myInput" type="text" placeholder="Search.."> --}}
        <form action="{{ route('user.getAllUser') }}" method="GET" class="form-inline">
            <input id="myInput" class="form-control mr-sm-2" type="search" name="search" value="{{ request('search') }}" placeholder="Search" aria-label="Search" style="width: 60%">
             <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
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
        <h4 class="card-title"> Users Table</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table tablesorter " id="">
            <thead class=" text-primary">
              <tr>

              <th>
                User Name
              </th>
                  <th>
                      Real Name
                  </th>
               <th>
                  Email
               </th>
                <th>
                    User Type
                </th>
                <th>
                    Mobile Number
                </th>
                <th>Account Status</th>
                <th>
                  Action
                </th>

              </tr>
            </thead>
            <tbody id="myTable">

                @foreach ($users as $user)
               
                <tr>
                    <input type="hidden" class="serdelete_val" value="{{ $user->id }}">

                <td>
                    <img src="/{{ $user->avatar }}" alt=""
                    style="border-radius: 5.2857rem;
                    width: 30px;">
                   {{ $user->username }}
                    @if($user->report->count() > 0)
                     <span class="badge badge-danger">Reported ({{ $user->report->count() }})</span>
                      @endif 
                </td>
                <td>{{$user->full_name}}</td>
                  <td>
                    {{$user->email}}
                  </td>

                    @if ($user->user_type == 1)
                      <td>Celebrity</td>
                      @elseif ($user->user_type == 2)
                      <td>Fan</td>
                      @elseif ($user->user_type == 9)
                      <td>Admin</td>
                    @endif
                    <td>{{ $user->phone_number }}</td>
                    <td>
                    <form action="{{ route('user.status',$user->id) }}" method="post" style="margin: unset">
                        @csrf
                        @method('POST')
                        <select name="account_status" id="account_status" class="form-control" onchange="this.form.submit()">
                            <option style="background:rgb(33, 32, 32)" value="{{ config('famefeet.account_status.active') }}" {{ $user->account_status == 1 ? 'selected':''; }}>Active</option>
                            <option style="background:rgb(33, 32, 32)" value="{{ config('famefeet.account_status.suspend') }}" {{ $user->account_status == 2 ? 'selected':''; }}>Suspend</option>
                            <option style="background:rgb(33, 32, 32)" value="{{ config('famefeet.account_status.block') }}" {{ $user->account_status == 3 ? 'selected':''; }}>Block</option>
                            <option style="background:rgb(33, 32, 32)" value="{{ config('famefeet.account_status.deleted') }}" {{ $user->account_status == 4 ? 'selected':''; }}>Deleted</option>
                        </select>
                    </form>
                    </td>
                    <td>
                        <a href="{{ route('user.edit', $user->id) }}"
                            style="color:#a8729a;; font-size: 16px;
                             font-weight: bold;border-right: 1px solid;
                             padding-right: 4px;">
                             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                            </svg>
                        </a>
                        <a href="{{ route('user.details', $user->id) }}"
                        style="color:#13dbed; font-size: 16px;
                         font-weight: bold;margin-left:4px">
                          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-ticket-detailed" viewBox="0 0 16 16">
                            <path d="M4 5.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5Zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5ZM5 7a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2H5Z"/>
                            <path d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5V6a.5.5 0 0 1-.5.5 1.5 1.5 0 0 0 0 3 .5.5 0 0 1 .5.5v1.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 11.5V10a.5.5 0 0 1 .5-.5 1.5 1.5 0 1 0 0-3A.5.5 0 0 1 0 6V4.5ZM1.5 4a.5.5 0 0 0-.5.5v1.05a2.5 2.5 0 0 1 0 4.9v1.05a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-1.05a2.5 2.5 0 0 1 0-4.9V4.5a.5.5 0 0 0-.5-.5h-13Z"/>
                          </svg>
                        </a>

                        {{-- <a href="" class="btn-sm btn-primary">Edit</a> --}}
                       {{-- <button type="button" width="40px" height = "20px" class="btn-sm btn-danger servideletebtn">Remove</button> --}}
                       {{-- <a href="" class="btn-sm btn-success">Details</a> --}}

                    </td>

                </tr>
                @endforeach

            </tbody>

          </table>
          {{ $users->links('pagination::bootstrap-4') }}
        </div>
      </div>
    </div>
  </div>
</div>


    <script>
    $(document).ready(function(){
      
    // $("#myInput").on("keyup", function() {
    //     var value = $(this).val().toLowerCase();
    //     $("#myTable tr").filter(function() {
    //     $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    //     });
    // });

    });

    </script>
@endsection


