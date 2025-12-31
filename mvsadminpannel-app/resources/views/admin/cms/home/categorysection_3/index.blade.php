@extends('layouts.app')

@section('head')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <!-- Centered and wider card -->
        <div class="col-lg-8 col-md-10">
            <div class="card shadow mt-5">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Add Category to Section 3</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('cms.section3.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="category" class="form-label">Select Category</label>
                            <select name="category_id" id="category" class="form-control select2" required>
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-success px-5">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <!-- jQuery (required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2 on category dropdown
            $('#category').select2({
                placeholder: "Select a category",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endsection
