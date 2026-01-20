@extends('layouts.app')

@section('head')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<!-- Buttons for Excel/PDF Export -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<!-- SweetAlert CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    /* Main Card Styling */
    .main-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .card-header-custom {
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
        border-radius: 12px 12px 0 0;
        padding: 20px 25px;
    }

    /* Filter Card */
    .filter-card {
        background-color: #f8fafc;
        border-left: 4px solid #0d6efd;
        border-radius: 8px;
        padding: 15px;
    }

    /* Table header style */
    #vendorTable thead th {
        background-color: #0d6efd !important;
        color: #fff !important;
        font-weight: 600;
    }

    /* Button polish */
    .btn-export {
        border-radius: 6px;
        font-weight: 500;
        padding: 8px 16px;
        transition: all 0.3s ease;
    }

    .btn-export:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Filter input styling */
    .filter-input {
        border-radius: 8px;
        border: 1px solid #d1d5db;
        transition: all 0.3s ease;
    }

    .filter-input:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
    }

    /* User image styling */
    .user-avatar {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #dee2e6;
    }

    /* Status styling */
    .status-label {
        font-weight: bold;
    }

    .status-label.active {
        color: #28a745;
    }

    .status-label.inactive {
        color: #dc3545;
    }

    /* Switch styling */
    .form-check-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }

    /* Store badge */
    .store-badge {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
        padding: 3px 10px;
        border-radius: 15px;
        font-size: 0.85em;
    }

    /* Action buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    /* Responsive table fixes */
    .table-responsive {
        overflow-x: auto;
    }
