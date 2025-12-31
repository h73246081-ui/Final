@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Blog Post</h2>

    <form action="{{ route('cms.blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- PUT method for update -->

        <!-- Blog Details Card -->
        <div class="card mb-4">
            <div class="card-header">Blog Details</div>
            <div class="card-body">
                <div class="row g-3">

                    <!-- Title -->
                    <div class="col-md-6">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $blog->title) }}" required>
                    </div>

                    <!-- Author -->
                    <div class="col-md-6">
                        <label for="author" class="form-label">Author Name</label>
                        <input type="text" name="author" id="author" class="form-control" value="{{ old('author', $blog->author) }}" required>
                    </div>

                    <!-- Author Image -->
                    <div class="col-md-6">
                        <label for="author_image" class="form-label">Author Image</label>
                        <input type="file" name="author_image" id="author_image" class="form-control">
                        @if($blog->author_image)
                            <img src="{{ asset('storage/'.$blog->author_image) }}" alt="Author Image" class="img-thumbnail mt-2" width="100">
                        @endif
                    </div>

                    <!-- Date -->
                    <div class="col-md-6">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" name="date" id="date" class="form-control" value="{{ old('date', \Carbon\Carbon::parse($blog->date)->format('Y-m-d')) }}"  required>
                    </div>

                    <!-- Blog Image -->
                    <div class="col-md-12">
                        <label for="image" class="form-label">Blog Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                        @if($blog->image)
                            <img src="{{ asset('storage/'.$blog->image) }}" alt="Blog Image" class="img-thumbnail mt-2" width="150">
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="5" required>{{ old('description', $blog->description) }}</textarea>
                    </div>

                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Update Blog Post</button>
    </form>
</div>
@endsection
