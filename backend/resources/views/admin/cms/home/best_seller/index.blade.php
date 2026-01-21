@extends('layouts.app')

@section('content')
<div class="container mt-4">
<div class="card shadow">
<div class="card-header bg-primary text-white">
<h5 class="mb-0">Vendor Products - Best Seller Management</h5>
</div>

<div class="card-body table-responsive">
<table class="table table-bordered table-hover">
<thead>
<tr>
<th>#</th>
<th>Vendor</th>
<th>Product</th>
<th>Price</th>
<th>Stock</th>
<th>Best Seller</th>
<th>Action</th>
</tr>
</thead>

<tbody>
@foreach($products as $key => $product)
<tr>
<td>{{ $key+1 }}</td>
<td>{{ $product->vendor->store_name ?? 'N/A' }}</td>
<td>{{ $product->name }}</td>
<td>Rs {{ number_format($product->price, 2) }}</td>
<td>{{ $product->stock }}</td>

<td>
@if($product->bestSeller)
<span class="badge bg-success">Yes</span>
@else
<span class="badge bg-secondary">No</span>
@endif
</td>

<td>
<a href="{{ route('admin.best_sellers.toggle', $product->id) }}" class="btn btn-sm btn-warning">
{{ $product->bestSeller ? 'Remove Best Seller' : 'Mark Best Seller' }}
</a>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
</div>
@endsection
