@extends('layouts.app') {{-- Replace with your admin layout --}}

@section('title', 'Edit Stats')

@section('content')
<div class="container py-4">

    <h1 class="mb-4">Edit About Stats</h1>

    <form action="{{route('about.stat.update')}}" method="POST">
        @csrf
        @method('PUT')

        @foreach($stats as $index => $stat)
            <div class="card mb-3">
                <div class="card-header">
                    Stat #{{ $index + 1 }} - {{ $stat->label }}
                </div>
                <div class="card-body">
                    <input type="hidden" name="stats[{{ $index }}][id]" value="{{ $stat->id }}">

                    <div class="mb-3">
                        <label class="form-label">Icon</label>
                        <input type="text" class="form-control" name="stats[{{ $index }}][icon]" value="{{ $stat->icon }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Value</label>
                        <input type="text" class="form-control" name="stats[{{ $index }}][value]" value="{{ $stat->value }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Suffix</label>
                        <input type="text" class="form-control" name="stats[{{ $index }}][suffix]" value="{{ $stat->suffix }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Label</label>
                        <input type="text" class="form-control" name="stats[{{ $index }}][label]" value="{{ $stat->label }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Color</label>
                        <input type="text" class="form-control" name="stats[{{ $index }}][color]" value="{{ $stat->color }}">
                        <small class="text-muted">Tailwind gradient like: from-blue-500 to-indigo-500</small>
                    </div>
                </div>
            </div>
        @endforeach

        <button type="submit" class="btn btn-success">Update All Stats</button>
    </form>
</div>
@endsection
