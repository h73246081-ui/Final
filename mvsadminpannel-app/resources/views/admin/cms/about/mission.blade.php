@extends('layouts.app')

@section('content')
<div class="container mt-2">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Edit Mission</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('about.mission.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Mission Title --}}
                        <div class="mb-3">
                            <label class="form-label">Mission Title</label>
                            <input type="text" name="title" class="form-control"
                                   value="{{ old('title',$mission->title ?? '')}}">
                        </div>

                        {{-- Mission Description --}}
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="4" class="form-control" style="height: 240px;">{{ old('description', $mission->description ?? '') }}</textarea>
                        </div>

                        {{-- Submit --}}
                        <div class="text-end">
                            <button type="submit" class="btn btn-success">Update</button>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
