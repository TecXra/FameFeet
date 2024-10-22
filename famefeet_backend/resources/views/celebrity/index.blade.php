@extends('layouts.app', ['page' => __('Celebrity'), 'pageSlug' => 'celebrity'])


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
{{-- <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script> --}}



@section('content')
<div class="row">
    <div class="col-md-9">
        <form action="" class="form-inline">
            {{-- <input class="form-control mr-sm-2" type="search" name="search" value="{{ $search }}" placeholder="Search" aria-label="Search" style="width: 60%">
             --}}
            <input id="myInput" class="form-control mr-sm-2" type="search" name="search" value="" placeholder="Search" aria-label="Search" style="width: 60%">
            {{-- <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button> --}}
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
        <h4 class="card-title"> Celebrity Table</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table tablesorter " id="">
            <thead class=" text-primary">
              <tr>

                <th> User Name</th>
                <th> Real Name</th>
                <th>Email</th>
                <th>Mobile Number</th>
                <th>Gender</th>
                <th>Bio</th>
                {{-- <th>Location</th> --}}
                <th>Experience</th>
                <th>Front ID PIC</th>
                <th>Back ID PIC</th>
                <th>Active Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="myTable">

                @foreach ($celbs as $celb)

                <tr>

                <td>
                    <img src="/{{ $celb->user->avatar }}" alt=""
                    style="border-radius: 5.2857rem;
                    width: 30px;">
                    {{$celb->user->username}}
                </td>
                    <td>{{$celb->user->full_name}}</td>
                <td>{{ $celb->user->email }}</td>
                <td>{{ $celb->user->phone_number }}</td>
                <td>{{$celb->gender}}</td>
                <td>{{(Str::length($celb->bio) > 50)?Str::substr($celb->bio,0, 50) . '...':$celb->bio}}</td>
                {{-- <td>{{$celb->location }}</td> --}}
                @if($celb->experience == 0 && $celb->experience != null)
                     <td>Mature</td>
                @elseif ($celb->experience == 1)
                     <td>Beginer</td>
                @elseif ($celb->experience == 2)
                     <td>Professional</td>
                @else
                    <td>None</td>
                @endif
                <td>
                    <a href="#" data-toggle="modal" data-target="#front{{ $celb->id }}">
                        <img src="/{{ $celb->front_id_pic }}"  style="border-radius: 5.2857rem;
                        width: 30px;">
                        <!-- Modal -->
                        <div class="modal fade" id="front{{ $celb->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document" >
                            <div class="modal-content">
                                <div class="modal-header">
                                <h4 class="modal-title" id="exampleModalLabel"> {{ $celb->user->username }} (Front Pic Of ID Card) </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body" >
                                    {{-- <p>front</p> --}}
                                <img src="/{{ $celb->front_id_pic }}" alt="Front id pic">
                                </div>
                                <div class="modal-footer">
                                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                </div>
                            </div>
                            </div>
                        </div>
                        {{-- end model --}}
                    </a>
                </td>
                <td>
                    <a href="#" data-toggle="modal" data-target="#back{{ $celb->id }}">
                        <img src="/{{ $celb->back_id_pic }}" style="border-radius: 5.2857rem;
                        width: 30px;">
                        <!-- Modal -->
                        <div class="modal fade" id="back{{ $celb->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h4 class="modal-title" id="exampleModalLabel"> {{ $celb->user->username }} (Back Pic Of ID Card) </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    {{-- <p>back</p> --}}
                                <img src="/{{$celb->back_id_pic }}" alt="Back id pic">
                                </div>
                                <div class="modal-footer">
                                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                </div>
                            </div>
                            </div>
                        </div>
                        {{-- end model --}}
                    </a>
                </td>
                <td>
                    <form action="{{ route('user.status',$celb->user->id) }}" method="post" style="margin: unset">
                        @csrf
                        @method('POST')
                        <select name="account_status" id="account_status" class="form-control" onchange="this.form.submit()">
                            <option style="background:rgb(33, 32, 32)" value="{{ config('famefeet.account_status.active') }}" {{ $celb->user->account_status == 1 ? 'selected':''; }}>Active</option>
                            <option style="background:rgb(33, 32, 32)" value="{{ config('famefeet.account_status.suspend') }}" {{ $celb->user->account_status == 2 ? 'selected':''; }}>Suspend</option>
                            <option style="background:rgb(33, 32, 32)" value="{{ config('famefeet.account_status.block') }}" {{ $celb->user->account_status == 3 ? 'selected':''; }}>Block</option>
                            <option style="background:rgb(33, 32, 32)" value="{{ config('famefeet.account_status.deleted') }}" {{ $celb->user->account_status == 4 ? 'selected':''; }}>Deleted</option>
                        </select>
                    </form>
                </td>

                    {{-- @if ($celb->user->account_status == config('famefeet.account_status.active') ) --}}
                        {{-- <td>
                            <a href="{{ route('user.status',$celb->user->id) }}"
                                style="color:#a8729a; font-size: 16px;
                                 font-weight: bold;">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-toggle-on" viewBox="0 0 16 16">
                                    <path d="M5 3a5 5 0 0 0 0 10h6a5 5 0 0 0 0-10H5zm6 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/>
                                </svg>
                            </a> --}}
                            {{-- <a href="{{ route('user.status',$celb->user->id) }}" class="btn-sm btn-Success">Active</a> --}}
                        {{-- </td>
                        @elseif ($celb->user->account_status == config('famefeet.account_status.suspend') || $celb->user->account_status == config('famefeet.account_status.block') || $celb->user->account_status == config('famefeet.account_status.deleted'))
                        <td>
                            <a href="{{ route('user.status',$celb->user->id) }}"
                                style="color:#a8729a; font-size: 16px;
                                font-weight: bold;">
                               <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-toggle-off" viewBox="0 0 16 16">
                                <path d="M11 4a4 4 0 0 1 0 8H8a4.992 4.992 0 0 0 2-4 4.992 4.992 0 0 0-2-4h3zm-6 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8zM0 8a5 5 0 0 0 5 5h6a5 5 0 0 0 0-10H5a5 5 0 0 0-5 5z"/>
                               </svg>
                            </a> --}}
                            {{-- <a href="{{ route('user.status',$celb->user->id) }}" class="btn-sm btn-danger">InActive</a> --}}
                        {{-- </td>
                    @endif --}}

                    <td>
                        <a href="{{ route('celebrity.edit', $celb->id) }}"
                            style="color:#a8729a; font-size: 16px;
                             font-weight: bold;border-right: 1px solid;
                             padding-right: 4px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                            </svg>
                        </a>
                        <a href="{{ route('single.celebrity.posts', $celb->id) }}"
                        style="color:#13dbed; font-size: 16px;
                         font-weight: bold;margin-left:4px"> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-ticket-detailed" viewBox="0 0 16 16">
                            <path d="M4 5.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5Zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5ZM5 7a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2H5Z"/>
                            <path d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5V6a.5.5 0 0 1-.5.5 1.5 1.5 0 0 0 0 3 .5.5 0 0 1 .5.5v1.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 11.5V10a.5.5 0 0 1 .5-.5 1.5 1.5 0 1 0 0-3A.5.5 0 0 1 0 6V4.5ZM1.5 4a.5.5 0 0 0-.5.5v1.05a2.5 2.5 0 0 1 0 4.9v1.05a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-1.05a2.5 2.5 0 0 1 0-4.9V4.5a.5.5 0 0 0-.5-.5h-13Z"/>
                          </svg></a>
                      {{-- <a href="{{ route('celebrity.edit', $celb->id) }}" class="btn-sm btn-primary">Edit</a> --}}
                      <!-- <button type="button" width="40px" height = "20px" class="btn-sm btn-danger servideletebtn">Remove</button> -->
                       {{-- <a href="{{ route('single.celebrity.posts', $celb->id) }}" class="btn-sm btn-success">Details</a> --}}
                    </td>

                </tr>
                @endforeach
            </tbody>
          </table>
          {{ $celbs->links('pagination::bootstrap-4'); }}
        </div>
      </div>
    </div>
  </div>

</div>

<script>
    $(document).ready(function(){
      $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });


    // function onSubmit(){
    //     this.form.submit();
    //     // event.preventDefault();
    // }
</script>




@endsection
