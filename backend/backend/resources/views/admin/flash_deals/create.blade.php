@extends('layouts.app')

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container mt-5">
    <h1 class="h3 mb-4">Create Flash Deal</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('flash.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Category (Optional)</label>
                    <select name="category_id" class="form-select select-category">
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Start Date & Time <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="start_at" class="form-control" value="{{ old('start_at') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Discount (%) <span class="text-danger">*</span></label>
                    <input type="number" name="discount" class="form-control" value="{{ old('discount') ?? 0 }}" min="0" max="100" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Description (Optional)</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Product (Optional)</label>
                    <select name="product_id" class="form-select select-product">
                        <option value="">-- Select Product --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-category="{{ $product->category_id }}">
                                {{ $product->name }} ({{ $product->vendor->store_name ?? 'No Vendor' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">End Date & Time <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="end_at" class="form-control" value="{{ old('end_at') }}" required>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" checked>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Create Flash Deal</button>
            <a href="{{ route('flash.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
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

    // Save original products for filtering
    const originalProducts = $('.select-product option').clone();

    // Filter products based on selected category
    $('.select-category').on('change', function() {
        const selectedCategory = $(this).val();
        const $productSelect = $('.select-product');

        // Remove all except placeholder
        $productSelect.empty().append('<option value="">-- Select Product --</option>');

        // Append filtered products
        originalProducts.each(function() {
            const productCategory = $(this).data('category');
            if (selectedCategory === "" || productCategory == selectedCategory) {
                $productSelect.append($(this).clone());
            }
        });

        // Refresh Select2
        $productSelect.val(null).trigger('change');
    });

});
</script>
@endsection
