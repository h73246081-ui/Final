@extends('layouts.app')

@section('head')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container mt-5">
    <h1 class="h3 mb-4">Edit Flash Deal</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('flash.update', $deal->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-6">
                <!-- Title -->
                <div class="mb-3">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $deal->title) }}" required>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label class="form-label">Description (Optional)</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $deal->description) }}</textarea>
                </div>

                <!-- Category -->
                <div class="mb-3">
                    <label class="form-label">Category (Optional)</label>
                    <select name="category_id" class="form-select select-category">
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $deal->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text">Category deal applies to all products in this category</div>
                </div>

                <!-- Discount -->
                <div class="mb-3">
                    <label class="form-label">Discount (%) <span class="text-danger">*</span></label>
                    <input type="number" name="discount" class="form-control" value="{{ old('discount', $deal->discount) }}" min="0" max="100" required>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-6">
                <!-- Start Date -->
                <div class="mb-3">
                    <label class="form-label">Start Date & Time <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="start_at" class="form-control" 
                        value="{{ old('start_at', \Carbon\Carbon::parse($deal->start_at)->format('Y-m-d\TH:i')) }}" required>
                </div>

                <!-- End Date -->
                <div class="mb-3">
                    <label class="form-label">End Date & Time <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="end_at" class="form-control" 
                        value="{{ old('end_at', \Carbon\Carbon::parse($deal->end_at)->format('Y-m-d\TH:i')) }}" required>
                </div>

                <!-- Product (Optional) -->
                <div class="mb-3">
                    <label class="form-label">Product (Optional)</label>
                    <select name="product_id" class="form-select select-product">
                        <option value="">-- Select Product --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-category="{{ $product->category_id }}"
                                {{ old('product_id', $deal->product_id) == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} ({{ $product->vendor->store_name ?? 'No Vendor' }})
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text">Leave empty if this is a category-wide deal</div>
                </div>

                <!-- Status -->
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ $deal->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Update Flash Deal</button>
            <a href="{{ route('flash.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
    <!-- Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {

            // Initialize Select2
            $('.select-category').select2({
                placeholder: "Search Category...",
                allowClear: true,
                width: '100%'
            });

            $('.select-product').select2({
                placeholder: "Search Product...",
                allowClear: true,
                width: '100%'
            });

            // Store original product options
            const $allProducts = $('.select-product option').clone();

            // Filter products on category change
            $('.select-category').on('change', function() {
                const selectedCategory = $(this).val();
                const $productSelect = $('.select-product');

                $productSelect.empty().append('<option value="">-- Select Product --</option>');

                $allProducts.each(function() {
                    const productCategory = $(this).data('category');
                    if (selectedCategory === "" || productCategory == selectedCategory) {
                        $productSelect.append($(this).clone());
                    }
                });

                // Reset selection
                $productSelect.val("").trigger('change');
            });

            // Trigger filter on page load to show correct products for selected category
            $('.select-category').trigger('change');
        });
    </script>
@endsection
