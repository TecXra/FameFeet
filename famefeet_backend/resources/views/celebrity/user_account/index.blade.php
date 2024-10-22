@extends('celebrity.show')

@section('subsection')
<div class="row mt-2">
    {{-- <div class="col-md-9 mb-3">
        <form action="" class="form-inline">
            <input class="form-control mr-sm-2" type="search" name="search" value="{{ $search }}" placeholder="Search" aria-label="Search" style="width: 60%">
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
        <h4 class="card-title">All Shop Items</h4>
      </div>
      <div class="card-body">
      @if(count($accounts) > 0)
        <div class="table-responsive">
          <table class="table tablesorter " id="">
            <thead class=" text-primary">
              <tr>
                <th>Account Holder Name</th>
                <th>Bank Name</th>
                <th>Account Number</th>
                <th>Routing Number</th>
                <th>Account Type</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($accounts as $account)
                <tr>
                <td>{{ $account->name_on_account }}</td>
                <td>{{ $account->bank_name }}</td>
                <td>{{ $account->account_number }}</td>
                <td>{{ $account->routing_number }}</td>
                <td>{{ $account->account_type }}</td>
                {{-- <td>{{date("F j, Y, g:i a", strtotime($shop->created_at))}}</td> --}}
                <td>
                    <a href="{{ route('edit.celebrity.bank.account',$account->id) }}"
                        style="color:#a8729a; font-size: 16px;
                         font-weight: bold;border-right: 1px solid;
                         padding-right: 4px;">
                         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                         </svg>
                        </a>
                    <a href="{{ route('delete.celebrity.bank.account',$account->id) }}"
                        style="color:#ed3535; font-size: 16px;
                        font-weight: bold;margin-left:3px">
                         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                          </svg>
                    </a>
                </td>
                </tr>
                @endforeach
            </tbody>
          </table>
          {{ $accounts->links('pagination::bootstrap-4'); }}
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
