@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
<div class="container p-4">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">All Vendors</h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="vendorTable" class="table table-bordered table-hover align-middle p-1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Store Name</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vendors as $index => $vendor)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if($vendor->image)
                                                <img src="{{ asset('storage/'.$vendor->image) }}" class="rounded-circle" width="40" height="40">
                                            @else
                                                <img src="{{ asset('assets/img/tijaar2.jpeg') }}" class="rounded-circle" width="40" height="40">
                                            @endif
                                        </td>
                                        <td>{{ $vendor->store_name }}</td>
                                        <td>{{ $vendor->phone ?? $vendor->user->phone ?? '0300000000' }}</td>
                                        <td>{{ $vendor->address ?? 'Pakistan' }}</td>
                                        <td>{{ $vendor->user->email ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No vendors found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

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
    $('#vendorTable').DataTable({
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
