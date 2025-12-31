@extends('layouts.app')
@section('head')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">All Vendor Stores</h5>
                </div>

                <div class="card-body">
                    @if($stores->count() > 0)
                        <div class="table-responsive">
                            <table id="vendorStoreTable" class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Store Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Response Rate (%)</th>
                                        <th>Address</th>
                                        <th>Date</th>
                                        <th>Image</th>
                                        <th>Auction</th>
                                    </tr>
                                </thead>
                                <tbody>
                    @foreach($stores as $store)
                                    <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $store->store_name }}</td>
                    <td>{{ $store->email ?? '-' }}</td>
                    <td>{{ $store->phone ?? '-' }}</td>
                    <td>{{ $store->response_rate }}</td>
                    <td>{{ $store->address ?? 'Lahore' }}</td>
                    <td>{{ $store->date ? $store->date->format('d-m-Y') : now()->format('d-m-Y') }}</td>
                    <td>
                        @if($store->image)
                            <img src="{{ asset($store->image) }}" width="50" class="rounded">
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('show', $store->id) }}" class="btn btn-sm btn-info">
                            View
                        </a>
                    </td>
                    </tr>

                 @endforeach
                         </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-muted">No stores found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <!-- jQuery must come first -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#vendorStoreTable').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    search: "🔍 Search:",
                    lengthMenu: "Show _MENU_ entries",
                    zeroRecords: "No matching records found",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        previous: "←",
                        next: "→"
                    }
                }
            });
        });
    </script>
@endsection
