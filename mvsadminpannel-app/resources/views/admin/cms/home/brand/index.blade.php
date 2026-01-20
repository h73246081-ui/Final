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
    #brandsTable thead th {
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

    /* Brand styling */
    .brand-name {
        font-weight: 600;
        color: #2c3e50;
    }

    .brand-badge {
        background: linear-gradient(135deg, #6f42c1 0%, #6610f2 100%);
        color: white;
        padding: 3px 12px;
        border-radius: 15px;
        font-size: 0.85em;
        font-weight: 500;
        display: inline-block;
    }

    /* Image styling */
    .brand-image {
        width: 60px;
        height: 60px;
        object-fit: contain;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        background-color: #f8f9fa;
        padding: 3px;
    }

    .image-bw {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
    }

    .image-color {
        background-color: #fff;
        border: 1px solid #0d6efd;
    }

    /* Image preview container */
    .image-preview-container {
        display: flex;
        gap: 10px;
        margin-top: 5px;
    }

    /* Action buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
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

    /* Image type badge */
    .image-type-badge {
        font-size: 0.75em;
        padding: 2px 6px;
        border-radius: 4px;
        margin-top: 2px;
        display: inline-block;
    }

    .badge-bw {
        background-color: #6c757d;
        color: white;
    }

    .badge-color {
        background-color: #0d6efd;
        color: white;
    }

    /* Date styling */
    .date-cell {
        min-width: 120px;
    }

</style>
<style>
    @media (max-width: 768px) {
        .card-header-custom {
            padding: 1rem !important;
        }

        .btn-export, .btn-light {
            flex: 1;
            min-width: 100px;
        }

        .d-flex.flex-wrap {
            gap: 10px !important;
        }
    }

    @media (max-width: 576px) {
        .card-header-custom .row {
            text-align: center;
        }

        .card-header-custom h4 {
            font-size: 1.25rem;
            justify-content: center;
        }

        .d-flex.flex-wrap {
            justify-content: center !important;
        }

        .btn {
            padding: 0.5rem 0.75rem;
        }
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
                <!-- Left Side - Title -->
                <div class="col-12 col-md-6 mb-3 mb-md-0">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-tag text-white fs-3 me-3"></i>
                        <h4 class="mb-0 text-white">Brands Management</h4>
                    </div>
                </div>

                <!-- Right Side - Buttons -->
                <div class="col-12 col-md-6">
                    <div class="d-flex flex-wrap justify-content-md-end align-items-center gap-2">
                        <button id="exportExcel" class="btn btn-success btn-export">
                            <i class="bi bi-file-earmark-excel me-1"></i>
                            <span class="d-none d-sm-inline">Excel</span>
                        </button>
                        <button id="exportPDF" class="btn btn-danger btn-export">
                            <i class="bi bi-file-earmark-pdf me-1"></i>
                            <span class="d-none d-sm-inline">PDF</span>
                        </button>
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addBrandModal">
                            <i class="bi bi-plus-circle me-2"></i>
                            <span class="d-none d-sm-inline">Add New Brand</span>
                            <span class="d-inline d-sm-none">Add</span>
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
                        <small><i class="bi bi-tags me-1"></i>{{ $brands->count() }} brands found</small>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Brand Name</label>
                        <input type="text" id="searchBrand" class="form-control filter-input" placeholder="Search brand...">
                    </div>
                    {{-- <div class="col-md-6">
                        <label class="form-label fw-semibold">Image Type</label>
                        <select id="filterImageType" class="form-control filter-input">
                            <option value="">All Types</option>
                            <option value="has_bw">Has BW Image</option>
                            <option value="has_color">Has Color Image</option>
                            <option value="has_both">Has Both Images</option>
                            <option value="no_images">No Images</option>
                        </select>
                    </div> --}}
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
            @if($brands->count() > 0)
                <div class="table-responsive">
                    <table id="brandsTable" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>Brand Name</th>
                                <th>Black & White Image</th>
                                <th>Color Image</th>
                                <th>Created</th>
                                <th width="120" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($brands as $index => $brand)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="brand-name">{{ $brand->name }}</div>
                                </td>
                                <td>
                                    @if($brand->image_bw)
                                        <div class="d-flex flex-column align-items-center">
                                            <img src="{{ asset($brand->image_bw) }}"
                                                 class="brand-image image-bw"
                                                 alt="{{ $brand->name }} BW">
                                        </div>
                                    @else
                                        <div class="text-center">
                                            <div class="brand-image image-bw d-flex align-items-center justify-content-center">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                            <span class="text-muted small">No image</span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if($brand->image_color)
                                        <div class="d-flex flex-column align-items-center">
                                            <img src="{{ asset($brand->image_color) }}"
                                                 class="brand-image image-color"
                                                 alt="{{ $brand->name }} Color">
                                        </div>
                                    @else
                                        <div class="text-center">
                                            <div class="brand-image image-color d-flex align-items-center justify-content-center">
                                                <i class="bi bi-palette text-muted"></i>
                                            </div>
                                            <span class="text-muted small">No image</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="date-cell">
                                    <div class="small">{{ $brand->created_at->format('d M, Y') }}</div>
                                    <div class="text-muted">{{ $brand->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline-warning edit-brand-btn"
                                                data-id="{{ $brand->id }}"
                                                data-name="{{ $brand->name }}"
                                                data-bw="{{ $brand->image_bw ? asset($brand->image_bw) : '' }}"
                                                data-color="{{ $brand->image_color ? asset($brand->image_color) : '' }}"
                                                title="Edit Brand">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ route('brands.destroy', $brand->id) }}"
                                              method="POST"
                                              class="d-inline delete-brand-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete-brand"
                                                    data-name="{{ $brand->name }}"
                                                    title="Delete Brand">
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
                    <i class="bi bi-tags fs-1 text-muted mb-3"></i>
                    <h5 class="text-muted">No Brands Found</h5>
                    <p class="text-muted">Create your first brand to get started.</p>
                    <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#addBrandModal">
                        <i class="bi bi-plus-circle me-1"></i>Create First Brand
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
<!-- Add Brand Modal -->
<div class="modal fade" id="addBrandModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header modal-header-gradient text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Add New Brand</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Brand Name *</label>
                            <input type="text" name="name" class="form-control filter-input" placeholder="e.g., Nike, Apple, Samsung" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Black & White Image</label>
                            <input type="file" name="image_bw" class="form-control filter-input" accept="image/*">
                            <small class="text-muted">Optional: Upload logo in black and white format</small>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Color Image</label>
                            <input type="file" name="image_color" class="form-control filter-input" accept="image/*">
                            <small class="text-muted">Optional: Upload logo in color format</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i>Create Brand
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Brand Modal -->
<div class="modal fade" id="editBrandModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="editBrandForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header modal-header-gradient text-white">
                    <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Brand</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Brand Name *</label>
                            <input type="text" name="name" id="editBrandName" class="form-control filter-input" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Black & White Image</label>
                            <input type="file" name="image_bw" class="form-control filter-input" id="editBrandBWInput" accept="image/*">
                            <div class="mt-2" id="editBrandBWPreview"></div>
                            <small class="text-muted">Leave empty to keep existing image</small>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Color Image</label>
                            <input type="file" name="image_color" class="form-control filter-input" id="editBrandColorInput" accept="image/*">
                            <div class="mt-2" id="editBrandColorPreview"></div>
                            <small class="text-muted">Leave empty to keep existing image</small>
                        </div>
                        <div class="col-12">
                            <div class="alert alert-warning p-2 p-md-3">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <small>Uploading new images will replace existing ones.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i>Update Brand
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Remove fixed positioning and make modals responsive */
    .modal-content {
        max-width: 520px; /* Maximum width */
        margin: 0 auto; /* Center the modal */
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
    }

    @media (max-width: 768px) {
        .modal-dialog.modal-lg {
            max-width: 95%;
            margin: 20px auto;
        }

        .modal-header, .modal-body, .modal-footer {
            padding: 1rem !important;
        }

        .modal-title {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 576px) {
        .modal-dialog.modal-lg {
            max-width: 100%;
            margin: 10px;
        }

        .modal-dialog-centered {
            align-items: flex-start;
            min-height: calc(100% - 20px);
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

        small.text-muted {
            font-size: 0.8rem;
        }

        .alert-warning {
            font-size: 0.85rem;
            padding: 0.5rem !important;
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

        .modal-title i {
            margin-right: 0.5rem !important;
        }

        .btn i {
            margin-right: 0.25rem !important;
        }
    }

    /* Ensure modal is visible on all screens */
    .modal.show .modal-dialog {
        transform: none !important;
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
    var table = $('#brandsTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        dom: '<"row"<"col-md-6"l><"col-md-6"f>><"row"<"col-md-12"tr>><"row"<"col-md-5"i><"col-md-7"p>>',
        language: {
            search: "🔍 Quick Search:",
            lengthMenu: "Show _MENU_ entries",
            zeroRecords: "No matching brands found",
            info: "Showing _START_ to _END_ of _TOTAL_ brands",
            infoEmpty: "No brands available",
            infoFiltered: "(filtered from _MAX_ total brands)",
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
                    columns: [0, 1, 2, 3, 4]
                },
                title: 'Brands_Export_' + new Date().toISOString().slice(0,10)
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="bi bi-file-earmark-pdf me-1"></i>PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                },
                title: 'Brands_Export_' + new Date().toISOString().slice(0,10),
                customize: function (doc) {
                    doc.content[1].table.widths = ['8%', '22%', '20%', '20%', '15%', '15%'];
                }
            }
        ],
        initComplete: function() {
            // Add export buttons to the export section
            $('.export-buttons').html($('.dt-buttons'));
        }
    });

    // Filter by Brand Name
    $('#searchBrand').on('keyup', function() {
        table.column(1).search(this.value).draw();
    });

    // Filter by Image Type
    $('#filterImageType').on('change', function() {
        var filterType = this.value;
        if (filterType) {
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                var hasBW = data[2].indexOf('No image') === -1;
                var hasColor = data[3].indexOf('No image') === -1;

                switch(filterType) {
                    case 'has_bw': return hasBW;
                    case 'has_color': return hasColor;
                    case 'has_both': return hasBW && hasColor;
                    case 'no_images': return !hasBW && !hasColor;
                    default: return true;
                }
            });
            table.draw();
            $.fn.dataTable.ext.search.pop();
        } else {
            table.draw();
        }
    });

    // Clear all filters
    $('#clearFilters').on('click', function() {
        $('#searchBrand').val('');
        $('#filterImageType').val('');

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

    // Edit brand button
    $('.edit-brand-btn').on('click', function() {
        let brandId = $(this).data('id');
        let brandName = $(this).data('name');
        let bwImage = $(this).data('bw');
        let colorImage = $(this).data('color');

        // Set form action
        let url = '{{ route("brands.update", ":id") }}';
        url = url.replace(':id', brandId);
        $('#editBrandForm').attr('action', url);

        // Fill form fields
        $('#editBrandName').val(brandName);

        // Show image previews
        if (bwImage) {
            $('#editBrandBWPreview').html(`
                <div class="d-flex align-items-center gap-2">
                    <img src="${bwImage}" width="60" class="brand-image image-bw">
                    <div>
                        <div class="small">Current BW Image</div>
                        <small class="text-muted">Upload new to replace</small>
                    </div>
                </div>
            `);
        } else {
            $('#editBrandBWPreview').html('<span class="text-muted">No BW image uploaded</span>');
        }

        if (colorImage) {
            $('#editBrandColorPreview').html(`
                <div class="d-flex align-items-center gap-2">
                    <img src="${colorImage}" width="60" class="brand-image image-color">
                    <div>
                        <div class="small">Current Color Image</div>
                        <small class="text-muted">Upload new to replace</small>
                    </div>
                </div>
            `);
        } else {
            $('#editBrandColorPreview').html('<span class="text-muted">No color image uploaded</span>');
        }

        // Update modal title
        $('#editBrandModal .modal-title').html('<i class="bi bi-pencil-square me-2"></i>Edit Brand: ' + brandName);

        // Show modal
        var editModal = new bootstrap.Modal(document.getElementById('editBrandModal'));
        editModal.show();
    });

    // Delete brand confirmation
    $('.btn-delete-brand').on('click', function(e) {
        e.preventDefault();
        let form = $(this).closest('.delete-brand-form');
        let brandName = $(this).data('name');

        Swal.fire({
            title: 'Are you sure?',
            html: `You are about to delete brand <strong>"${brandName}"</strong>. This action cannot be undone!`,
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
    $('#addBrandModal').on('shown.bs.modal', function () {
        $(this).find('input[name="name"]').focus();
    });

    $('#editBrandModal').on('shown.bs.modal', function () {
        $(this).find('input[name="name"]').focus();
    });

    // Image preview for add modal
    $('input[name="image_bw"], input[name="image_color"]').on('change', function() {
        var input = this;
        var previewId = $(this).attr('name') === 'image_bw' ? '#editBrandBWPreview' : '#editBrandColorPreview';

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $(previewId).html('<img src="' + e.target.result + '" width="80" class="mt-2">');
            }
            reader.readAsDataURL(input.files[0]);
        }
    });
});
</script>
@endsection