</style>
<style>
    /* Responsive styles */
    @media (max-width: 768px) {
        .card-header-custom {
            padding: 1rem !important;
        }

        .card-header-custom h4 {
            font-size: 1.25rem;
        }

        .btn-export {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }

        .btn i {
            margin-right: 0.25rem !important;
        }
    }

    @media (max-width: 576px) {
        .card-header-custom .col-md-6 {
            text-align: center;
        }

        .d-flex.flex-wrap {
            justify-content: center !important;
            gap: 10px !important;
        }

        .btn {
            flex: 1;
            min-width: 90px;
        }

        .card-header-custom h4 {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 400px) {
        .d-flex.flex-wrap {
            flex-direction: column;
            width: 100%;
        }

        .btn-export {
            width: 100%;
            justify-content: center;
            margin-bottom: 5px;
        }
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <!-- Main Card containing everything -->
    <div class="card main-card" style="margin-top: -30px;">
        <!-- Card Header with Title -->
        <!-- Card Header with Title -->
<div class="card-header card-header-custom">
    <div class="row align-items-center">
        <!-- Title on Left -->
        <div class="col-12 col-md-6 mb-3 mb-md-0">
            <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                <i class="bi bi-shop text-white fs-3 me-3"></i>
                <h4 class="mb-0 text-white">Sellers Management</h4>
            </div>
        </div>

        <!-- Buttons on Right -->
        <div class="col-12 col-md-6">
            <div class="d-flex flex-wrap justify-content-center justify-content-md-end align-items-center gap-2">
                <button id="exportExcel" class="btn btn-success btn-export">
                    <i class="bi bi-file-earmark-excel me-1"></i>
                    <span class="d-none d-sm-inline">Export Excel</span>
                    <span class="d-inline d-sm-none">Excel</span>
                </button>
                <button id="exportPDF" class="btn btn-danger btn-export">
                    <i class="bi bi-file-earmark-pdf me-1"></i>
                    <span class="d-none d-sm-inline">Export PDF</span>
                    <span class="d-inline d-sm-none">PDF</span>
                </button>
            </div>
        </div>
    </div>
</div>



        <!-- Card Body with Filter Section -->
        <div class="card-body">
            <!-- Filter Card -->
            <div class="filter-card mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0 text-primary"><i class="bi bi-funnel me-2"></i>Filter Options</h6>
                    <div class="text-muted">
                        <small><i class="bi bi-people me-1"></i>{{ $vendors->count() }} sellers found</small>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Search Seller</label>
                        <input type="text" id="searchSeller" class="form-control filter-input" placeholder="Search by name...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Store Name</label>
                        <input type="text" id="searchStore" class="form-control filter-input" placeholder="Search store...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="text" id="searchEmail" class="form-control filter-input" placeholder="Search email...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select id="filterStatus" class="form-control filter-input">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 d-flex justify-content-between">
                        <button id="clearFilters" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-x-circle me-1"></i>Clear Filters
                        </button>
                        <div class="text-muted">
                            <small><i class="bi bi-clock-history me-1"></i>Updated just now</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DataTable -->
            <div class="table-responsive">
                <table id="vendorTable" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th width="50">#</th>
                            <th>Image</th>
                            <th>Seller</th>
                            <th>Store</th>
                            <th>Phone</th>
                            <th>CNIC</th>
                            <th>Email</th>
                            <th>NTN</th>
                            <th>Bank</th>
                            <th>Bank Account</th>
                            <th>Status</th>
                            <th width="100" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vendors as $index => $vendor)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @if($vendor->image)
                                    <img src="{{ asset($vendor->image) }}" class="user-avatar" alt="{{ $vendor->user->name }}">
                                @else
                                    <div class="user-avatar bg-secondary d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person text-white"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $vendor->user->name }}</div>
                            </td>
                            <td>
                                @if($vendor->vendorStore && $vendor->vendorStore->store_name)
                                    <span class="store-badge">{{ $vendor->vendorStore->store_name }}</span>
                                @else
                                    <span class="text-muted">No Store</span>
                                @endif
                            </td>
                            <td>
                                @if($vendor->phone)
                                    <a href="tel:{{ $vendor->phone }}" class="text-decoration-none">
                                        <i class="bi bi-telephone me-1"></i>{{ $vendor->phone }}
                                    </a>
                                @elseif($vendor->user->phone)
                                    <a href="tel:{{ $vendor->user->phone }}" class="text-decoration-none">
                                        <i class="bi bi-telephone me-1"></i>{{ $vendor->user->phone }}
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{$vendor->cnic_number}}</td>
                            <td>
                                <a href="mailto:{{ $vendor->user->email }}" class="text-decoration-none">
                                    <i class="bi bi-envelope me-1"></i>{{ $vendor->user->email ?? '-' }}
                                </a>
                            </td>
                            <td>
                                {{$vendor->ntn_number}}
                            </td>
                            <td>
                                {{$vendor->bank_name}}
                            </td>
                            <td>
                                {{$vendor->bank_account}}
                            </td>
                            <td>
                                <div class="form-check form-switch d-inline-block">
                                    <input class="form-check-input toggle-status"
                                           type="checkbox"
                                           data-id="{{ $vendor->id }}"
                                           {{ $vendor->status === 'active' ? 'checked' : '' }}>
                                    <label class="form-check-label status-label {{ $vendor->status }}">
                                        {{ ucfirst($vendor->status) }}
                                    </label>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <form action="{{ route('vendor.delete', $vendor->id) }}"
                                          method="POST"
                                          class="d-inline deleteForm">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete"
                                                title="Delete Seller">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="bi bi-shop fs-1 d-block mb-2"></i>
                                No sellers found. Register your first seller!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- Export Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {
    // Initialize DataTable with Export Buttons
    var table = $('#vendorTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        dom: '<"row"<"col-md-6"l><"col-md-6"f>><"row"<"col-md-12"tr>><"row"<"col-md-5"i><"col-md-7"p>>',
        language: {
            search: "🔍 Quick Search:",
            lengthMenu: "Show _MENU_ entries",
            zeroRecords: "No matching sellers found",
            info: "Showing _START_ to _END_ of _TOTAL_ sellers",
            infoEmpty: "No sellers available",
            infoFiltered: "(filtered from _MAX_ total sellers)",
            paginate: {
                previous: "← Previous",
                next: "Next →"
            }
        },
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="bi bi-file-earmark-excel me-1"></i>Excel',
                className: 'btn btn-success btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                },
                title: 'Sellers_Export_' + new Date().toISOString().slice(0,10)
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="bi bi-file-earmark-pdf me-1"></i>PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                },
                title: 'Sellers_Export_' + new Date().toISOString().slice(0,10),
                customize: function (doc) {
                    doc.content[1].table.widths = ['5%', '8%', '15%', '12%', '12%', '15%', '15%', '10%', '8%'];
                }
            }
        ],
        initComplete: function() {
            // Add export buttons to the export section
            $('.export-buttons').html($('.dt-buttons'));
        }
    });

    // Filter by Seller Name
    $('#searchSeller').on('keyup', function() {
        table.column(2).search(this.value).draw();
    });

    // Filter by Store Name
    $('#searchStore').on('keyup', function() {
        table.column(3).search(this.value).draw();
    });

    // Filter by Email
    $('#searchEmail').on('keyup', function() {
        table.column(6).search(this.value).draw();
    });

    // Filter by Status
    $('#filterStatus').on('change', function() {
        var statusFilter = this.value;
        if (statusFilter) {
            table.column(7).search(statusFilter, true, false).draw();
        } else {
            table.column(7).search('').draw();
        }
    });

    // Clear all filters
    $('#clearFilters').on('click', function() {
        $('#searchSeller').val('');
        $('#searchStore').val('');
        $('#searchEmail').val('');
        $('#filterStatus').val('');

        table.columns().search('').draw();
        table.search('').draw();
    });

    // Export Excel button
    $('#exportExcel').on('click', function() {
        table.button('.buttons-excel').trigger();
    });

    // Export PDF button
    $('#exportPDF').on('click', function() {
        table.button('.buttons-pdf').trigger();
    });

    // Delete confirmation
    $('.btn-delete').on('click', function(e) {
        e.preventDefault();
        let form = $(this).closest('.deleteForm');

        Swal.fire({
            title: 'Are you sure?',
            text: "This seller will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return new Promise((resolve) => {
                    setTimeout(() => {
                        form.submit();
                        resolve();
                    }, 1000);
                });
            }
        });
    });

    // View seller details
    $('.view-seller-btn').on('click', function() {
        let sellerId = $(this).data('id');
        // You can implement a modal or redirect to detail page here
        window.location.href = '/vendors/' + sellerId;
    });

    // Status toggle
    $(document).on('change', '.toggle-status', function() {
        let vendorId = $(this).data('id');
        let status = $(this).is(':checked') ? 'active' : 'inactive';
        let label = $(this).siblings('.status-label');
        let statusText = status.charAt(0).toUpperCase() + status.slice(1);

        // Update label immediately for better UX
        label.removeClass('active inactive').addClass(status).text(statusText);

        // Show loading state
        let originalText = label.text();
        label.text('Updating...');

        $.ajax({
            url: '{{ route("vendor.toggleStatus") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: vendorId,
                status: status
            },
            success: function(response) {
                if (response.success) {
                    label.text(statusText);
                    Swal.fire({
                        title: 'Success!',
                        text: 'Seller status updated successfully',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    // Revert if failed
                    $(this).prop('checked', !$(this).prop('checked'));
                    label.text(originalText);
                    Swal.fire('Error!', 'Failed to update status', 'error');
                }
            },
            error: function() {
                // Revert on error
                $(this).prop('checked', !$(this).prop('checked'));
                label.text(originalText);
                Swal.fire('Error!', 'Network error occurred', 'error');
            }
        });
    });
});
</script>
@endsection