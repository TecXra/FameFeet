@extends('layouts.app', ['page' => __('Incoming Transactions'), 'pageSlug' => 'allIncomingPlatform'])
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>


@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Total Topups
            </div>
            <div class="card-body">
                <h2>{{ $totalTransaction }}</h2>
            </div>
        </div>

    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Available Balance
            </div>
            <div class="card-body">
                <h2>{{ $availableTransaction }}</h2>
            </div>
        </div>

    </div>

</div>



<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <form class="form form-inline" action="{{route('admin.incoming')}}" method="POST">
                    @csrf

                    <div class="form-group" style="margin-top: 17px;">
                        <label class="label"><h5>{{__('Start Date: ')}}&nbsp</h5></label>
                        <input class="form-control" type="date" name="start_date">
                    </div>

                    <div class="form-group" style="margin-left: 20px;margin-top:17px">
                        <label class="label" for="end_date"><h5>&nbsp{{__('End Date: ')}}&nbsp</h5></label>
                        <input class="form-control" id="end_date" type="date" name="end_date">
                    </div>
                    <button class="btn btn-default" style="margin-left: 20px" type="submit">Submit</button>

                </form>
            </div>
        </div>
    </div>

</div>



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
                    <h4 class="card-title"> Incoming Transactions</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive data-table DataTables">
                        <table class="table tablesorter " id="datatable">
                            <thead class=" text-primary">
                            <tr>
                                <th>Username</th>
                                <th>Transaction Date</th>
                                <th>Transaction Amount</th>
                                <th>Exchange Rate</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function () {

            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                "sDom": '<"top"f>rt<"bottom"ipl>',
                ajax: "{{ route('allIncomingPlatformPagination') }}",
                columns: [
                    {data: 'user_name', name: 'user_name'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'from_amount', name: 'from_amount'},
                    {data: 'exchange_rate', name: 'exchange_rate'},
                ]
            });
        });
    </script>

@endsection