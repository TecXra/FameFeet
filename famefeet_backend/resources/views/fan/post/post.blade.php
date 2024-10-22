
@extends('fan.show')
@section('fansection')

<div class="row mt-2">
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
        <h4 class="card-title">All Buy Content</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table tablesorter ">
            <thead class=" text-primary">
              <tr>
                <th>User</th>
                <th>Title</th>
                <th>Price</th>
                <th>Description</th>
                <th>Content Type</th>
                <th>Post Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($contents as $content)
                <tr>
                @if(isset($content->post))
                  <td> <img src="/{{ $content->post->celebrity->user->avatar ?? '' }}" alt=""
                        style="border-radius: 5.2857rem;
                        width: 30px;">
                       {{ $content->post->celebrity->user->username ?? '' }}
                  </td>
                  <td>
                      {{$content->post->title}}
                  </td>
                  <td>{{$content->post->price}}</td>
                  <td>{{(Str::length($content->post->description) > 50) ? Str::substr($content->post->description, 0,50).'...':$content->post->description}}</td>
                  @if ($content->post->content_type == config('famefeet.content_type.images'))
                      <td>Images</td>
                  @elseif ($content->post->content_type == config('famefeet.content_type.videos'))
                      <td>Videos</td>
                  @endif
                  <td>{{date("F j, Y, g:i a", strtotime($content->post->created_at))}}</td>
                  <td>

                      <a href="{{ route('fan.buy.content.show',$content->id) }}"
                      style="color:#13dbed;; font-size: 16px;
                      font-weight: bold;margin-left:4px;">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-ticket-detailed" viewBox="0 0 16 16">
                          <path d="M4 5.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5Zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5ZM5 7a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2H5Z"/>
                          <path d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5V6a.5.5 0 0 1-.5.5 1.5 1.5 0 0 0 0 3 .5.5 0 0 1 .5.5v1.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 11.5V10a.5.5 0 0 1 .5-.5 1.5 1.5 0 1 0 0-3A.5.5 0 0 1 0 6V4.5ZM1.5 4a.5.5 0 0 0-.5.5v1.05a2.5 2.5 0 0 1 0 4.9v1.05a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-1.05a2.5 2.5 0 0 1 0-4.9V4.5a.5.5 0 0 0-.5-.5h-13Z"/>
                      </svg>
                      </a>
                      <a onclick="alert('Are you sure to delete this purchase content')" href="{{ route('fan.buy.content.delete',$content->id) }}"
                          style="color:#ed3535;; font-size: 16px;
                          font-weight: bold;border-left: 1px solid;
                          padding-left: 4px;">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                              <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                              <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                            </svg>
                      </a>
                      {{-- <a href="" class="btn-sm btn-primary">Edit</a> --}}
                      {{-- <a href="" class="btn-sm btn-success">Details</a> --}}
                  </td>
                  @endif
                </tr>
                @endforeach
            </tbody>
          </table>
          {{ $contents->links('pagination::bootstrap-4'); }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
