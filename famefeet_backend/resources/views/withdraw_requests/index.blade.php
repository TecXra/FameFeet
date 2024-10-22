@extends('layouts.app', ['page' => __('Withdraw Requests'), 'pageSlug' => 'allWithdrawRequests'])

@section('content')
    <div class="row mt-2">
        {{-- <div class="col-md-9">
            <form action="" class="form-inline">
                <input class="form-control mr-sm-2" type="search" name="search" value="" placeholder="Search" aria-label="Search" style="width: 60%">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div> --}}
        <div class="col-md-12">
            @if(session()->get('success'))
                <div class="alert alert-success">
                    <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="tim-icons icon-simple-remove"></i>
                    </button>
                    <span>
                    <b> {{ session()->get('success') }}</span>
                </div>
            @elseif($errors->any())
                <div class="alert alert-danger">
                    {{$errors->first()}}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All Redeem Request</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table tablesorter " id="withdraw_requests">
                            <thead class=" text-primary">
                            <tr>

                                <th>
                                    User Name
                                </th>
                                <th>
                                    Email
                                </th>
                                <th>
                                    Mobile Number
                                </th>
                                <th>
                                    Coins
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>
                                    User Type
                                </th>
                                {{-- <th>
                                    User Status
                                </th>
                                <th>Active Status</th>--}}
                                <th>
                                    Action
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            {{-- {{ $redeems }} --}}
                            @foreach ($redeems as $redeem)
                                <tr>
                                    {{-- <input type="hidden" class="serdelete_val" value="{{ $user->id }}"> --}}

                                    <td>
                                        <img src="/{{ $redeem->user->avatar }}" alt="" style="border-radius: 5.2857rem; width: 30px;">
                                        {{ $redeem->user->username }}
                                    </td>
                                    <td>
                                        {{$redeem->user->email}}
                                    </td>
                                    <td>
                                        {{$redeem->user->phone_number}}
                                    </td>
                                    <td>
                                        {{$redeem->coins}}
                                    </td>
                                    <td>{{ $redeem->status }}</td>
                                    @if ($redeem->user->user_type == 1)
                                        <td>Celebrity</td>
                                    @elseif ($redeem->user->user_type == 2)
                                        <td>Fan</td>
                                    @elseif ($redeem->user->user_type == 9)
                                        <td>Admin</td>
                                    @endif
                                    @if ($redeem->status == 'pending')
                                        <td><a href="{{ route('celebrity.redeem.request.accept',$redeem->id) }}"
                                               style="color:#a8729a;; font-size: 16px;
                                                font-weight: bold;">Accept</a> | 
                                               <a href="{{ route('celebrity.redeem.request.reject',$redeem->id) }}"
                                                style="color:#a8729a; font-weight: bold; font-size: 16px;">

                                                Reject</a></td>
                                    @else
                                        <td>---</td>
                                    @endif
                                </tr>
                            @endforeach

                            </tbody>

                        </table>
{{--                        {{ $redeems->links('pagination::bootstrap-4') }}--}}
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
