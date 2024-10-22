@extends('layouts.app', ['page' => __('Post'), 'pageSlug' => 'post'])
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
@section('content')
<div class="row">

    <div class="col-md-9 mb-3">
        <form action="" class="form-inline">
            <input id="myInput" class="form-control mr-sm-2" type="search" name="search" value="" placeholder="Search" aria-label="Search" style="width: 60%">
            {{-- <input class="form-control mr-sm-2" type="search" name="search" value="{{ $search }}" placeholder="Search" aria-label="Search" style="width: 60%"> --}}
            {{-- <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button> --}}
          </form>
    </div>

  <div class="col-md-12">
    <div class="col-5">
        @if(session()->get('success'))
        <div class="alert alert-success">
            <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
              <i class="tim-icons icon-simple-remove"></i>
            </button>
            <span>
              <b> {{ session()->get('success') }}
            </span>
          </div>
      @endif
    </div>
    <div class="card ">
      <div class="card-header">
        <h4 class="card-title">All Posts</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table tablesorter ">
            <thead class=" text-primary">
              <tr>
                <th>Title</th>
                <th>Price</th>
                <th>Description</th>
                <th>Content Type</th>
                <th>Post Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="myTable">
                @foreach ($posts as $post)
                <tr>
                <td>{{$post->title}}</td>
                <td>{{$post->price}}</td>
                <td>{{(Str::length($post->description) > 50) ? Str::substr($post->description, 0,50).'...':$post->description}}</td>
                @if ($post->content_type == 5)
                    <td>Images</td>
                @elseif ($post->content_type == 6)
                    <td>Videos</td>
                @endif
                <td>{{date("F j, Y, g:i a", strtotime($post->created_at))}}</td>
                <td>
                    <a href="{{ route('post.edit',$post->id) }}" class="btn-sm btn-primary">Edit</a>
                    <a href="{{ route('post.show',$post->id) }}" class="btn-sm btn-success">Details</a>
                </td>
                </tr>
                @endforeach
            </tbody>
          </table>
          {{ $posts->links('pagination::bootstrap-4'); }}
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
