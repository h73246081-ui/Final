@extends('layouts.app')

@section('title', 'Edit Testimonial')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Edit Team</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('team.update', $team->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                       <div class="mb-3">
                            <label class="form-label">Initial</label>
                            <input type="text" name="initial" maxlength="1" class="form-control" value="{{ old('initial',$team->initial) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $team->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Position</label>
                            <input type="text" name="role" class="form-control" value="{{ old('role', $team->role) }}" required>
                        </div>
 

                        <div class="mb-3">
                            <label class="form-label">Profile Image</label>
                            <input type="file" name="image" class="form-control">
                            @if($team->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/'.$team->image) }}" width="80" class="rounded">
                                </div>
                            @endif
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Update Team</button>
                            <a href="{{ route('cms.about.team') }}" class="btn btn-secondary">Cancel</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
