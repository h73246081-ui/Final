@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Category to Section 1</h1>

    <form action="" method="POST">
        @csrf
        <div class="mb-3">
            <label for="category" class="form-label">Select Category</label>
            <select name="category_id" id="category" class="form-control" required>
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
@endsection
