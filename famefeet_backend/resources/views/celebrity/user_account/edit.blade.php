@extends('layouts.app',['page' => __('Edit'), 'pageSlug' => 'edit'])

@section('content')
     <div>
        @if (count($errors) > 0)
        <div class="alert alert-danger col-md-4">
           <ul>
               @foreach ($errors->all() as $error)
                   <li>{{ $error }}</li>
               @endforeach
           </ul>
        </div>
        @endif
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Edit Bank Account Details') }}</h5>
                </div>
            @if(session()->get('success'))
                <div class="alert alert-success">
                  {{ session()->get('success') }}
                </div><br />
              @endif
                <form method="post" action="{{ route('update.celebrity.bank.account',$account->id) }}" autocomplete="off">
                    <div class="card-body">
                            @csrf
                            @method('put')
                                <div class="mb-3">
                                  <label for="exampleInputEmail1" class="form-label">Account Holder Name :</label>
                                  <input type="text" name="name_on_account" value="{{ $account->name_on_account }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Bank Name :</label>
                                    <input type="text" name="bank_name" value="{{ $account->bank_name }}" class="form-control" required>
                                  </div>

                              <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Routing Number :</label>
                                <input type="number" name="routing_number" value="{{ $account->routing_number }}" class="form-control" required>
                              </div>
                              <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Routing Number :</label>
                                <input type="number" name="account_number" value="{{ $account->account_number }}" class="form-control" required>
                              </div>
                              <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Selected Gender :</label>
                                <select name="account_type" id="gender" class="form-control">
                                    <option style="background:rgb(33, 32, 32)" value="{{ $account->account_type }}" selected>{{ $account->account_type }}</option>
                                    <option  style="background:rgb(33, 32, 32)" value="Checking Account">Checking Account</option>
                                    <option style="background:rgb(33, 32, 32)" value="Savings Account">Savings Account</option>
                                    <option style="background:rgb(33, 32, 32)" value="Money Market Deposit Account">Money Market Deposit Account</option>
                                    <option style="background:rgb(33, 32, 32)" value="Certificate of Deposit">Certificate of Deposit (CD)</option>
                                </select>
                              </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
