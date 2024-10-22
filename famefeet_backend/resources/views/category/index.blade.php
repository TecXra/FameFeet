@extends('layouts.app', ['page' => __('Categories'), 'pageSlug' => 'categories'])

    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
  {{--  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script> --}}

@section('content')

<div class="row">
    <div class="col-md-9">
        <form action="" class="form-inline">
            <input id="myInput" class="form-control mr-sm-2" type="search" name="search" value="" placeholder="Search" aria-label="Search" style="width: 60%">
            {{-- <input class="form-control mr-sm-2" type="search" name="search" value="{{ $search }}" placeholder="Search" aria-label="Search" style="width: 60%"> --}}
            {{-- <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button> --}}
          </form>
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

    <div class="row mt-2">
        <div class="card col-8">
            <div class="card-header">
              <h4 class="card-title">Categories Table</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table tablesorter " id="">
                  <thead class=" text-primary">
                    <tr>
                      <th>Name</th>
                      <th>Created At</th>
                      <th>Category Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="myTable">
                      @foreach ($categories as $category)
                      <tr>
                      <td>{{ $category->text }}</td>
                      <td>{{ date("F j, Y, g:i a", strtotime($category->created_at)) }}</td>
                      @if ($category->status == True )
                        <td>
                            <a href="{{ route('category.status',$category->id) }}"
                                style="color:#a8729a; font-size: 16px;
                                 font-weight: bold;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-toggle-on" viewBox="0 0 16 16">
                                    <path d="M5 3a5 5 0 0 0 0 10h6a5 5 0 0 0 0-10H5zm6 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/>
                                  </svg>
                                </a>
                           {{-- <a href="{{ route('category.status',$category->id) }}" class="btn-sm btn-Success">Active</a> --}}
                        </td>
                    @elseif ($category->status == false)
                        <td>
                            <a href="{{ route('category.status',$category->id) }}"
                                style="color:#a8729a;;font-size: 16px;
                                font-weight: bold;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-toggle-off" viewBox="0 0 16 16">
                                <path d="M11 4a4 4 0 0 1 0 8H8a4.992 4.992 0 0 0 2-4 4.992 4.992 0 0 0-2-4h3zm-6 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8zM0 8a5 5 0 0 0 5 5h6a5 5 0 0 0 0-10H5a5 5 0 0 0-5 5z"/>
                            </svg>
                            </a>
                            {{-- <a href="{{ route('category.status',$category->id) }}" class="btn-sm btn-danger">InActive</a> --}}
                        </td>
                    @endif
                          <td>
                            <a href="{{ route('category.edit',$category->id) }}"
                                style="color:#a8729a; font-size: 16px;
                                 font-weight: bold;border-right: 1px solid;
                                 padding-right: 4px;">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                 </svg>
                                </a>
                            <a href="#"
                                style="color:#ed3535; font-size: 16px;
                                font-weight: bold;margin-left:3px">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                  </svg>
                            </a>
                              {{-- <form method="POST" action="{{ route('category.delete',$category->id) }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }} --}}
                                {{-- <div class="form-group"> --}}
                                    {{-- <a href="{{ route('category.edit',$category->id) }}" class="btn-sm btn-primary">Edit</a>
                                    <input type="submit" class="btn-sm btn-danger delete-user" value="Delete"> --}}
                                {{-- </div> --}}
                              {{-- </form> --}}
                            </td>
                      </tr>
                      @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            {{ $categories->links('pagination::bootstrap-4') }}
          </div>

        <div class="col-md-4">
            <div class="card card-user">

                <div class="card-body">
                    <p class="card-text">
                        <div class="author">
                            <div class="block block-one"></div>
                            <div class="block block-two"></div>
                            <div class="block block-three"></div>
                            <div class="block block-four"></div>
                            <h4>ADD New Category</h4>
                        </div>
                    </p>

                    <form method="post" action="{{ route('category.store') }}" autocomplete="off">
                        <div class="card-body">
                                @csrf
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label>{{ __('Category Name') }}</label>
                                    <input type="text" name="text" class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}">
                                    @include('alerts.feedback', ['field' => 'text'])
                                </div>
                                <button type="submit" class="btn btn-fill btn-primary">{{ __('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Trashed Categories</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table tablesorter " id="">
                        <thead class=" text-primary">
                          <tr>
                            <th>Name</th>
                            <th>Deleted At</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                             @foreach ($trashes as $trashe)
                             <tr>
                                <td>{{ $trashe->text }}</td>
                                <td>{{ date("F j, Y", strtotime($trashe->created_at)) }}</td>
                                <td>
                                    <a href="{{ route('category.restore',$trashe->id) }}"
                                        style="color:#a8729a;; font-size: 16px;
                                         font-weight: bold;">
                                         <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                                            <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                                          </svg>
                                        </a>

                                    {{-- <a href="{{ route('category.restore',$trashe->id) }}" class="btn-sm btn-primary">Restore</a> --}}
                                </td>
                             </tr>
                             @endforeach
                        </tbody>
                    </table>
                    {{ $trashes->links('pagination::bootstrap-4') }}
                </div>
            </div>


    </div>
  </div>
</div>

<script>
    $('.delete-user').click(function(e){
        e.preventDefault() // Don't post the form, unless confirmed
        if (confirm('Are you sure?')) {
            // Post the form
            $(e.target).closest('form').submit() // Post the surrounding form
        }
    });
</script>
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
