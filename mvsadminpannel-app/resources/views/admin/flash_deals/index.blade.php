@extends('layouts.app')

@section('head')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
    #flashTable thead th {
        background-color:#0d6efd !important;
        color: #fff !important;
        font-weight: 600;
    }

    /* Button polish */
    .btn-export {
        border-radius: 6px;
        font-weight: 500;
        padding: 8px 16px;
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
        box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.15);
    }

    /* Discount badge */
    .discount-badge {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
        color: white;
        font-weight: bold;
        padding: 4px 12px;
        border-radius: 20px;
        display: inline-block;
    }

    /* Status badges */
    .badge-status-active {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border: 1px solid #28a745;
    }

    .badge-status-inactive {
        background-color: rgba(220, 53, 69, 0.1);
        color:#0d6efd;
        border: 1px solid;
    }

    /* Date styling */
    .date-cell {
        min-width: 150px;
    }

    /* Modal positioning */
    .modal-positioned {
        margin-top: 75px;
        margin-left: 160px;
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <!-- Main Card containing everything -->
    <div class="card main-card" style="margin-top: -30px;">
        <!-- Card Header with Title and Add Button -->
        <div class="card-header card-header-custom bg-primary">
            <div class="row align-items-center">
                <!-- Title on Left -->
                <div class="col-12 col-md-6 mb-3 mb-md-0">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        <i class="bi bi-lightning-charge text-white fs-3 me-3"></i>
                        <h4 class="mb-0 text-white">Flash Deals Management</h4>
                    </div>
                </div>

                <!-- Buttons on Right -->
                <div class="col-12 col-md-6">
                    <div class="d-flex flex-wrap justify-content-center justify-content-md-end align-items-center gap-2">
                        <div class="d-flex gap-2">
                            <button id="exportExcel" class="btn btn-success btn-export">
                                <i class="bi bi-file-earmark-excel me-1"></i>
                                <span class="d-none d-sm-inline">Excel</span>
                            </button>
                            <button id="exportPDF" class="btn btn-danger btn-export">
                                <i class="bi bi-file-earmark-pdf me-1"></i>
                                <span class="d-none d-sm-inline">PDF</span>
                            </button>
                        </div>
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addFlashModal">
                            <i class="bi bi-plus-circle me-1 me-md-2"></i>
                            <span class="d-none d-sm-inline">Add New Deal</span>
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
                <div style="display: flex; justify-content:space-between; margin-top: -6px;">
                    <h6 class="mb-3 text-primary"><i class="bi bi-funnel me-2"></i>Filter Options</h6>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Search Title</label>
                        <input type="text" id="filterTitle" class="form-control filter-input" placeholder="Search by title...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Category</label>
                        <select id="filterCategory" class="form-control">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
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
                        <div>
                            <button id="clearFilters" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-x-circle me-1"></i>Clear Filters
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DataTable -->
            <div class="table-responsive">
                <table id="flashTable" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th width="50">#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Discount</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th width="150" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deals as $index => $deal)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-semibold">{{ $deal->title }}</td>
                            <td data-category-id="{{ $deal->category_id ?? '' }}">
                                {{ $deal->category?->name ?? '-' }}
                            </td>
                            <td>
                                <span class="discount-badge">{{ $deal->discount }}%</span>
                            </td>
                            <td class="date-cell">
                                <div class="small">{{ \Carbon\Carbon::parse($deal->start_at)->format('d M, Y') }}</div>
                                <div class="text-muted">{{ \Carbon\Carbon::parse($deal->start_at)->format('h:i A') }}</div>
                            </td>
                            <td class="date-cell">
                                <div class="small">{{ \Carbon\Carbon::parse($deal->end_at)->format('d M, Y') }}</div>
                                <div class="text-muted">{{ \Carbon\Carbon::parse($deal->end_at)->format('h:i A') }}</div>
                            </td>
                            <td>
                                @if($deal->is_active)
                                    <span class="badge badge-status-active" style="background:#48a734;">Active</span>
                                @else
                                    <span class="badge badge-status-inactive" style="background:#48a734;">Inactive</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group" style="gap: 6px;">
                                    <button class="btn btn-sm btn-outline-warning edit-flash-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editFlashModal"
                                        data-id="{{ $deal->id }}"
                                        data-title="{{ $deal->title }}"
                                        data-description="{{ $deal->description }}"
                                        data-discount="{{ $deal->discount }}"
                                        data-category="{{ $deal->category_id }}"
                                        data-product="{{ $deal->product_id }}"
                                        data-start="{{ \Carbon\Carbon::parse($deal->start_at)->format('Y-m-d\TH:i') }}"
                                        data-end="{{ \Carbon\Carbon::parse($deal->end_at)->format('Y-m-d\TH:i') }}"
                                        data-active="{{ $deal->is_active }}"
                                        title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <form id="delete-flash-form-{{ $deal->id }}"
                                          action="{{ route('flash.destroy', $deal->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                onclick="confirmDeleteFlash({{ $deal->id }})"
                                                title="Delete">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-lightning-charge fs-1 d-block mb-2"></i>
                                No flash deals found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Flash Deal Modal -->
<div class="modal fade" id="addFlashModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="flashForm" action="{{ route('flash.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add Flash Deal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label">Title *</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Discount (%) *</label>
                            <input type="number" name="discount" class="form-control" min="0" max="100" value="0" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-control select-category-add">
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Product</label>
                            <select name="product_id" class="form-control select-product-add">
                                <option value="">-- Select Product --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-category="{{ $product->category_id }}">
                                        {{ $product->name }} ({{ $product->vendor->vendorStore->store_name ?? 'No Vendor' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Start Date & Time *</label>
                            <input type="datetime-local" name="start_at" class="form-control" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">End Date & Time *</label>
                            <input type="datetime-local" name="end_at" class="form-control" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="is_active" value="1" class="form-check-input" checked>
                                <label class="form-check-label">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i>Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Flash Deal Modal -->
<div class="modal fade" id="editFlashModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="editFlashForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Edit Flash Deal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label">Title *</label>
                            <input type="text" name="title" id="editTitle" class="form-control" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Discount (%) *</label>
                            <input type="number" name="discount" id="editDiscount" class="form-control" min="0" max="100" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" id="editCategory" class="form-control select-category-edit">
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Product</label>
                            <select name="product_id" id="editProduct" class="form-control select-product-edit">
                                <option value="">-- Select Product --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-category="{{ $product->category_id }}">
                                        {{ $product->name }} ({{ $product->vendor->vendorStore->store_name ?? 'No Vendor' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Start Date & Time *</label>
                            <input type="datetime-local" name="start_at" id="editStart" class="form-control" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">End Date & Time *</label>
                            <input type="datetime-local" name="end_at" id="editEnd" class="form-control" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="editDescription" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="is_active" id="editIsActive" value="1" class="form-check-input">
                                <label class="form-check-label">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Make modals responsive */
    .modal-content {
        max-width: 520px;
        margin: 0 auto;
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

        select {
            font-size: 0.9rem;
        }

        input[type="datetime-local"] {
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

        textarea {
            min-height: 80px;
        }

        .form-check-label {
            font-size: 0.9rem;
        }

        select {
            font-size: 0.85rem;
        }

        input[type="datetime-local"] {
            font-size: 0.85rem;
        }
    }

    @media (max-width: 576px) {
        .modal-title {
            font-size: 1rem;
        }

        .btn-success i, .btn-secondary i {
            margin-right: 0.25rem !important;
        }

        textarea {
            min-height: 70px;
        }

        select, input[type="datetime-local"] {
            font-size: 0.8rem;
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

        textarea {
            min-height: 60px;
        }

        select, input[type="datetime-local"] {
            font-size: 0.75rem;
        }

        .form-check-label {
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Export Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
$(document).ready(function () {
    // Initialize DataTable with Export Buttons
    var table = $('#flashTable').DataTable({
        responsive: true,
        autoWidth: false,
        dom: '<"row"<"col-md-6"l><"col-md-6"f>><"row"<"col-md-12"tr>><"row"<"col-md-5"i><"col-md-7"p>>',
        language: {
            search: "🔍 Quick Search:",
            lengthMenu: "Show _MENU_ entries",
            zeroRecords: "No matching records found",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "No entries available",
            infoFiltered: "(filtered from _MAX_ total entries)",
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
                title: 'Flash_Deals_Export_' + new Date().toISOString().slice(0,10)
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="bi bi-file-earmark-pdf me-1"></i>PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6]
                },
                title: 'Flash_Deals_Export_' + new Date().toISOString().slice(0,10),
                customize: function (doc) {
                    doc.content[1].table.widths = ['5%', '20%', '15%', '10%', '17%', '17%', '8%', '8%'];
                }
            }
        ],
        initComplete: function() {
            // Add export buttons to the custom export section
            $('.export-buttons').append($('.dt-buttons').html());
            $('.dt-buttons').remove();
        }
    });

    // Initialize Select2 for filters
    $('.select2-filter').select2({
        placeholder: "Select Category",
        allowClear: true,
        width: '100%'
    });

    // Initialize Select2 inside modals
    $('.select-category-add, .select-product-add').select2({
        placeholder: "Search...",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#addFlashModal')
    });

    $('.select-category-edit, .select-product-edit').select2({
        placeholder: "Search...",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#editFlashModal')
    });

    // Clone all products for filtering
    const allProductsAdd = $('#addFlashModal .select-product-add option').clone();
    const allProductsEdit = $('#editFlashModal .select-product-edit option').clone();

    // Filter products based on selected category
    function filterProducts(categorySelect, productSelect, allProducts) {
        const selectedCat = categorySelect.val();
        productSelect.empty().append('<option value="">-- Select Product --</option>');
        allProducts.each(function () {
            if (!selectedCat || $(this).data('category') == selectedCat) {
                productSelect.append($(this).clone());
            }
        });
        productSelect.val(null).trigger('change');
    }

    // Category change handlers
    $('#addFlashModal .select-category-add').on('change', function () {
        filterProducts($(this), $('#addFlashModal .select-product-add'), allProductsAdd);
    });

    $('#editFlashModal .select-category-edit').on('change', function () {
        filterProducts($(this), $('#editFlashModal .select-product-edit'), allProductsEdit);
    });

    // Update URL template
    const updateUrlTemplate = "{{ route('flash.update', ['id' => ':id']) }}";

    // Edit button click handler
    $('.edit-flash-btn').click(function () {
        const btn = $(this);
        const modal = $('#editFlashModal');
        const form = modal.find('#editFlashForm');

        // Update form action
        form.attr('action', updateUrlTemplate.replace(':id', btn.data('id')));

        // Fill form fields
        form.find('#editTitle').val(btn.data('title'));
        form.find('#editDescription').val(btn.data('description'));
        form.find('#editDiscount').val(btn.data('discount'));
        form.find('#editStart').val(btn.data('start'));
        form.find('#editEnd').val(btn.data('end'));
        form.find('#editIsActive').prop('checked', btn.data('active') == 1);

        // Handle category and product selection
        form.find('#editCategory').val(btn.data('category')).trigger('change');

        // Wait for category change to complete, then set product
        setTimeout(() => {
            filterProducts(form.find('#editCategory'), form.find('#editProduct'), allProductsEdit);
            setTimeout(() => {
                form.find('#editProduct').val(btn.data('product')).trigger('change');
            }, 100);
        }, 100);
    });

    // Filter by Title
    $('#filterTitle').on('keyup', function() {
        table.column(1).search(this.value).draw();
    });

// Add custom search for Category (works like Title filter)
$.fn.dataTable.ext.search.push(
    function(settings, data, dataIndex) {
        var selectedCategory = $('#filterCategory').val();
        if (!selectedCategory) return true; // no filter

        // Get row's category ID from data attribute
        var rowCategoryId = $(table.row(dataIndex).node()).find('td').eq(2).data('category-id');
        return rowCategoryId == selectedCategory;
    }
);

// Trigger redraw on category change
$('#filterCategory').on('change', function() {
    table.draw();
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

    // Clear all filters
    $('#clearFilters').on('click', function() {
        $('#filterTitle').val('');
        $('#filterCategory').val('').trigger('change');
        $('#filterStatus').val('');

        table.columns().search('').draw();
    });

    // Export Excel button click
    $('#exportExcel').on('click', function() {
        table.button('.buttons-excel').trigger();
    });

    // Export PDF button click
    $('#exportPDF').on('click', function() {
        table.button('.buttons-pdf').trigger();
    });
});

// Confirm Delete with better UI
function confirmDeleteFlash(id){
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#delete-flash-form-' + id).submit();
        }
    });
}
</script>
@endsection