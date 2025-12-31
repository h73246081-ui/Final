@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Add SubCategory</h2>

    <form method="POST" action="{{ route('subcategory.store') }}">
        @csrf

        <select name="category_id" class="form-control mb-2">
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>

        <input type="text" name="name" class="form-control mb-2" placeholder="SubCategory Name">

        <textarea name="description" class="form-control mb-2" placeholder="Description"></textarea>

        <textarea name="question_description" class="form-control mb-2" placeholder="Question Description"></textarea>

        <input type="text" name="meta_title" class="form-control mb-2" placeholder="Meta Title">
        <textarea name="meta_description" class="form-control mb-2" placeholder="Meta Description"></textarea>
        <input type="text" name="meta_keyword" class="form-control mb-2" placeholder="Meta Keywords">

        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
