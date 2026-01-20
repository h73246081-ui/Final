@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Edit SubCategory</h2>

    <form method="POST" action="{{ route('subcategory.update', $subcategory->id) }}">
        @csrf
        @method('PUT') <!-- Important for update -->

        <select name="category_id" class="form-control mb-2">
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ $subcategory->category_id == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>

        <input type="text" name="name" class="form-control mb-2" placeholder="SubCategory Name" 
               value="{{ old('name', $subcategory->name) }}">

        <textarea name="description" class="form-control mb-2" placeholder="Description">{{ old('description', $subcategory->description) }}</textarea>

        <textarea name="question_description" class="form-control mb-2" placeholder="Question Description">{{ old('question_description', $subcategory->question_description) }}</textarea>

        <input type="text" name="meta_title" class="form-control mb-2" placeholder="Meta Title" 
               value="{{ old('meta_title', $subcategory->meta_title) }}">
        <textarea name="meta_description" class="form-control mb-2" placeholder="Meta Description">{{ old('meta_description', $subcategory->meta_description) }}</textarea>
        <input type="text" name="meta_keyword" class="form-control mb-2" placeholder="Meta Keywords" 
               value="{{ old('meta_keyword', $subcategory->meta_keyword) }}">

        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
