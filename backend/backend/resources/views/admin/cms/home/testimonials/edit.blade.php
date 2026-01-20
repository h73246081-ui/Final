@extends('layouts.app')

@section('title', 'Edit Testimonial')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Edit Testimonial</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('cms.testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name', $testimonial->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Profession</label>
                            <input type="text" name="profession" class="form-control"
                                   value="{{ old('profession', $testimonial->role) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-control"
                                   value="{{ old('location', $testimonial->location) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Rating</label>
                            <select name="rating" class="form-select">
                                @for($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}" {{ $testimonial->rating == $i ? 'selected' : '' }}>
                                        {{ str_repeat('⭐', $i) }} ({{ $i }})
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Comments <span class="text-danger">*</span></label>
                            <textarea name="comments" class="form-control" rows="4" required>{{ old('comments', $testimonial->comments) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Profile Image</label>
                            <input type="file" name="image" class="form-control">
                            @if($testimonial->avatar)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/'.$testimonial->avatar) }}" width="80" class="rounded">
                                </div>
                            @endif
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Update Testimonial</button>
                            <a href="{{ route('cms.testimonial.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
