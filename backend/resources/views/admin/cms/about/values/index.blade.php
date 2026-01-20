{{-- resources/views/testimonials/index.blade.php --}}
@extends('layouts.app')

@section('head')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<!-- Buttons for Excel/PDF Export -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
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
    #valuesTable thead th {
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

    /* Icon styling */
    .value-icon {
        font-size: 1.5rem;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
        color: white;
        margin-right: 12px;
    }

    .icon-preview {
        font-size: 2rem;
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
        color: white;
        margin: 0 auto;
        box-shadow: 0 4px 6px rgba(13, 110, 253, 0.2);
    }

    /* Value title styling */
    .value-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 4px;
    }

    .value-description {
        color: #6c757d;
        font-size: 0.9em;
        line-height: 1.5;
        max-height: 60px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
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

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }

    /* Icon grid for selection */
    .icon-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
        margin-top: 10px;
        max-height: 200px;
        overflow-y: auto;
        padding: 10px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        background-color: #f8f9fa;
    }

    .icon-option {
        text-align: center;
        padding: 10px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 1.2rem;
    }

    .icon-option:hover {
        background-color: #e9ecef;
        transform: scale(1.1);
    }

    .icon-option.selected {
        background-color: #0d6efd;
        color: white;
    }

    /* Status styling */
    .status-active {
        color: #28a745;
        font-weight: 500;
    }

    .status-inactive {
        color: #6c757d;
        font-weight: 500;
    }

    /* Text area styling */
    .description-textarea {
        min-height: 100px;
        resize: vertical;
    }

    /* Value card in table */
    .value-card {
        display: flex;
        align-items: center;
    }

    .value-info {
        flex: 1;
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

<style>
    /* Make modals responsive */
    .modal-content {
        max-width: 500px;
        margin: 0 auto;
    }

    .icon-preview {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        min-height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .icon-preview i {
        color: #6c757d;
        font-size: 2rem;
    }

    .description-textarea {
        min-height: 100px;
        resize: vertical;
    }

    /* Responsive modal adjustments */
    @media (max-width: 768px) {
        .modal-dialog {
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

        .icon-preview {
            padding: 0.75rem;
        }

        .icon-preview i {
            font-size: 1.75rem;
        }
    }

    @media (max-width: 576px) {
        .modal-dialog {
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

        small.text-muted {
            font-size: 0.8rem;
        }

        .icon-preview {
            padding: 0.5rem;
            min-height: 45px;
        }

        .icon-preview i {
            font-size: 1.5rem;
        }

        .description-textarea {
            min-height: 80px;
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

        .icon-preview {
            min-height: 40px;
        }

        .icon-preview i {
            font-size: 1.25rem;
        }

        .description-textarea {
            min-height: 70px;
        }
    }
</style>
@endsection

@section('title', 'Core Values Management')

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
                <i class="bi bi-stars text-white fs-3 me-3"></i>
                <h4 class="mb-0 text-white">Core Values Management</h4>
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
                <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addValueModal">
                    <i class="bi bi-plus-circle me-1 me-md-2"></i>
                    <span class="d-none d-sm-inline">Add Core Value</span>
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
                        <small><i class="bi bi-stars me-1"></i>{{ $points->count() }} core values</small>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Title</label>
                        <input type="text" id="searchTitle" class="form-control filter-input" placeholder="Search by title...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Description</label>
                        <input type="text" id="searchDescription" class="form-control filter-input" placeholder="Search in description...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Icon</label>
                        <input type="text" id="searchIcon" class="form-control filter-input" placeholder="Search by icon...">
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
            @if($points->count() > 0)
                <div class="table-responsive">
                    <table id="valuesTable" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th width="80">Icon</th>
                                <th>Core Value Details</th>
                                <th width="300">Description</th>
                                <th width="150" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($points as $index => $point)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="text-center">
                                    @if($point->icon)
                                        <div class="value-icon">
                                            <i class="{{ $point->icon }}"></i>
                                        </div>
                                    @else
                                        <div class="value-icon">
                                            <i class="bi bi-star"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="value-title">{{ $point->title }}</div>
                                    <small class="text-muted">ID: VAL{{ str_pad($point->id, 4, '0', STR_PAD_LEFT) }}</small>
                                </td>
                                <td>
                                    <div class="value-description">
                                        {{ $point->description ? Str::limit($point->description, 150) : 'No description provided' }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline-warning edit-value-btn"
                                                data-id="{{ $point->id }}"
                                                data-title="{{ $point->title }}"
                                                data-description="{{ $point->description }}"
                                                data-icon="{{ $point->icon }}"
                                                title="Edit Core Value">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete-value"
                                                data-id="{{ $point->id }}"
                                                data-title="{{ $point->title }}"
                                                title="Delete Core Value">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-stars fs-1 text-muted mb-3"></i>
                    <h5 class="text-muted">No Core Values Found</h5>
                    <p class="text-muted">Add your first core value to define your company values.</p>
                    <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#addValueModal">
                        <i class="bi bi-plus-circle me-1"></i>Add First Value
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Core Value Modal -->
<div class="modal fade" id="addValueModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('cms.value.save') }}" method="POST" id="addValueForm">
                @csrf
                <div class="modal-header modal-header-gradient text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Add Core Value</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Icon (Optional)</label>
                            <input type="text" name="icon" id="addIcon" class="form-control filter-input"
                                   placeholder="e.g., bi bi-heart" value="bi bi-star">
                            <div class="icon-preview mt-2 text-center" id="addIconPreview">
                                <i class="bi bi-star fs-3"></i>
                            </div>
                            <small class="text-muted">Enter Bootstrap icon class (e.g., bi bi-heart)</small>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Title *</label>
                            <input type="text" name="title" class="form-control filter-input"
                                   placeholder="Enter core value title" required>
                            <small class="text-muted">e.g., "Integrity", "Innovation", "Excellence"</small>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control filter-input description-textarea"
                                      placeholder="Describe this core value..." rows="3"></textarea>
                            <small class="text-muted">Optional detailed description of this value</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i>Save Value
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Core Value Modal -->
<div class="modal fade" id="editValueModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editValueForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header modal-header-gradient text-white">
                    <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Core Value</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Icon (Optional)</label>
                            <input type="text" name="icon" id="editIcon" class="form-control filter-input"
                                   placeholder="e.g., bi bi-heart">
                            <div class="icon-preview mt-2 text-center" id="editIconPreview">
                                <i class="bi bi-star fs-3"></i>
                            </div>
                            <small class="text-muted">Enter Bootstrap icon class (e.g., bi bi-heart)</small>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Title *</label>
                            <input type="text" name="title" id="editTitle" class="form-control filter-input" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" id="editDescription"
                                      class="form-control filter-input description-textarea" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i>Update Value
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

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

<script>
$(document).ready(function () {
    // Initialize DataTable with Export Buttons
    var table = $('#valuesTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        dom: '<"row"<"col-md-6"l><"col-md-6"f>><"row"<"col-md-12"tr>><"row"<"col-md-5"i><"col-md-7"p>>',
        language: {
            search: "🔍 Quick Search:",
            lengthMenu: "Show _MENU_ entries",
            zeroRecords: "No matching core values found",
            info: "Showing _START_ to _END_ of _TOTAL_ values",
            infoEmpty: "No core values available",
            infoFiltered: "(filtered from _MAX_ total values)",
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
                    columns: [0, 2, 3]
                },
                title: 'Core_Values_Export_' + new Date().toISOString().slice(0,10)
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="bi bi-file-earmark-pdf me-1"></i>PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: {
                    columns: [0, 2, 3]
                },
                title: 'Core_Values_Export_' + new Date().toISOString().slice(0,10),
                customize: function (doc) {
                    doc.content[1].table.widths = ['8%', '42%', '40%', '10%'];
                }
            }
        ],
        initComplete: function() {
            // Add export buttons to the export section
            $('.export-buttons').html($('.dt-buttons'));
        }
    });

    // Filter by Title
    $('#searchTitle').on('keyup', function() {
        table.column(2).search(this.value).draw();
    });

    // Filter by Description
    $('#searchDescription').on('keyup', function() {
        table.column(3).search(this.value).draw();
    });

    // Filter by Icon
    $('#searchIcon').on('keyup', function() {
        table.column(1).search(this.value).draw();
    });

    // Clear all filters
    $('#clearFilters').on('click', function() {
        $('#searchTitle').val('');
        $('#searchDescription').val('');
        $('#searchIcon').val('');

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

    // Icon preview for add modal
    $('#addIcon').on('keyup', function() {
        var iconClass = $(this).val();
        if (iconClass) {
            $('#addIconPreview').html('<i class="' + iconClass + '"></i>');
        }
    });

    // Edit value modal
    $('.edit-value-btn').click(function () {
        let id = $(this).data('id');

        // Set form values
        $('#editTitle').val($(this).data('title'));
        $('#editDescription').val($(this).data('description'));

        var icon = $(this).data('icon');
        $('#editIcon').val(icon);
        if (icon) {
            $('#editIconPreview').html('<i class="' + icon + '"></i>');
        } else {
            $('#editIconPreview').html('<i class="bi bi-star"></i>');
        }

        // Set form action with dynamic id
        let url = '{{ route("cms.value.update", ":id") }}';
        url = url.replace(':id', id);
        $('#editValueForm').attr('action', url);

        // Show modal
        var editModal = new bootstrap.Modal(document.getElementById('editValueModal'));
        editModal.show();
    });

    // Icon preview for edit modal
    $('#editIcon').on('keyup', function() {
        var iconClass = $(this).val();
        if (iconClass) {
            $('#editIconPreview').html('<i class="' + iconClass + '"></i>');
        }
    });

    // Delete value confirmation
    $('.btn-delete-value').on('click', function(e) {
        e.preventDefault();
        let valueId = $(this).data('id');
        let valueTitle = $(this).data('title');
        let deleteUrl = "{{ route('cms.value.delete', ':id') }}".replace(':id', valueId);

        Swal.fire({
            title: 'Are you sure?',
            html: `You are about to delete core value <strong>"${valueTitle}"</strong>. This action cannot be undone!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return new Promise((resolve) => {
                    // Create and submit form
                    var form = document.createElement('form');
                    form.method = 'POST';
                    form.action = deleteUrl;
                    form.style.display = 'none';

                    var csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    var methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    form.appendChild(methodField);

                    document.body.appendChild(form);
                    form.submit();
                    resolve();
                });
            }
        });
    });

    // Make rows clickable for better UX
    $('#valuesTable tbody').on('click', 'tr', function(e) {
        // Don't trigger if clicking on action buttons
        if (!$(e.target).closest('.action-buttons').length) {
            $(this).find('.edit-value-btn').click();
        }
    });

    // Style rows on hover
    $('#valuesTable tbody tr').css('cursor', 'pointer');

    // Auto-focus first input in add modal
    $('#addValueModal').on('shown.bs.modal', function () {
        $(this).find('input[name="title"]').focus();
    });

    // Reset form when add modal is closed
    $('#addValueModal').on('hidden.bs.modal', function () {
        $('#addValueForm')[0].reset();
        $('#addIconPreview').html('<i class="bi bi-star"></i>');
    });

    // Reset icon preview when edit modal is closed
    $('#editValueModal').on('hidden.bs.modal', function () {
        $('#editIconPreview').html('<i class="bi bi-star"></i>');
    });
});
</script>
@endsection