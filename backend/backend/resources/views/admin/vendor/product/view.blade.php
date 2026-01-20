@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow">
        <div class="card-header bg-primary text-white" style="display: flex;">
            <h5 class="mb-0">Product Details: {{ $product->name }}</h5>

                <a href="{{ route('product.index') }}" class="btn btn-secondary" style="margin-left: 651px;">
                    <i class="bi bi-arrow-left"></i> Back
                </a>

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

                            <p><strong>Seller Store:</strong> {{ $product->vendor->vendorStore->store_name ?? 'N/A' }}</p>
                            <p><strong>Seller Name:</strong> {{ $product->vendor->user->name ?? 'N/A' }}</p>
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

                            <p><strong>Status:</strong> <span class="badge bg-success">{{$product->status}}</span></p>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6">

                    <div class="card-body text-center">
                        @php
                            // image already array hai
                            $images = is_array($product->image)
                                ? $product->image
                                : json_decode($product->image, true);
                        @endphp

                        @if(is_array($images) && count($images))
                            @foreach($images as $img)
                                <img src="{{ asset($img) }}"
                                     class="img-fluid rounded shadow-sm mb-2"
                                     style="max-height:250px;" width="60" height="60">
                            @endforeach
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
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



        </div>
    </div>

</div>
@endsection
