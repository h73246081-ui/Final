@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Store Info Card -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Order Detail</h4>
                    <a href="{{ route('allOrder') }}" class="btn btn-light btn-sm ms-auto">
                        <i class="bi bi-arrow-left-circle me-1"></i> Back to Orders
                    </a>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4 text-center">
                            {{-- @if($store->image)
                                <img src="{{ asset($store->image) }}" class="rounded w-100 shadow-sm" alt="Store Image">
                            @else
                                <img src="{{ asset('assets/img/no-image.png') }}" class="rounded w-100 shadow-sm" alt="No Image">
                            @endif --}}
                        </div>
                        <div class="col-md-12">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Name:</strong> {{ $order->first_name ?? '-' }}</li>
                                <li class="list-group-item"><strong>Last Name:</strong> {{ $order->last_name ?? '-' }}</li>
                                <li class="list-group-item"><strong>Email:</strong> {{ $order->email ?? '-' }}</li>
                                <li class="list-group-item"><strong>Phone:</strong> {{ $order->phone ?? '-' }}</li>
                                <li class="list-group-item"><strong>Address:</strong> {{ $order->address ?? 'Lahore' }}</li>
                                <li class="list-group-item"><strong>Total Bill:</strong> {{ $order->total_bill }}</li>
                                <li class="list-group-item"><strong>Date:</strong> {{ $order->created_at->format('d-m-y') }}</li>
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
                    <h5 class="mb-0">Order Items</h5>
                </div>
                <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Seller Store</th>
                                        <th>Seller Name</th>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Color</th>
                                        <th>Image</th>
                                        <th>Size</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->vendorOrders as $vendorOrder)
                                        @foreach($vendorOrder->items as $item)
                                            <tr>
                                                <td>{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>

                                                <td>{{ optional($vendorOrder->vendor)->store_name ?? '-' }}</td>
                                                <td>{{ $vendorOrder->vendor->user->name }}</td>

                                                <td>{{ $item->product_name ?? '-' }}</td>

                                                <td>{{ $item->price ?? 0 }}</td>

                                                <td>{{ $item->quantity ?? 0 }}</td>

                                                <td>
                                                    {{ $item->color }}
                                                </td>

                                                <td>
                                                    @if($item->image)
                                                        <img src="{{ asset($item->image) }}" width="50" class="rounded">
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>

                                                <td>
                                                    {{$item->size}}
                                                </td>


                                                <td>{{ $item->total ?? 0 }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                    </tbody>

                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
