@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Add Team Member</h5>
                </div>

                <div class="card-body">
                    <form action="{{route('about.team.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Initial</label>
                            <input type="text" name="initial" maxlength="1" class="form-control" value="{{ old('initial') }}" >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Position</label>
                            <input type="text" name="role" class="form-control" value="{{ old('role') }}" >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Profile Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                        <div class="text-end">
                            <button class="btn btn-success">Save</button>
                            <a href="" class="btn btn-secondary">Cancel</a>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
