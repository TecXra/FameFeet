@extends('celebrity.show')

@section('subsection')
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
        <h4 class="card-title">All Transaction Details</h4>
      </div>
      <div class="card-body">
        @if(count($logs) > 0)
        <div class="table-responsive">
          <table class="table tablesorter " id="">
            <thead class=" text-primary">
                <tr>

                <th>
                  Transaction  Date
                </th>
                <th style="text-align: center">
                  Exchange Rate
                </th>
                 <th>
                    Transaction Type
                 </th>
                 <th>
                   Name
                 </th>
                 <th style="text-align: center">
                  Transfer Amount
                 </th>
                 <th style="text-align: center">
                    Charges
                 </th>
                 <th style="text-align: center">
                    Total Amount
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
                      @elseif ($log->sender_user_id != $celebrity->user->id)
                          <td> 
                            @if(isset($log->senderUser->avatar))
                              <img src="/{{ $log->senderUser->avatar }}" alt=""
                              style="border-radius: 5.2857rem;
                              width: 30px;">
                            @endif
                            {{ $log->senderUser->username }}
                          </td>
                      @else
                          <td> 
                            @if(isset($log->receiverUser->avatar))
                              <img src="/{{ $log->receiverUser->avatar }}" alt=""
                              style="border-radius: 5.2857rem;
                              width: 30px;">
                            @endif
                            {{ $log->receiverUser->username }}
                          </td>
                      @endif
                    <td style="text-align: center">
                      {{ $log->celebrity_charges_price }}
                    </td>
                    <td style="text-align: center">
                        {{ $log->service_charges_price }}
                    </td>
                    <td style="text-align: center">
                        {{ $log->from_amount }}
                    </td>
                  </tr>
                  @endforeach

              </tbody>

          </table>
          {{ $logs->links('pagination::bootstrap-4') }}
        </div>
        @else
        <div class="p-5">
          <p class="text-center">
            No record found.
          </p>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>

@endsection
