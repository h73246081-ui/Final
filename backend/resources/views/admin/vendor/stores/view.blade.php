@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Store Info Card -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $store->store_name }}</h4>
                    <a href="{{ route('store.index') }}" class="btn btn-light btn-sm ms-auto">
                        <i class="bi bi-arrow-left-circle me-1"></i> Back to Stores
                    </a>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4 text-center">
                            @if($store->image)
                                <img src="{{ asset($store->image) }}" class="rounded w-100 shadow-sm" alt="Store Image">
                            @else
                                <img src="{{ asset('assets/img/no-image.png') }}" class="rounded w-100 shadow-sm" alt="No Image">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Email:</strong> {{ $store->email ?? '-' }}</li>
                                <li class="list-group-item"><strong>Phone:</strong> {{ $store->phone ?? '-' }}</li>
                                <li class="list-group-item"><strong>Address:</strong> {{ $store->address ?? 'Lahore' }}</li>
                                <li class="list-group-item"><strong>Response Rate:</strong> {{ $store->response_rate }}%</li>
                                <li class="list-group-item"><strong>Date:</strong> {{ $store->date ? $store->date->format('d-m-Y') : now()->format('d-m-Y') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Products in this Store ({{ $store->vendorProducts->count() }})</h5>
                </div>
                <div class="card-body p-0">
                    @if($store->vendorProducts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Image</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($store->vendorProducts as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ number_format($product->price, 2) }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td>
                                            @if($product->image)
                                                <img src="{{ asset($product->image) }}" width="50" class="rounded">
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-3 text-center text-muted">
                            No products found for this store.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
