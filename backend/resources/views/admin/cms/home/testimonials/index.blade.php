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
    #testimonialsTable thead th {
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

    /* Testimonial styling */
    .testimonial-name {
        font-weight: 600;
        color: #2c3e50;
    }

    .testimonial-badge {
        background: linear-gradient(135deg, #6f42c1 0%, #6610f2 100%);
        color: white;
        padding: 3px 12px;
        border-radius: 15px;
        font-size: 0.85em;
        font-weight: 500;
        display: inline-block;
    }

    /* Image styling */
    .testimonial-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #dee2e6;
        background-color: #f8f9fa;
        padding: 2px;
    }

    /* Rating stars */
    .rating-stars {
        color: #ffc107;
        font-size: 0.9em;
    }

    /* Comments styling */
    .comments-preview {
        max-width: 250px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: pointer;
    }

    .comments-full {
        max-width: none;
        white-space: normal;
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

    /* Date styling */
    .date-cell {
        min-width: 120px;
    }

    /* Profession badge */
    .profession-badge {
        background: #e3f2fd;
        color: #0d6efd;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 0.8em;
        margin-top: 4px;
        display: inline-block;
    }

    /* Location styling */
    .location-text {
        font-size: 0.85em;
        color: #6c757d;
    }

    /* Modal content width */
    .modal-content-testi {
        max-width: 620px;
        margin: 0 auto;
    }

    /* Star rating in modal */
    .rating-option {
        font-size: 1.2em;
        padding: 5px;
    }

    /* Image preview */
    .image-preview-container {
        display: flex;
        justify-content: center;
        margin-top: 10px;
    }
</style>
<style>
    /* Responsive styles for the card header */
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

        .card-header-custom h4 {
            justify-content: center;
        }

        .d-flex.flex-wrap {
            justify-content: center !important;
        }

        .btn {
            flex: 1;
            min-width: 100px;
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
@endsection

@section('title', 'All Testimonials')

@section('content')
<div class="container mt-4">
    <!-- Main Card containing everything -->
    <div class="card main-card" style="margin-top: 0px;">
       <!-- Card Header with Title and Add Button -->
<div class="card-header card-header-custom">
    <div class="row align-items-center">
        <!-- Title on Left -->
        <div class="col-12 col-md-6 mb-3 mb-md-0">
            <div class="d-flex align-items-center">
                <i class="bi bi-chat-square-quote text-white fs-3 me-3"></i>
                <h4 class="mb-0 text-white">Testimonials Management</h4>
            </div>
        </div>

        <!-- Buttons on Right -->
        <div class="col-12 col-md-6">
            <div class="d-flex flex-wrap justify-content-md-end align-items-center gap-2">
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
                <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addTestimonialModal">
                    <i class="bi bi-plus-circle me-2"></i>
                    <span class="d-none d-sm-inline">Add New Testimonial</span>
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
                        <small><i class="bi bi-people me-1"></i>{{ $testimonials->count() }} testimonials found</small>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Name/Profession</label>
                        <input type="text" id="searchTestimonial" class="form-control filter-input" placeholder="Search by name or profession...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Location</label>
                        <input type="text" id="filterLocation" class="form-control filter-input" placeholder="Filter by location...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Rating</label>
                        <select id="filterRating" class="form-control filter-input">
                            <option value="">All Ratings</option>
                            <option value="5">⭐⭐⭐⭐⭐ (5 Stars)</option>
                            <option value="4">⭐⭐⭐⭐ (4 Stars)</option>
                            <option value="3">⭐⭐⭐ (3 Stars)</option>
                            <option value="2">⭐⭐ (2 Stars)</option>
                            <option value="1">⭐ (1 Star)</option>
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
            @if($testimonials->count() > 0)
                <div class="table-responsive">
                    <table id="testimonialsTable" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>Testimonial Details</th>
                                <th>Location & Rating</th>
                                <th>Comments</th>
                                <th>Avatar</th>
                                <th>Created</th>
                                <th width="130" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($testimonials as $index => $testimonial)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="testimonial-name">{{ $testimonial->name }}</div>
                                </td>
                                <td>
                                    @if($testimonial->location)
                                        {{-- <div class="location-text mb-1"> --}}
                                            <i class="bi bi-geo-alt me-1"></i>{{ $testimonial->location }}
                                        {{-- </div> --}}
                                    @endif
                                    <div class="rating-stars">
                                        {{ str_repeat('⭐', $testimonial->rating) }}
                                        <small class="text-muted ms-1">({{ $testimonial->rating }}/5)</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="comments-preview" title="{{ $testimonial->comments }}">
                                        {{ Str::limit($testimonial->comments, 80) }}
                                    </div>
                                </td>
                                <td>
                                    @if($testimonial->avatar)
                                        <img src="{{ asset($testimonial->avatar) }}"
                                             class="testimonial-image"
                                             alt="{{ $testimonial->name }}">
                                    @else
                                        <div class="text-center">
                                            <div class="testimonial-image d-flex align-items-center justify-content-center">
                                                <i class="bi bi-person-circle text-muted fs-4"></i>
                                            </div>
                                            <span class="text-muted small">No avatar</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="date-cell">
                                    <div class="small">{{ $testimonial->created_at->format('d M, Y') }}</div>
                                    <div class="text-muted">{{ $testimonial->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline-warning edit-testimonial-btn"
                                                data-id="{{ $testimonial->id }}"
                                                data-name="{{ $testimonial->name }}"
                                                data-role="{{ $testimonial->role }}"
                                                data-location="{{ $testimonial->location }}"
                                                data-rating="{{ $testimonial->rating }}"
                                                data-comments="{{ $testimonial->comments }}"
                                                data-avatar="{{ $testimonial->avatar ? asset($testimonial->avatar) : '' }}"
                                                title="Edit Testimonial">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ route('delete.testimonial', $testimonial->id) }}"
                                              method="POST"
                                              class="d-inline delete-testimonial-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete-testimonial"
                                                    data-name="{{ $testimonial->name }}"
                                                    title="Delete Testimonial">
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
                    <i class="bi bi-chat-square-quote fs-1 text-muted mb-3"></i>
                    <h5 class="text-muted">No Testimonials Found</h5>
                    <p class="text-muted">Add your first testimonial to get started.</p>
                    <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#addTestimonialModal">
                        <i class="bi bi-plus-circle me-1"></i>Add First Testimonial
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Testimonial Modal -->
<div class="modal fade" id="addTestimonialModal" tabindex="-1" aria-hidden="true" style="">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modal-content-testi">
            <form action="{{ route('cms.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header modal-header-gradient text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Add New Testimonial</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Name *</label>
                            <input type="text" name="name" class="form-control filter-input" placeholder="Enter full name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Profession</label>
                            <input type="text" name="profession" class="form-control filter-input" placeholder="e.g., CEO, Developer, Designer">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Location</label>
                            <input type="text" name="location" class="form-control filter-input" placeholder="e.g., New York, USA">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Rating *</label>
                            <select name="rating" class="form-select filter-input" required>
                                <option value="">Select Rating</option>
                                <option value="5">⭐⭐⭐⭐⭐ (Excellent - 5)</option>
                                <option value="4">⭐⭐⭐⭐ (Very Good - 4)</option>
                                <option value="3">⭐⭐⭐ (Good - 3)</option>
                                <option value="2">⭐⭐ (Fair - 2)</option>
                                <option value="1">⭐ (Poor - 1)</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Comments *</label>
                            <textarea name="comments" class="form-control filter-input" rows="4" placeholder="Enter testimonial comments..." required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Avatar Image</label>
                            <input type="file" name="image" class="form-control filter-input" accept="image/*" id="addAvatarInput">
                            <div class="image-preview-container">
                                <img id="addAvatarPreview" class="rounded-circle mt-2" style="max-width:120px; display:none;">
                            </div>
                            <small class="text-muted">Optional: Upload a profile picture (recommended: 200x200px)</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i>Add Testimonial
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Testimonial Modal -->
<div class="modal fade" id="editTestimonialModal" tabindex="-1" aria-hidden="true" style="">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modal-content-testi">
            <form id="editTestimonialForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header modal-header-gradient text-white">
                    <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Testimonial</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Name *</label>
                            <input type="text" name="name" id="editName" class="form-control filter-input" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Profession</label>
                            <input type="text" name="profession" id="editRole" class="form-control filter-input">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Location</label>
                            <input type="text" name="location" id="editLocation" class="form-control filter-input">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Rating *</label>
                            <select name="rating" id="editRating" class="form-select filter-input" required>
                                <option value="5">⭐⭐⭐⭐⭐ (Excellent - 5)</option>
                                <option value="4">⭐⭐⭐⭐ (Very Good - 4)</option>
                                <option value="3">⭐⭐⭐ (Good - 3)</option>
                                <option value="2">⭐⭐ (Fair - 2)</option>
                                <option value="1">⭐ (Poor - 1)</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Comments *</label>
                            <textarea name="comments" id="editComments" class="form-control filter-input" rows="4" required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Avatar Image</label>
                            <input type="file" name="image" class="form-control filter-input" accept="image/*" id="editAvatarInput">
                            <div class="image-preview-container">
                                <img id="editAvatarPreview" class="rounded-circle mt-2" style="max-width:120px;">
                            </div>
                            <small class="text-muted">Leave empty to keep existing avatar</small>
                        </div>
                        <div class="col-12">
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <small>Uploading a new image will replace the existing avatar.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i>Update Testimonial
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
    var table = $('#testimonialsTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        dom: '<"row"<"col-md-6"l><"col-md-6"f>><"row"<"col-md-12"tr>><"row"<"col-md-5"i><"col-md-7"p>>',
        language: {
            search: "🔍 Quick Search:",
            lengthMenu: "Show _MENU_ entries",
            zeroRecords: "No matching testimonials found",
            info: "Showing _START_ to _END_ of _TOTAL_ testimonials",
            infoEmpty: "No testimonials available",
            infoFiltered: "(filtered from _MAX_ total testimonials)",
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
                    columns: [0, 1, 2, 3, 4, 5]
                },
                title: 'Testimonials_Export_' + new Date().toISOString().slice(0,10)
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="bi bi-file-earmark-pdf me-1"></i>PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                },
                title: 'Testimonials_Export_' + new Date().toISOString().slice(0,10),
                customize: function (doc) {
                    doc.content[1].table.widths = ['8%', '25%', '15%', '20%', '12%', '10%', '10%'];
                }
            }
        ],
        initComplete: function() {
            // Add export buttons to the export section
            $('.export-buttons').html($('.dt-buttons'));
        }
    });

    // Filter by Name/Profession
    $('#searchTestimonial').on('keyup', function() {
        table.column(1).search(this.value).draw();
    });

    // Filter by Location
    $('#filterLocation').on('keyup', function() {
        table.column(2).search(this.value).draw();
    });

    // Filter by Rating
    $('#filterRating').on('change', function() {
        var rating = this.value;
        if (rating) {
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                // Column 2 contains rating information
                var rowRating = data[2].match(/\((\d+)\/5\)/);
                return rowRating && rowRating[1] === rating;
            });
            table.draw();
            $.fn.dataTable.ext.search.pop();
        } else {
            table.draw();
        }
    });

    // Clear all filters
    $('#clearFilters').on('click', function() {
        $('#searchTestimonial').val('');
        $('#filterLocation').val('');
        $('#filterRating').val('');
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

    // Show full comments on click
    $('#testimonialsTable').on('click', '.comments-preview', function() {
        $(this).toggleClass('comments-full');
        if ($(this).hasClass('comments-full')) {
            $(this).css({
                'white-space': 'normal',
                'overflow': 'visible',
                'text-overflow': 'clip'
            });
        } else {
            $(this).css({
                'white-space': 'nowrap',
                'overflow': 'hidden',
                'text-overflow': 'ellipsis'
            });
        }
    });

    // Edit testimonial button
    $('.edit-testimonial-btn').on('click', function() {
        let testimonialId = $(this).data('id');
        let testimonialName = $(this).data('name');
        let role = $(this).data('role');
        let location = $(this).data('location');
        let rating = $(this).data('rating');
        let comments = $(this).data('comments');
        let avatar = $(this).data('avatar');

        // Set form action
        let url = '{{ route("cms.testimonials.update", ":id") }}'.replace(':id', testimonialId);
        $('#editTestimonialForm').attr('action', url);

        // Fill form fields
        $('#editName').val(testimonialName);
        $('#editRole').val(role);
        $('#editLocation').val(location);
        $('#editRating').val(rating);
        $('#editComments').val(comments);

        // Show avatar preview
        if (avatar) {
            $('#editAvatarPreview').attr('src', avatar).show();
        } else {
            $('#editAvatarPreview').attr('src', '{{ asset("assets/images/default-avatar.png") }}').show();
        }

        // Update modal title
        $('#editTestimonialModal .modal-title').html('<i class="bi bi-pencil-square me-2"></i>Edit: ' + testimonialName);

        // Show modal
        var editModal = new bootstrap.Modal(document.getElementById('editTestimonialModal'));
        editModal.show();
    });

    // Delete testimonial confirmation
    $('.btn-delete-testimonial').on('click', function(e) {
        e.preventDefault();
        let form = $(this).closest('.delete-testimonial-form');
        let testimonialName = $(this).data('name');

        Swal.fire({
            title: 'Are you sure?',
            html: `You are about to delete testimonial from <strong>"${testimonialName}"</strong>. This action cannot be undone!`,
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

    // Auto-focus first input in add modal
    $('#addTestimonialModal').on('shown.bs.modal', function () {
        $(this).find('input[name="name"]').focus();
    });

    // Auto-focus first input in edit modal
    $('#editTestimonialModal').on('shown.bs.modal', function () {
        $(this).find('input[name="name"]').focus();
    });

    // Image preview for add modal
    $('#addAvatarInput').on('change', function() {
        var input = this;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#addAvatarPreview').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            $('#addAvatarPreview').hide();
        }
    });

    // Image preview for edit modal
    $('#editAvatarInput').on('change', function() {
        var input = this;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#editAvatarPreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    });

    // Format rating display in table
    $.fn.dataTable.ext.type.order['rating-pre'] = function (d) {
        // Extract rating number from the string (e.g., "⭐⭐⭐⭐⭐ (5/5)" -> 5)
        var match = d.match(/\((\d+)\/5\)/);
        return match ? parseInt(match[1]) : 0;
    };
});
</script>
@endsection