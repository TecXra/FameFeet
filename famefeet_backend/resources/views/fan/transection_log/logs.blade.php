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
        <h4 class="card-title">All Transection Details</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table tablesorter " id="">
            <thead class=" text-primary">
              <tr>

              <th>
                Transection  Date
              </th>
              <th style="text-align: center">
                Exchange Rate
              </th>
               <th>
                  Transection Type
               </th>
               <th>
                 Name
               </th>
               <th>
                Amount
               </th>
                <th style="text-align: center">
                  Action
                </th>

              </tr>
            </thead>
            <tbody>

                @foreach ($logs as $log)
                <tr>
                <td style="width: 200px">
                    {{ date("F j, Y, g:i a", strtotime($log->created_at)) }}
                </td>
                <td style="text-align: center">{{ $log->exchange_rate }}</td>
                  <td>
                    {{ getLogTypeName($log->log_type)}}
                  </td>

                    @if($log->sender_user_id == config('famefeet.platform_name.gateway') || $log->receiver_user_id == config('famefeet.platform_name.gateway'))
                          <td>Gateway</td>
                    @elseif ($log->sender_user_id != $fan->user->id)
                        <td> <img src="/{{ $log->senderUser->avatar }}" alt=""
                            style="border-radius: 5.2857rem;
                            width: 30px;">
                           {{ $log->senderUser->username }}
                        </td>
                    @else
                        <td> <img src="/{{ $log->receiverUser->avatar }}" alt=""
                            style="border-radius: 5.2857rem;
                            width: 30px;">
                           {{ $log->receiverUser->username }}
                        </td>
                    @endif
                   <td>
                     {{ $log->from_amount }}
                   </td>
                   <td style="text-align: center">
                        <a href="{{ route('transaction.details',$log->id) }}"
                            style="color:#13dbed; font-size: 16px;
                            font-weight: bold;margin-left:4px">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-ticket-detailed" viewBox="0 0 16 16">
                                <path d="M4 5.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5Zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5ZM5 7a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2H5Z"/>
                                <path d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5V6a.5.5 0 0 1-.5.5 1.5 1.5 0 0 0 0 3 .5.5 0 0 1 .5.5v1.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 11.5V10a.5.5 0 0 1 .5-.5 1.5 1.5 0 1 0 0-3A.5.5 0 0 1 0 6V4.5ZM1.5 4a.5.5 0 0 0-.5.5v1.05a2.5 2.5 0 0 1 0 4.9v1.05a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-1.05a2.5 2.5 0 0 1 0-4.9V4.5a.5.5 0 0 0-.5-.5h-13Z"/>
                            </svg>
                        </a>
                    </td>

                     {{-- @if ($redeem->status == false)
                        <td><a href="{{ route('celebrity.redeem.request.accept',$redeem->id) }}"
                        style="color:#a8729a;; font-size: 16px;
                         font-weight: bold;">Accept</a></td>
                     @else --}}
                        {{-- <td>---</td> --}}
                     {{-- @endif --}}
                </tr>
                @endforeach

            </tbody>

          </table>
          {{ $logs->links('pagination::bootstrap-4') }}
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
