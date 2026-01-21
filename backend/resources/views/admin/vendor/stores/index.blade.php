@extends('layouts.app')

@section('head')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<!-- Buttons for Excel/PDF Export -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<style>
    /* Main Card Styling */
    .main-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .card-header-custom {
        background: #0d6efd;
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
    #vendorStoreTable thead th {
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
        box-shadow: 0 0 0 3px rgba(32, 201, 151, 0.15);
    }

    /* Store image styling */
    .store-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #dee2e6;
    }

    /* Response rate styling */
    .response-rate {
        font-weight: bold;
        color: #0d6efd;
    }

    .rate-excellent { color: #198754; }
    .rate-good { color: #20c997; }
    .rate-average { color: #fd7e14; }
    .rate-poor { color: #dc3545; }

    /* Status badges */
    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.85em;
        font-weight: 500;
    }

    .status-active {
        background-color: rgba(25, 135, 84, 0.1);
        color:#0d6efd;
        border: 1px solid#0d6efd;
    }

    .status-inactive {
        background-color: rgba(220, 53, 69, 0.1);
        color: #0d6efd;
        border: 1px solid #0d6efd;
    }

    /* Action buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    /* Store name styling */
    .store-name {
        font-weight: 600;
        color: #2c3e50;
    }

    /* Address styling */
    .store-address {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Responsive table */
    .table-responsive {
        overflow-x: auto;
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <!-- Main Card containing everything -->
    <div class="card main-card" style="margin-top: -30px;">
        <!-- Card Header with Title -->
<!-- Card Header with Title -->
<div class="card-header card-header-custom bg-primary">
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
        <!-- Card Body with Filter Section -->
        <div class="card-body">
            <!-- Filter Card -->
            <div class="filter-card mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0 text-primary"><i class="bi bi-funnel me-2"></i>Filter Options</h6>
                    <div class="text-muted">
                        <small><i class="bi bi-shop me-1"></i>{{ $stores->count() }} stores found</small>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Store Name</label>
                        <input type="text" id="searchStoreName" class="form-control filter-input" placeholder="Search store...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="text" id="searchEmail" class="form-control filter-input" placeholder="Search email...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Phone</label>
                        <input type="text" id="searchPhone" class="form-control filter-input" placeholder="Search phone...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Response Rate</label>
                        <select id="filterResponseRate" class="form-control filter-input">
                            <option value="">All Rates</option>
                            <option value="90-100">Excellent (90-100%)</option>
                            <option value="70-89">Good (70-89%)</option>
                            <option value="50-69">Average (50-69%)</option>
                            <option value="0-49">Poor (0-49%)</option>
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
            @if($stores->count() > 0)
                <div class="table-responsive">
                    <table id="vendorStoreTable" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>Store Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Response Rate</th>
                                <th>Address</th>
                                <th>Date</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th width="100" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stores as $store)
                            @php
                                // Determine rate color
                                $rate = $store->response_rate;
                                $rateClass = '';
                                if ($rate >= 90) $rateClass = 'rate-excellent';
                                elseif ($rate >= 70) $rateClass = 'rate-good';
                                elseif ($rate >= 50) $rateClass = 'rate-average';
                                else $rateClass = 'rate-poor';
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="store-name">{{ $store->store_name }}</div>
                                    @if($store->vendor)
                                        <small class="text-muted">Seller: {{ $store->vendor->user->name ?? 'N/A' }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($store->email)
                                        <a href="mailto:{{ $store->email }}" class="text-decoration-none">
                                            <i class="bi bi-envelope me-1"></i>{{ $store->email }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($store->phone)
                                        <a href="tel:{{ $store->phone }}" class="text-decoration-none">
                                            <i class="bi bi-telephone me-1"></i>{{ $store->phone }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="response-rate {{ $rateClass }}">
                                        {{ $store->response_rate }}%
                                    </div>
                                    <div class="progress" style="height: 5px; width: 80px;">
                                        <div class="progress-bar {{ $rateClass == 'rate-excellent' ? 'bg-success' : ($rateClass == 'rate-good' ? 'bg-info' : ($rateClass == 'rate-average' ? 'bg-warning' : 'bg-danger')) }}"
                                             role="progressbar"
                                             style="width: {{ min($rate, 100) }}%">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="store-address" title="{{ $store->address ?? 'Lahore' }}">
                                        {{ $store->address ?? 'Lahore' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="small">{{ $store->date ? $store->date->format('d M, Y') : now()->format('d M, Y') }}</div>
                                    <div class="text-muted">{{ $store->created_at->format('h:i A') }}</div>
                                </td>
                                <td>
                                    @if($store->image)
                                        <img src="{{ asset($store->image) }}" class="store-image" alt="{{ $store->store_name }}">
                                    @else
                                        <div class="store-image bg-light d-flex align-items-center justify-content-center">
                                            <i class="bi bi-shop text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $status = strtolower($store->status);
                                        $statusClass = $status == 'active' ? 'status-active' : 'status-inactive';
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">
                                        {{ ucfirst($store->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <a href="{{ route('show', $store->id) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        {{-- <button class="btn btn-sm btn-outline-info edit-store-btn"
                                                data-id="{{ $store->id }}"
                                                title="Edit Store">
                                            <i class="bi bi-pencil-square"></i>
                                        </button> --}}
                                        {{-- <form action="{{ route('store.delete', $store->id) }}"
                                              method="POST"
                                              class="d-inline delete-store-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete-store"
                                                    title="Delete Store">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form> --}}
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center text-muted py-5">
                    <i class="bi bi-shop fs-1 d-block mb-3"></i>
                    <h5>No stores found</h5>
                    <p class="mb-0">Register your first seller store</p>
                </div>
            @endif
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
    var table = $('#vendorStoreTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        dom: '<"row"<"col-md-6"l><"col-md-6"f>><"row"<"col-md-12"tr>><"row"<"col-md-5"i><"col-md-7"p>>',
        language: {
            search: "🔍 Quick Search:",
            lengthMenu: "Show _MENU_ entries",
            zeroRecords: "No matching stores found",
            info: "Showing _START_ to _END_ of _TOTAL_ stores",
            infoEmpty: "No stores available",
            infoFiltered: "(filtered from _MAX_ total stores)",
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
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                },
                title: 'Seller_Stores_Export_' + new Date().toISOString().slice(0,10)
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="bi bi-file-earmark-pdf me-1"></i>PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                },
                title: 'Seller_Stores_Export_' + new Date().toISOString().slice(0,10),
                customize: function (doc) {
                    doc.content[1].table.widths = ['5%', '15%', '12%', '10%', '10%', '15%', '10%', '8%', '8%', '7%'];
                }
            }
        ],
        initComplete: function() {
            // Add export buttons to the export section
            $('.export-buttons').html($('.dt-buttons'));
        }
    });

    // Filter by Store Name
    $('#searchStoreName').on('keyup', function() {
        table.column(1).search(this.value).draw();
    });

    // Filter by Email
    $('#searchEmail').on('keyup', function() {
        table.column(2).search(this.value).draw();
    });

    // Filter by Phone
    $('#searchPhone').on('keyup', function() {
        table.column(3).search(this.value).draw();
    });

    // Filter by Response Rate
    $('#filterResponseRate').on('change', function() {
        var range = this.value;
        if (range) {
            var [min, max] = range.split('-').map(Number);
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                var rate = parseFloat(data[4]) || 0;
                return rate >= min && rate <= max;
            });
            table.draw();
            $.fn.dataTable.ext.search.pop();
        } else {
            table.column(4).search('').draw();
        }
    });

    // Clear all filters
    $('#clearFilters').on('click', function() {
        $('#searchStoreName').val('');
        $('#searchEmail').val('');
        $('#searchPhone').val('');
        $('#filterResponseRate').val('');

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

    // Delete store confirmation
    $('.btn-delete-store').on('click', function(e) {
        e.preventDefault();
        let form = $(this).closest('.delete-store-form');
        let storeName = $(this).closest('tr').find('.store-name').text();

        Swal.fire({
            title: 'Are you sure?',
            html: `You are about to delete <strong>"${storeName}"</strong>. This action cannot be undone!`,
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

    // Edit store button (placeholder for future functionality)
    $('.edit-store-btn').on('click', function() {
        let storeId = $(this).data('id');
        // Implement edit functionality here
        Swal.fire({
            title: 'Edit Store',
            text: 'Edit functionality will be implemented soon.',
            icon: 'info',
            confirmButtonText: 'OK'
        });
    });

    // Add clickable rows
    $('#vendorStoreTable tbody').on('click', 'tr', function() {
        let viewBtn = $(this).find('.btn-outline-primary');
        if (viewBtn.length) {
            window.location.href = viewBtn.attr('href');
        }
    });

    // Style rows on hover
    $('#vendorStoreTable tbody tr').css('cursor', 'pointer');
});
</script>
@endsection