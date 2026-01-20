@extends('layouts.app')

@section('title', 'Edit Stats')

@section('head')
<style>
.card {
    border: none;
    border-radius: 12px;
}

.card-header {
    background: #f8f9fa;
    font-weight: 600;
    border-radius: 12px 12px 0 0;
}

.form-label {
    font-weight: 600;
    color: #374151;
}

.form-control {
    border-radius: 8px;
}

.btn-success {
    padding: 10px 28px;
    font-weight: 600;
    border-radius: 10px;
}
</style>
@endsection

@section('content')
<div class="container py-4">

    <h3 class="mb-4">Edit About Stats</h3>

    <form action="{{ route('about.stat.update') }}" method="POST">
        @csrf
        @method('PUT')

        @foreach($stats as $index => $stat)
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                Stat #{{ $index + 1 }} — {{ $stat->label }}
            </div>

            <div class="card-body">
                <input type="hidden" name="stats[{{ $index }}][id]" value="{{ $stat->id }}">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Icon</label>
                        <input type="text" class="form-control"
                               name="stats[{{ $index }}][icon]"
                               value="{{ $stat->icon }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Value</label>
                        <input type="text" class="form-control"
                               name="stats[{{ $index }}][value]"
                               value="{{ $stat->value }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Suffix</label>
                        <input type="text" class="form-control"
                               name="stats[{{ $index }}][suffix]"
                               value="{{ $stat->suffix }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Label</label>
                        <input type="text" class="form-control"
                               name="stats[{{ $index }}][label]"
                               value="{{ $stat->label }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Color</label>
                    <input type="text" class="form-control"
                           name="stats[{{ $index }}][color]"
                           value="{{ $stat->color }}">
                    <small class="text-muted">
                        Tailwind gradient example: from-blue-500 to-indigo-500
                    </small>
                </div>
            </div>
        </div>
        @endforeach

        <div class="text-end">
            <button type="submit" class="btn btn-success">
                Update
            </button>
        </div>

    </form>
</div>
@endsection
