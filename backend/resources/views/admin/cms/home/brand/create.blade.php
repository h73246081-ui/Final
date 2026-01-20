@extends('layouts.app')

@section('content')
<h1>Add Brand</h1>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{route('brands.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <label>Name:</label>
    <input type="text" name="name"><br><br>

    <label>Black & White Image:</label>
    <input type="file" name="image_bw"><br><br>

    <label>Color Image:</label>
    <input type="file" name="image_color"><br><br>

    <button type="submit">Add Brand</button>
</form>
@endsection
