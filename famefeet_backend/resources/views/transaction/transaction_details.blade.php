@extends('layouts.app', ['page' => __('All Transactions'), 'pageSlug' => 'transaction'])
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
@section('content')
<div class="row mt-2">
    <div class="col-md-9">
        <div class="col-md-9">
            <form action="" class="form-inline">
                <input id="myInput" class="form-control mr-sm-2" type="search" name="search" value="" placeholder="Search" aria-label="Search" style="width: 60%">
              </form>
        </div>
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
        <h4 class="card-title">All Transections Details</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table tablesorter " id="">
            <thead class=" text-primary">
              <tr>

              <th>
                Transection  Date
              </th>
              {{-- <th style="text-align: center">
                Exchange Rate
              </th> --}}
               <th>
                  Transection Type
               </th>
               <th>
                 Sender
               </th>
               <th>
                Recipient
              </th>
              {{-- <th style="text-align: center">
                Transfer Amount
               </th>
               <th>
                Service Charges
               </th> --}}
               <th style="text-align: center">
                Amount
               </th>
               <th style="text-align: center">
                Transection ID
              </th>
              <th style="text-align: center">
                   Action
              </th>
              </tr>
            </thead>
            <tbody id="myTable">

                @foreach ($transactions as $transaction)
                <tr>
                <td style="width: 240px">
                    {{ date("F j, Y, g:i a", strtotime($transaction->created_at)) }}
                </td>
                {{-- <td style="text-align: center">{{ $transaction->exchange_rate }}</td> --}}
                  <td>
                    {{ getLogTypeName($transaction->log_type)}}
                  </td>

                    @if($transaction->sender_user_id == config('famefeet.platform_name.gateway'))
                          <td>Gateway</td>
                    @else
                        <td> <img src="/{{ $transaction->senderUser->avatar }}" alt=""
                            style="border-radius: 5.2857rem;
                            width: 30px;">
                           {{ $transaction->senderUser->email ."(". $transaction->senderUser->user_type_name. ")" }}
                        </td>
                    @endif
                    @if ($transaction->receiver_user_id == config('famefeet.platform_name.gateway'))
                        <td>Gateway</td>
                    @else
                        <td> <img src="/{{ $transaction->receiverUser->avatar }}" alt=""
                            style="border-radius: 5.2857rem;
                            width: 30px;">
                        {{ $transaction->receiverUser->email ."(". $transaction->receiverUser->user_type_name .")" }}
                        </td>
                    @endif
                    {{-- <td style="text-align: center">
                        {{ $transaction->celebrity_charges_price }}
                    </td>
                    <td style="text-align: center">
                        {{ $transaction->service_charges_price }}
                    </td> --}}
                    <td style="text-align: center">
                        {{ $transaction->from_amount }}
                    </td>
                    <td style="text-align: center">
                        {{ $transaction->transaction_id ?? '---' }}
                    </td>
                    <td style="text-align: center">
                        <a href="{{ route('transaction.details',$transaction->id) }}"
                            style="color:#13dbed; font-size: 16px;
                             font-weight: bold;margin-left:4px">
                              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-ticket-detailed" viewBox="0 0 16 16">
                                <path d="M4 5.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5Zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5ZM5 7a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2H5Z"/>
                                <path d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5V6a.5.5 0 0 1-.5.5 1.5 1.5 0 0 0 0 3 .5.5 0 0 1 .5.5v1.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 11.5V10a.5.5 0 0 1 .5-.5 1.5 1.5 0 1 0 0-3A.5.5 0 0 1 0 6V4.5ZM1.5 4a.5.5 0 0 0-.5.5v1.05a2.5 2.5 0 0 1 0 4.9v1.05a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-1.05a2.5 2.5 0 0 1 0-4.9V4.5a.5.5 0 0 0-.5-.5h-13Z"/>
                              </svg>
                        </a>
                    </td>

                </tr>
                @endforeach

            </tbody>

          </table>
          {{ $transactions->links('pagination::bootstrap-4') }}
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
</script>
@endsection
