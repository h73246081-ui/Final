@extends('layouts.app') {{-- Replace with your admin layout --}}

@section('title', 'Edit Stats')

@section('content')
<div class="container py-4">

    <h1 class="mb-4">Edit Home Stats</h1>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('cms.stat.update') }}" method="POST">
        @csrf
        @method('PUT')

        @foreach($stats as $index => $stat)
            <div class="card mb-4 shadow-sm">
                <div class="card-header fw-bold">
                    Stat #{{ $index + 1 }} - {{ $stat->label }}
                </div>

                <div class="card-body">
                    <input type="hidden" name="stats[{{ $index }}][id]" value="{{ $stat->id }}">

                    {{-- Row 1 --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Icon</label>
                            <input type="text"
                                   class="form-control"
                                   name="stats[{{ $index }}][icon]"
                                   value="{{ $stat->icon }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Value</label>
                            <input type="text"
                                   class="form-control"
                                   name="stats[{{ $index }}][value]"
                                   value="{{ $stat->value }}">
                        </div>
                    </div>

                    {{-- Row 2 --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Suffix</label>
                            <input type="text"
                                   class="form-control"
                                   name="stats[{{ $index }}][suffix]"
                                   value="{{ $stat->suffix }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Label</label>
                            <input type="text"
                                   class="form-control"
                                   name="stats[{{ $index }}][label]"
                                   value="{{ $stat->label }}">
                        </div>
                    </div>

                    {{-- Row 3 --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Color</label>
                            <input type="text"
                                   class="form-control"
                                   name="stats[{{ $index }}][color]"
                                   value="{{ $stat->color }}">
                            <small class="text-muted">
                                Tailwind gradient like: from-blue-500 to-indigo-500
                            </small>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach

        {{-- Submit Button --}}
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-success px-4">
                Update All Stats
            </button>
        </div>

    </form>
</div>
@endsection
