@extends('layouts.app', ['page' => __('Tables'), 'pageSlug' => 'tables'])

@section('content')
<div class="row">
  <div class="col-md-12">
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
                User ID
              </th>
               <th>
                  Email
               </th>
                <th>
                    User Type
                </th>
                <th class="text-center">
                  Action
                </th>

              </tr>
            </thead>
            <tbody>

                @foreach ($users as $user)
                <tr>
                <td>
                    {{$user->id}}
                </td>
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

                  <td class="text-center">
                    <a href="#" class="btn btn-primary">Edit</a>
                    <a href="#" class="btn btn-danger">Remove</a>
                  </td>
                </tr>
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
