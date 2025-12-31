@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Update About Journey</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('journey.update', $journey->id) }}" method="POST">
                        @csrf
                  
                      {{-- Mission Title --}}
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control"
                                   value="{{ old('title', $journey->title)}}">
                        </div>
                        @error('title')
                            <span class="text-danger">{{$message}}</span>
                        @enderror

                               {{-- Mission Title --}}
                        <div class="mb-3">
                            <label class="form-label">Year</label>
                            <input type="text" name="year" class="form-control"
                                   value="{{ old('year', $journey->year)}}">
                        </div>

                        {{-- Mission Description --}}
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="4" class="form-control">{{ old('description', $journey->description) }}</textarea>
                        </div>

                        {{-- Submit --}}
                        <div class="text-end">
                            <button type="submit" class="btn btn-success">Update About Journey</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
