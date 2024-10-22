@extends('layouts.app')
@section('content')
<h1>Upload</h1>
<form method="POST" action="{{route('upload')}}" enctype="multipart/form-data">
    @csrf
    <input type="file" name="video">
    <button type="submit">Button</button>
</form>
@endsection
