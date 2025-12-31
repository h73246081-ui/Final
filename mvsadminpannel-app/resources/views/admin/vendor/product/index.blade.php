@extends('layouts.app')

@section('head')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<style>
#categoryTable thead th {
    background-color: #0d6efd !important;
    color: #fff !important;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">All Vendor Products</h5>
        </div>

        <div class="card-body table-responsive">
            <table id="categoryTable" class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Vendor</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Stock</th>
                        <th>Category</th>
                        <th>Sizes</th>
                        <th>Colors</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $key => $product)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $product->vendor->store_name ?? 'N/A' }}</td>
                        <td>{{ $product->name }}</td>
                        <td>Rs {{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->discount }}%</td>
                        <td>
                            <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                                {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                            </span>
                        </td>
                        <td>{{ $product->category->name ?? 'N/A' }}</td>

                        {{-- Sizes --}}
                        <td>
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

                        @if(count($sizes))
                            @foreach($sizes as $size)
                                <span class="badge bg-info">{{ $size }}</span>
                            @endforeach
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                        </td>

                        {{-- Colors --}}
                        <td>
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

                        @if(count($colors))
                            @foreach($colors as $clr)
                                <span class="badge bg-warning text-dark">{{ $clr }}</span>
                            @endforeach
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                        </td>

                        {{-- Image --}}
<td>
    @if($product->image)
        <img src="{{ asset($product->image) }}" width="50" alt="Product Image">
    @else
        <span class="text-muted">N/A</span>
    @endif
</td>

            

                        {{-- Status --}}
                        <td>
                            <span class="badge bg-success">Active</span>
                        </td>

                        {{-- Action --}}
                        <td>
                            <a href="{{ route('product.show', $product->id) }}" class="btn btn-sm btn-success">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12" class="text-center text-muted">No products found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    $('#categoryTable').DataTable({
        responsive: true,
        autoWidth: false,
        language: {
            search: "🔍 Search:",
            lengthMenu: "Show _MENU_ entries",
            zeroRecords: "No matching records found",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            paginate: { previous: "←", next: "→" }
        }
    });
});
</script>
@endsection
