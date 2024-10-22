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
              <b> {{ session()->get('success') }}</span>
          </div>
      @endif
    </div>
    <div class="card ">
      <div class="card-header">
        <h4 class="card-title">All Fan Offers To Celebrity</h4>
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
                <th>Status</th>
                <th>Send To</th>
                <th>Send Offer Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($offers as $offer)
                <tr>
                <td>{{$offer->title}}</td>
                <td>{{$offer->coins}}</td>
                <td>{{(Str::length($offer->description) > 50) ? Str::substr($offer->description, 0,50).'...':$offer->description}}</td>
                @if ($offer->content_type == config('famefeet.content_type.images'))
                    <td>Images</td>
                @elseif ($offer->content_type == config('famefeet.content_type.videos'))
                    <td>Videos</td>
                @endif
                <td>{{ $offer->status }}</td>
                <td>
                    <img src="/{{ $offer->celebrity->user->avatar }}" alt=""
                    style="border-radius: 5.2857rem;
                    width: 30px;">
                    {{ $offer->celebrity->user->username }}</td>
                <td>{{date("F j, Y, g:i a", strtotime($offer->created_at))}}</td>
                <td>
                    <a href="{{ route('fan.offer.edit',$offer->id) }}"
                        style="color:#a8729a;; font-size: 16px;
                         font-weight: bold;border-right: 1px solid;
                         padding-right: 4px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                        </svg>
                    </a>
                    <a href="{{ route('fan.offer.show',$offer->id) }}"
                    style="color:#13dbed;; font-size: 16px;
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
          {{ $offers->links('pagination::bootstrap-4'); }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
