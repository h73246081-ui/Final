@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Add Blog Post</h2>

    <form action="{{route('cms.blog.store')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Blog Details Card -->
        <div class="card mb-4">
            <div class="card-header">Blog Details</div>
            <div class="card-body">
                <div class="row g-3">

                    <!-- Title -->
                    <div class="col-md-6">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>

                    <!-- Author -->
                    <div class="col-md-6">
                        <label for="author" class="form-label">Author Name</label>
                        <input type="text" name="author" id="author" class="form-control" required>
                    </div>

                    <!-- Author Image -->
                    <div class="col-md-6">
                        <label for="author_image" class="form-label">Author Image</label>
                        <input type="file" name="author_image" id="author_image" class="form-control">
                    </div>

                    <!-- Date -->
                    <div class="col-md-6">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" name="date" id="date" class="form-control" required>
                    </div>

                    <!-- Image -->
                    <div class="col-md-12">
                        <label for="image" class="form-label">Blog Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="5" required></textarea>
                    </div>

                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Add Blog Post</button>
    </form>
</div>
@endsection
