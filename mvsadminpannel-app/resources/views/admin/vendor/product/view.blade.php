@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Product Details: {{ $product->name }}</h5>
        </div>

        <div class="card-body">
            <div class="row g-4">

                <!-- Left Column -->
                <div class="col-md-6">
                    <div class="card mb-3 shadow-sm">
                        <div class="card-header bg-light">
                            <strong>Product Information</strong>
                        </div>
                        <div class="card-body">
                            <p><strong>Vendor:</strong> {{ $product->vendor->store_name ?? 'N/A' }}</p>
                            <p><strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}</p>
                            <p><strong>Price:</strong> <span class="text-success">Rs {{ number_format($product->price, 2) }}</span></p>
                            <p><strong>Discount:</strong> <span class="text-warning">{{ $product->discount }}%</span></p>

                            <p><strong>Stock:</strong>
                                <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                                    {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                                </span>
                            </p>

                            {{-- Sizes --}}
                            @php
                                $sizes = [];
                                if(!empty($product->sizes)) {
                                    if(is_string($product->sizes)) {
                                        $decoded = json_decode($product->sizes, true);
                                        $sizes = is_array($decoded) ? $decoded : explode(',', $product->sizes);
                                    } elseif(is_array($product->sizes)) {
                                        $sizes = $product->sizes;
                                    }
                                }
                            @endphp
                            <p><strong>Sizes:</strong>
                                @if(count($sizes))
                                    @foreach($sizes as $size)
                                        <span class="badge bg-info">{{ $size }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </p>

                            {{-- Colors --}}
                            @php
                                $colors = [];
                                if(!empty($product->color)) {
                                    if(is_string($product->color)) {
                                        $decoded = json_decode($product->color, true);
                                        $colors = is_array($decoded) ? $decoded : explode(',', $product->color);
                                    } elseif(is_array($product->color)) {
                                        $colors = $product->color;
                                    }
                                }
                            @endphp
                            <p><strong>Colors:</strong>
                                @if(count($colors))
                                    @foreach($colors as $clr)
                                        <span class="badge bg-warning text-dark">{{ $clr }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </p>

                            <p><strong>Status:</strong> <span class="badge bg-success">Active</span></p>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6">

                    <div class="card mb-3 shadow-sm">
                        <div class="card-header bg-light">
                            <strong>Product Image</strong>
                        </div>
                        <div class="card-body text-center">
                            @if($product->image)
                                <img src="{{ asset($product->image) }}" class="img-fluid rounded shadow-sm mb-2" style="max-height:250px;">
                            @else
                                <span class="text-muted">No Image Available</span>
                            @endif
                        </div>
                    </div>

                    <div class="card mb-3 shadow-sm">
                        <div class="card-header bg-light">
                            <strong>Description</strong>
                        </div>
                        <div class="card-body">
                            <p>{{ $product->description ?? 'No description available.' }}</p>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <strong>Specification</strong>
                        </div>
                        <div class="card-body">
                            <p>{{ $product->specification ?? 'No specification available.' }}</p>
                        </div>
                    </div>

                </div>

            </div>

            <div class="mt-4">
                <a href="{{ route('product.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Products
                </a>
            </div>

        </div>
    </div>

</div>
@endsection
