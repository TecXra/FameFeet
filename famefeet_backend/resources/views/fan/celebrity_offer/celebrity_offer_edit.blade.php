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
                    <h5 class="title">{{ __('Edit Offer') }}</h5>
                </div>
            @if(session()->get('success'))
                <div class="alert alert-success">
                  {{ session()->get('success') }}
                </div><br />
              @endif
                <form method="post" action="{{ route('fan.offer.from.celebrity.update',$celebritySendOffer->id) }}" autocomplete="off">
                    <div class="card-body">
                            @csrf
                            @method('put')
                                <div class="mb-3">
                                  <label for="exampleInputEmail1" class="form-label">Title :</label>
                                  <input type="text" name="title" value="{{ $celebritySendOffer->title }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">

                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Price :</label>
                                    <input type="text" name="price" value="{{ $celebritySendOffer->price }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                </div>
                                <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Description :</label>
                                        <input type="text" name="description" value="{{ $celebritySendOffer->description }}" class="form-control" >
                                </div>

                                {{-- <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Quantity :</label>
                                    <input type="text" name="quantity" value="{{ $celebritySendOffer->quantity }}" class="form-control" style="color: white" disabled>
                                </div> --}}

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Status :</label>
                                    <input type="text" name="status" value="{{ $celebritySendOffer->status }}" class="form-control" style="color: white" disabled>
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Offer Send From :</label>
                                    <input type="text"  value="{{ $celebritySendOffer->fan->user->username }}" class="form-control" style="color: white" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Offer Send To :</label>
                                    <input type="text" name="quantity" value="{{ $celebritySendOffer->celebrity->user->username }}" class="form-control" style="color: white" disabled >
                                </div>
                                  {{-- <div class="mb-3">
                                    <select name="category_id[]" class="form-control"  multiple>
                                        @foreach ($categories as $category)
                                            <option  value="{{ $category->id }}">{{ $category->text }}</option>
                                        @endforeach
                                        </select>
                                </div> --}}


                                <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
