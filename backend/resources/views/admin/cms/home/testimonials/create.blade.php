{{-- resources/views/testimonials/create.blade.php --}}
@extends('layouts.app') {{-- yahan aap apna main layout ka naam rakhein --}}

@section('title', 'Add Testimonial')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Add Testimonial</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('cms.testimonials.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter name" required>
                        </div>

                        <div class="mb-3">
                            <label for="profession" class="form-label">Profession</label>
                            <input type="text" name="profession" id="profession" class="form-control" placeholder="Enter profession">
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" name="location" id="location" class="form-control" placeholder="Enter location">
                        </div>

                              <div class="mb-3">
            <label class="form-label fw-semibold">Rating</label>
            <select name="rating" class="form-select">
                <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                <option value="4">⭐⭐⭐⭐ (4)</option>
                <option value="3">⭐⭐⭐ (3)</option>
                <option value="2">⭐⭐ (2)</option>
                <option value="1">⭐ (1)</option>
            </select>
        </div>

                        <div class="mb-3">
                            <label for="comments" class="form-label">Comments <span class="text-danger">*</span></label>
                            <textarea name="comments" id="comments" class="form-control" rows="4" placeholder="Enter comments" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success">Submit Testimonial</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
