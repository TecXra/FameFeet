@extends('layouts.app', ['page' => __('My Earnings'), 'pageSlug' => 'myEarnings'])

{{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"> --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
{{--  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script> --}}

@section('content')

{{--<div class="row">--}}
{{--    <div class="col-md-12">--}}
{{--        <div class="card-header">{{$date_range ? 'Range: '.$dates_range[0].' to '. $date_range[1]:'Last 90 Days'}}</div>--}}
{{--    </div>--}}
{{--</div>--}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <form class="form form-inline" action="{{route('admin.earnings')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="label"><h5>{{__('Start Date: ')}}&nbsp</h5></label>
                            <input class="form-control" type="date" name="start_date">
                        </div>

                        <div class="form-group">
                            <label class="label" for="end_date"><h5>&nbsp{{__('End Date: ')}}&nbsp</h5></label>
                            <input class="form-control" id="end_date" type="date" name="end_date">
                        </div>
                        <div class="form-group">
                            <label class="label"><h5>{{__(' Type ')}}</h5></label>
                            <select class="form-control" name="type">
                                <option></option>
                                @foreach($earning_types as $type)
                                <option style="background:rgb(33, 32, 32)" value="{{$type['id']}}">{{$type['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn btn-default" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>

    </div>


    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Total Earnings
                </div>
                <div class="card-body">
                    <h2>{{$earnings}}</h2>
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Expected Earnings
                </div>
                <div class="card-body">
                    <h2>{{$expected}}</h2>
                </div>
            </div>

        </div>

    </div>




        <div class="col-md-12">
            <div class="col-5">
                @if(session()->get('success'))
                    <div class="alert alert-success mt-2">
                        <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="tim-icons icon-simple-remove"></i>
                        </button>
                        <span>
              <b> {{ session()->get('success') }}</span>
                    </div>
                @endif
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

            <script>


            </script>
@endsection
