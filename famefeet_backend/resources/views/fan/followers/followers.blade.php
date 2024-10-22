@extends('fan.show')
@section('fansection')
<div class="row mt-2">
    {{-- <div class="col-md-9">
        <form action="" class="form-inline">
            <input class="form-control mr-sm-2" type="search" name="search" value="" placeholder="Search" aria-label="Search" style="width: 60%">
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
        <h4 class="card-title">Follower Users</h4>
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
                  Email
               </th>
                <th>
                    Phone Number

                </th>
                <th>
                    Date Of Birth

                </th>
                <th>
                    User Type
                </th>
                <th style="text-align: center">
                  Action
                </th>

              </tr>
            </thead>
            <tbody>
               {{-- {{ $blockUsers }} --}}
                @foreach ($followers as $follower)
                <tr>
                    {{-- <input type="hidden" class="serdelete_val" value="{{ $user->id }}"> --}}

                <td>
                    <img src="/{{ $follower->avatar }}" alt=""
                    style="border-radius: 5.2857rem;
                    width: 30px;">
                   {{ $follower->username }}
                </td>

                  <td>
                    {{$follower->email}}
                  </td>
                  <td>{{ $follower->phone_number }}</td>
                  <td>{{date("F j, Y", strtotime($follower->date_of_birth))}}</td>

                    @if ($follower->user_type == 1)
                      <td>Celebrity</td>
                      @elseif ($follower->user_type == 2)
                      <td>Fan</td>
                      @elseif ($follower->user_type == 9)
                      <td>Admin</td>
                    @endif

                    <td style="text-align: center">
                        <a href="{{ route('fan.remove.follower',$follower->id) }}"
                       style="color: red; font-size: 16px;
                        font-weight: bold;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg>
                        </a>
                    </td>
                        {{-- <td><a href="{{ route('user.status',$follower->id) }}" class="btn-sm btn-danger">InActive</a></td> --}}

                    <td>

                        {{-- <a href="{{ route('user.edit', $user->id) }}" class="btn-sm btn-primary">Edit</a> --}}
                       {{-- <button type="button" width="40px" height = "20px" class="btn-sm btn-danger servideletebtn">Remove</button> --}}
                       {{-- <a href="{{ route('user.details', $user->id) }}" class="btn-sm btn-success">Details</a> --}}

                    </td>

                </tr>
                @endforeach

            </tbody>

          </table>
          {{ $followers->links('pagination::bootstrap-4') }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
