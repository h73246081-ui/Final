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
    #packageTable thead th {
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

    /* Package styling */
    .package-name {
        font-weight: 600;
        color: #2c3e50;
    }

    .package-badge {
        background: linear-gradient(135deg, #6f42c1 0%, #6610f2 100%);
        color: white;
        padding: 3px 12px;
        border-radius: 15px;
        font-size: 0.85em;
        font-weight: 500;
        display: inline-block;
    }

    /* Price styling */
    .package-price {
        font-weight: bold;
        color: #198754;
        font-size: 1.1em;
    }

    /* Status badges */
    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.85em;
        font-weight: 500;
    }

    .status-active {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border: 1px solid #28a745;
    }

    .status-inactive {
        background-color: rgba(108, 117, 125, 0.1);
        color: #6c757d;
        border: 1px solid #6c757d;
    }

    /* Commission styling */
    .commission-badge {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
        color: white;
        padding: 3px 10px;
        border-radius: 15px;
        font-size: 0.85em;
        font-weight: 500;
    }

    /* Action buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    /* Duration styling */
    .duration-cell {
        text-align: center;
    }

    .duration-badge {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
        padding: 3px 10px;
        border-radius: 15px;
        font-size: 0.85em;
        font-weight: 500;
    }

    /* Modal styling */
    .modal-header-gradient {
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
        border-radius: 0;
    }

    /* Responsive table */
    .table-responsive {
        overflow-x: auto;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <!-- Main Card containing everything -->
    <div class="card main-card" style="margin-top: -30px;">
        <!-- Card Header with Title and Add Button -->
<div class="card-header card-header-custom">
    <div class="row align-items-center">
        <!-- Title on Left -->
        <div class="col-12 col-md-6 mb-3 mb-md-0">
            <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                <i class="bi bi-box-seam text-white fs-3 me-3"></i>
                <h4 class="mb-0 text-white">Packages Management</h4>
            </div>
        </div>

        <!-- Buttons on Right -->
        <div class="col-12 col-md-6">
            <div class="d-flex flex-wrap justify-content-center justify-content-md-end align-items-center gap-2">
                <div class="d-flex gap-2">
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
                <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addPackageModal">
                    <i class="bi bi-plus-circle me-1 me-md-2"></i>
                    <span class="d-none d-sm-inline">Add New Package</span>
                    <span class="d-inline d-sm-none">Add</span>
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

        .btn-export, .btn-light {
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
        .d-flex.gap-2 {
            flex-direction: column;
            width: 100%;
        }

        .btn-export, .btn-light {
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
                        <small><i class="bi bi-box me-1"></i>{{ $packages->count() }} packages found</small>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Package Name</label>
                        <input type="text" id="searchPackage" class="form-control filter-input" placeholder="Search package...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Price Range</label>
                        <select id="filterPrice" class="form-control filter-input">
                            <option value="">All Prices</option>
                            <option value="0-100">$0 - $100</option>
                            <option value="101-500">$101 - $500</option>
                            <option value="501-1000">$501 - $1000</option>
                            <option value="1001-5000">$1001 - $5000</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select id="filterStatus" class="form-control filter-input">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Duration</label>
                        <select id="filterDuration" class="form-control filter-input">
                            <option value="">All Durations</option>
                            <option value="0-30">Up to 30 days</option>
                            <option value="31-90">31-90 days</option>
                            <option value="91-365">91-365 days</option>
                            <option value="366-1000">Over 1 year</option>
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
            @if($packages->count() > 0)
                <div class="table-responsive">
                    <table id="packageTable" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>Package</th>
                                <th>Price</th>
                                <th class="text-center">Duration</th>
                                <th class="text-center">Product Limit</th>
                                <th class="text-center">Commission</th>
                                <th>Status</th>
                                <th width="120" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($packages as $index => $package)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="package-name">{{ $package->package_name }}</div>
                                    <small class="text-muted">ID: PKG{{ str_pad($package->id, 4, '0', STR_PAD_LEFT) }}</small>
                                </td>
                                <td>
                                    <div class="package-price">${{ number_format($package->price, 2) }}</div>
                                    <small class="text-muted">One-time payment</small>
                                </td>
                                <td class="duration-cell">
                                    <span class="duration-badge">{{ $package->duration }} days</span>
                                    <div class="text-muted small mt-1">{{ round($package->duration/30, 1) }} months</div>
                                </td>
                                <td class="text-center">
                                    <div class="fw-semibold">{{ $package->product_limit }}</div>
                                    <small class="text-muted">products</small>
                                </td>
                                <td class="text-center">
                                    <span class="commission-badge">{{ $package->commission_percent }}%</span>
                                </td>
                                <td>
                                    <span class="status-badge status-{{ $package->status }}">
                                        {{ ucfirst($package->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline-warning edit-package-btn"
                                                data-id="{{ $package->id }}"
                                                data-name="{{ $package->package_name }}"
                                                title="Edit Package">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ route('packages.delete', $package->id) }}"
                                              method="POST"
                                              class="d-inline delete-package-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete-package"
                                                    data-name="{{ $package->package_name }}"
                                                    data-price="${{ number_format($package->price, 2) }}"
                                                    title="Delete Package">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-box-seam fs-1 text-muted mb-3"></i>
                    <h5 class="text-muted">No Packages Found</h5>
                    <p class="text-muted">Create your first package to get started.</p>
                    <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#addPackageModal">
                        <i class="bi bi-plus-circle me-1"></i>Add First Package
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Package Modal -->
<div class="modal fade" id="addPackageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="{{ route('packages.store') }}" method="POST">
                @csrf
                <div class="modal-header modal-header-gradient text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Add New Package</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Package Name *</label>
                            <input type="text" name="package_name" class="form-control filter-input" placeholder="e.g., Basic Plan" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Price ($) *</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" name="price" class="form-control filter-input" placeholder="0.00" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Duration (Days) *</label>
                            <input type="number" name="duration" class="form-control filter-input" placeholder="e.g., 30" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Product Limit *</label>
                            <input type="number" name="product_limit" class="form-control filter-input" placeholder="e.g., 50" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Commission (%) *</label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="commission_percent" class="form-control filter-input" placeholder="e.g., 10" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-control filter-input">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i>Create Package
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Package Modal -->
<div class="modal fade" id="editPackageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="editPackageForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header modal-header-gradient text-white">
                    <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Package</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Package Name *</label>
                            <input type="text" name="package_name" id="edit_name" class="form-control filter-input" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Price ($) *</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" name="price" id="edit_price" class="form-control filter-input" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Duration (Days) *</label>
                            <input type="number" name="duration" id="edit_duration" class="form-control filter-input" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Product Limit *</label>
                            <input type="number" name="product_limit" id="edit_limit" class="form-control filter-input" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Commission (%) *</label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="commission_percent" id="edit_commission" class="form-control filter-input" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" id="edit_status" class="form-control filter-input">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i>Update Package
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Make modals responsive */
    .modal-content {
        max-width: 700px;
        margin: 0 auto;
    }

    .input-group-text {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }

    /* Responsive modal adjustments */
    @media (max-width: 992px) {
        .modal-dialog.modal-lg {
            max-width: 90%;
            margin: 30px auto;
        }

        .modal-content {
            max-width: 100%;
        }

        .modal-header, .modal-body, .modal-footer {
            padding: 1rem !important;
        }

        .modal-title {
            font-size: 1.1rem;
        }

        .input-group-text {
            padding: 0.375rem 0.75rem;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 768px) {
        .modal-dialog.modal-lg {
            max-width: 95%;
            margin: 20px auto;
        }

        .modal-dialog-centered {
            align-items: flex-start;
            min-height: calc(100% - 40px);
        }

        .modal-content {
            border-radius: 8px;
        }

        .modal-body {
            padding: 0.75rem !important;
        }

        .btn {
            padding: 0.5rem 0.75rem;
            font-size: 0.9rem;
        }

        .form-label {
            font-size: 0.9rem;
            margin-bottom: 0.3rem;
        }

        .form-control {
            padding: 0.5rem 0.75rem;
            font-size: 0.9rem;
        }

        .input-group-text {
            padding: 0.5rem 0.5rem;
            font-size: 0.85rem;
        }

        select {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {
        .modal-title {
            font-size: 1rem;
        }

        .col-md-6 {
            width: 100%;
        }

        .btn-success i, .btn-secondary i {
            margin-right: 0.25rem !important;
        }

        .input-group-text {
            font-size: 0.8rem;
            padding: 0.375rem 0.5rem;
        }
    }

    @media (max-width: 400px) {
        .modal-footer {
            flex-direction: column;
            gap: 10px;
        }

        .modal-footer .btn {
            width: 100%;
            justify-content: center;
        }

        .form-control {
            padding: 0.375rem 0.5rem;
            font-size: 0.85rem;
        }

        .input-group-text {
            font-size: 0.75rem;
            padding: 0.375rem 0.375rem;
        }

        select {
            font-size: 0.85rem;
        }
    }
</style>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<script>
$(document).ready(function () {
    // Initialize DataTable with Export Buttons
    var table = $('#packageTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        dom: '<"row"<"col-md-6"l><"col-md-6"f>><"row"<"col-md-12"tr>><"row"<"col-md-5"i><"col-md-7"p>>',
        language: {
            search: "🔍 Quick Search:",
            lengthMenu: "Show _MENU_ entries",
            zeroRecords: "No matching packages found",
            info: "Showing _START_ to _END_ of _TOTAL_ packages",
            infoEmpty: "No packages available",
            infoFiltered: "(filtered from _MAX_ total packages)",
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
                    columns: [0, 1, 2, 3, 4, 5, 6]
                },
                title: 'Packages_Export_' + new Date().toISOString().slice(0,10)
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="bi bi-file-earmark-pdf me-1"></i>PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6]
                },
                title: 'Packages_Export_' + new Date().toISOString().slice(0,10),
                customize: function (doc) {
                    doc.content[1].table.widths = ['5%', '20%', '15%', '15%', '15%', '15%', '15%'];
                }
            }
        ],
        initComplete: function() {
            // Add export buttons to the export section
            $('.export-buttons').html($('.dt-buttons'));
        }
    });

    // Filter by Package Name
    $('#searchPackage').on('keyup', function() {
        table.column(1).search(this.value).draw();
    });

    // Filter by Price Range
    $('#filterPrice').on('change', function() {
        var range = this.value;
        if (range) {
            var [min, max] = range.split('-').map(Number);
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                var price = parseFloat(data[2].replace(/[^0-9.]/g, '')) || 0;
                return price >= min && price <= max;
            });
            table.draw();
            $.fn.dataTable.ext.search.pop();
        } else {
            table.column(2).search('').draw();
        }
    });

    // Filter by Status
    $('#filterStatus').on('change', function() {
        var statusFilter = this.value;
        if (statusFilter) {
            table.column(6).search(statusFilter, true, false).draw();
        } else {
            table.column(6).search('').draw();
        }
    });

    // Filter by Duration
    $('#filterDuration').on('change', function() {
        var range = this.value;
        if (range) {
            var [min, max] = range.split('-').map(Number);
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                var duration = parseInt(data[3]) || 0;
                return duration >= min && duration <= max;
            });
            table.draw();
            $.fn.dataTable.ext.search.pop();
        } else {
            table.column(3).search('').draw();
        }
    });

    // Clear all filters
    $('#clearFilters').on('click', function() {
        $('#searchPackage').val('');
        $('#filterPrice').val('');
        $('#filterStatus').val('');
        $('#filterDuration').val('');

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

    // Edit package button
    $('.edit-package-btn').on('click', function() {
        let packageId = $(this).data('id');
        let packageName = $(this).data('name');

        $.get('/admin/packages/edit/' + packageId, function (data) {
            let url = '{{ route("packages.update", ":id") }}';
            url = url.replace(':id', packageId);
            $('#editPackageForm').attr('action', url);

            $('#edit_name').val(data.package_name);
            $('#edit_price').val(data.price);
            $('#edit_duration').val(data.duration);
            $('#edit_limit').val(data.product_limit);
            $('#edit_commission').val(data.commission_percent);
            $('#edit_status').val(data.status);

            // Update modal title
            $('#editPackageModal .modal-title').html('<i class="bi bi-pencil-square me-2"></i>Edit Package: ' + packageName);

            // Show modal
            var editModal = new bootstrap.Modal(document.getElementById('editPackageModal'));
            editModal.show();
        }).fail(function() {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to load package data. Please try again.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    });

    // Delete package confirmation
    $('.btn-delete-package').on('click', function(e) {
        e.preventDefault();
        let form = $(this).closest('.delete-package-form');
        let packageName = $(this).data('name');
        let packagePrice = $(this).data('price');

        Swal.fire({
            title: 'Are you sure?',
            html: `You are about to delete package <strong>"${packageName}"</strong> (${packagePrice}). This action cannot be undone!`,
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

    // Auto-focus first input in modals
    $('#addPackageModal').on('shown.bs.modal', function () {
        $(this).find('input[name="package_name"]').focus();
    });

    $('#editPackageModal').on('shown.bs.modal', function () {
        $(this).find('input[name="package_name"]').focus();
    });
});
</script>
@endsection