@extends('layouts.app', ['page' => __('Fan'), 'pageSlug' => 'fan'])
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>


@section('content')
<div class="row">
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
        <h4 class="card-title"> Fans Table</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table tablesorter " id="">
            <thead class=" text-primary">
              <tr>

                <th> User Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Date Of Birth</th>
                <th>User Status</th>
                <th>Active Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>

                @foreach ($fans as $fan)

                <tr>
                    <input type="hidden" class="serdelete_val" value="{{ $fan->id }}">
                <td>{{$fan->user->username}}</td>
                <td>{{$fan->user->email}}</td>
                <td>{{$fan->user->phone_number}}</td>
                <td>{{$fan->user->date_of_birth}}</td>


                  {{-- @if ($fan->user->is_online == True )
                        @if($fan->user->is_active == True)
                            <td>Online|Active</td>
                        @elseif ($fan->user->is_active == False)
                                <td>Online|Passive</td>
                        @endif
                        @elseif ($fan->user->is_online == False)
                        <td>Ofline|Passive</td>
                    @endif

                    @if ($fan->user->is_active == True )
                        <td><a href="{{ route('user.status',$fan->user->id) }}" class="btn-sm btn-Success">Active</a></td>
                        @elseif ($fan->user->is_active == false)
                            <td><a href="{{ route('user.status',$fan->user->id) }}" class="btn-sm btn-danger">InActive</a></td>
                    @endif --}}

                    <td>

                        <a href="{{ route('fan.edit', $fan->id) }}" class="btn-sm btn-primary">Edit</a>
                      <!-- <button type="button" width="40px" height = "20px" class="btn-sm btn-danger servideletebtn">Remove</button> -->
                       <a href="{{ route('fan.show', $fan->id) }}" class="btn-sm btn-success">Details</a>

                    </td>
                </tr>
                @endforeach
            </tbody>
          </table>
          {{ $fans->links('pagination::bootstrap-4'); }}
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
