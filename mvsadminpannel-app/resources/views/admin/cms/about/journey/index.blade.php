{{-- resources/views/testimonials/index.blade.php --}}
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
    #journeyTable thead th {
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

    /* Year badge styling */
    .year-badge {
        padding: 6px 15px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9em;
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
        color: white;
        display: inline-block;
        text-align: center;
        min-width: 70px;
    }

    /* Title styling */
    .journey-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 4px;
    }

    .journey-description {
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

    /* Timeline style */
    .timeline-marker {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
        border: 2px solid white;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.2);
        position: relative;
        z-index: 1;
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
        min-height: 120px;
        resize: vertical;
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
    <style>
    /* Make modals responsive */
    .modal-content {
        max-width: 500px;
        margin: 0 auto;
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

        .description-textarea {
            min-height: 70px;
        }
    }

</style>
@endsection

@section('title', 'About Journey Management')

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
                <i class="bi bi-clock-history text-white fs-3 me-3"></i>
                <h4 class="mb-0 text-white">Journey Timeline Management</h4>
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
                <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="bi bi-plus-circle me-1 me-md-2"></i>
                    <span class="d-none d-sm-inline">Add Journey Entry</span>
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
                        <small><i class="bi bi-calendar3 me-1"></i>{{ $abouts->count() }} timeline entries</small>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Title</label>
                        <input type="text" id="searchTitle" class="form-control filter-input" placeholder="Search by title...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Year</label>
                        <input type="text" id="searchYear" class="form-control filter-input" placeholder="Search by year...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Description</label>
                        <input type="text" id="searchDescription" class="form-control filter-input" placeholder="Search in description...">
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
            @if($abouts->count() > 0)
                <div class="table-responsive">
                    <table id="journeyTable" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th width="120">Year</th>
                                <th>Timeline Entry</th>
                                <th>Description</th>
                                <th width="150" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($abouts as $index => $about)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <span class="year-badge">
                                        <i class="bi bi-calendar me-1"></i>{{ $about->year }}
                                    </span>
                                </td>
                                <td>
                                    <div class="journey-title">{{ $about->title }}</div>
                                    <small class="text-muted">ID: JRNY{{ str_pad($about->id, 4, '0', STR_PAD_LEFT) }}</small>
                                </td>
                                <td>
                                    <div class="journey-description">
                                        {{ $about->description ? Str::limit($about->description, 150) : 'No description provided' }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline-warning editBtn"
                                                data-id="{{ $about->id }}"
                                                data-title="{{ $about->title }}"
                                                data-description="{{ $about->description }}"
                                                data-year="{{ $about->year }}"
                                                title="Edit Journey Entry">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete-journey"
                                                data-id="{{ $about->id }}"
                                                data-title="{{ $about->title }}"
                                                data-year="{{ $about->year }}"
                                                title="Delete Journey Entry">
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
                    <i class="bi bi-clock fs-1 text-muted mb-3"></i>
                    <h5 class="text-muted">No Journey Timeline Entries</h5>
                    <p class="text-muted">Add your first journey entry to start building your timeline.</p>
                    <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="bi bi-plus-circle me-1"></i>Add First Entry
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Journey Entry Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('cms.journey.save') }}" id="addJourneyForm">
                @csrf
                <div class="modal-header modal-header-gradient text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Add Journey Entry</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Year *</label>
                            <input name="year" class="form-control filter-input" placeholder="e.g., 2024" required>
                            <small class="text-muted">The year this milestone occurred</small>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Title *</label>
                            <input name="title" class="form-control filter-input" placeholder="Enter milestone title" required>
                            <small class="text-muted">Brief title for this timeline entry</small>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control filter-input description-textarea"
                                      placeholder="Describe this milestone..." rows="3"></textarea>
                            <small class="text-muted">Optional detailed description of this milestone</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i>Save Entry
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Journey Entry Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" id="editForm">
                @csrf
                @method('PUT')
                <div class="modal-header modal-header-gradient text-white">
                    <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Journey Entry</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Year *</label>
                            <input name="year" id="editYear" class="form-control filter-input" placeholder="e.g., 2024" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Title *</label>
                            <input name="title" id="editTitle" class="form-control filter-input" placeholder="Enter milestone title" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" id="editDescription"
                                      class="form-control filter-input description-textarea"
                                      placeholder="Describe this milestone..." rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i>Update Entry
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
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<script>
$(document).ready(function () {
    // Initialize DataTable with Export Buttons
    var table = $('#journeyTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        dom: '<"row"<"col-md-6"l><"col-md-6"f>><"row"<"col-md-12"tr>><"row"<"col-md-5"i><"col-md-7"p>>',
        language: {
            search: "🔍 Quick Search:",
            lengthMenu: "Show _MENU_ entries",
            zeroRecords: "No matching journey entries found",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "No journey entries available",
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
                    columns: [0, 1, 2, 3]
                },
                title: 'Journey_Timeline_Export_' + new Date().toISOString().slice(0,10)
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="bi bi-file-earmark-pdf me-1"></i>PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                },
                title: 'Journey_Timeline_Export_' + new Date().toISOString().slice(0,10),
                customize: function (doc) {
                    doc.content[1].table.widths = ['8%', '12%', '30%', '40%', '10%'];
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

    // Filter by Year
    $('#searchYear').on('keyup', function() {
        table.column(1).search(this.value).draw();
    });

    // Filter by Description
    $('#searchDescription').on('keyup', function() {
        table.column(3).search(this.value).draw();
    });

    // Clear all filters
    $('#clearFilters').on('click', function() {
        $('#searchTitle').val('');
        $('#searchYear').val('');
        $('#searchDescription').val('');

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

    // Edit journey entry
    $('.editBtn').click(function () {
        let id = $(this).data('id');

        // Set form values
        $('#editTitle').val($(this).data('title'));
        $('#editDescription').val($(this).data('description'));
        $('#editYear').val($(this).data('year'));

        // Set form action with dynamic id
        let url = '{{ route("journey.update", ":id") }}';
        url = url.replace(':id', id);
        $('#editForm').attr('action', url);

        // Show modal
        var editModal = new bootstrap.Modal(document.getElementById('editModal'));
        editModal.show();
    });

    // Delete journey entry confirmation
    $('.btn-delete-journey').on('click', function(e) {
        e.preventDefault();
        let journeyId = $(this).data('id');
        let journeyTitle = $(this).data('title');
        let journeyYear = $(this).data('year');
        let deleteUrl = "{{ route('journey.delete', ':id') }}".replace(':id', journeyId);

        Swal.fire({
            title: 'Are you sure?',
            html: `You are about to delete journey entry <strong>"${journeyTitle}"</strong> (${journeyYear}). This action cannot be undone!`,
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
    $('#journeyTable tbody').on('click', 'tr', function(e) {
        // Don't trigger if clicking on action buttons
        if (!$(e.target).closest('.action-buttons').length) {
            $(this).find('.editBtn').click();
        }
    });

    // Style rows on hover
    $('#journeyTable tbody tr').css('cursor', 'pointer');

    // Auto-focus first input in add modal
    $('#addModal').on('shown.bs.modal', function () {
        $(this).find('input[name="year"]').focus();
    });

    // Reset form when add modal is closed
    $('#addModal').on('hidden.bs.modal', function () {
        $('#addJourneyForm')[0].reset();
    });
});
</script>
@endsection