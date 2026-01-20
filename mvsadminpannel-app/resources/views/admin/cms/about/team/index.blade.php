{{-- resources/views/teams/index.blade.php --}}
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
    #teamTable thead th {
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

    /* Team member image styling */
    .team-img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #dee2e6;
        transition: transform 0.3s ease;
    }

    .team-img:hover {
        transform: scale(1.1);
    }

    .img-preview-large {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #dee2e6;
    }

    /* Initial badge */
    .initial-badge {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: white;
        font-size: 1.2em;
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
    }

    /* Role badge */
    .role-badge {
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 0.85em;
        font-weight: 500;
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
        border: 1px solid #0d6efd;
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

    /* Member details */
    .member-name {
        font-weight: 600;
        color: #2c3e50;
    }

    .member-initial {
        font-weight: 500;
        color: #6c757d;
        font-size: 0.9em;
    }

    /* Status indicator */
    .status-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-right: 6px;
    }

    .status-active {
        background-color: #28a745;
    }

    .status-inactive {
        background-color: #6c757d;
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
@endsection

@section('title', 'Team Management')

@section('content')
<div class="container mt-4">
    <!-- Main Card containing everything -->
    <div class="card main-card" style="margin-top: -30px;">
        <!-- Card Header with Title and Add Button -->
       <!-- Card Header with Title and Add Button -->
<div class="card-header card-header-custom">
    <div class="row align-items-center">
        <!-- Title on Left -->
        <div class="col-12 col-md-6 mb-3 mb-md-0">
            <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                <i class="bi bi-people-fill text-white fs-3 me-3"></i>
                <h4 class="mb-0 text-white">Team Management</h4>
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
                <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="bi bi-plus-circle me-1 me-md-2"></i>
                    <span class="d-none d-sm-inline">Add Team Member</span>
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
                        <small><i class="bi bi-people me-1"></i>{{ $teams->count() }} members found</small>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Name</label>
                        <input type="text" id="searchName" class="form-control filter-input" placeholder="Search by name...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Role</label>
                        <input type="text" id="searchRole" class="form-control filter-input" placeholder="Search role...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Initial</label>
                        <input type="text" id="searchInitial" class="form-control filter-input" placeholder="Search initial...">
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
            @if($teams->count() > 0)
                <div class="table-responsive">
                    <table id="teamTable" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>Initial</th>
                                <th>Team Member</th>
                                <th>Role</th>
                                <th width="120" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teams as $index => $team)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($team->initial)
                                        <div class="initial-badge">{{ $team->initial }}</div>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($team->image)
                                            <img src="{{ asset($team->image) }}" class="team-img me-3" alt="{{ $team->name }}">
                                        @else
                                            <div class="team-img bg-light d-flex align-items-center justify-content-center me-3">
                                                <i class="bi bi-person text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="member-name">{{ $team->name }}</div>
                                            <small class="text-muted">ID: TM{{ str_pad($team->id, 4, '0', STR_PAD_LEFT) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($team->role)
                                        <span class="role-badge">
                                            <i class="bi bi-briefcase me-1"></i>{{ $team->role }}
                                        </span>
                                    @else
                                        <span class="text-muted">Not specified</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline-warning editBtn"
                                                data-id="{{ $team->id }}"
                                                data-initial="{{ $team->initial }}"
                                                data-name="{{ $team->name }}"
                                                data-role="{{ $team->role }}"
                                                data-image="{{ asset($team->image)  ?? '' }}"
                                                title="Edit Team Member">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete-team"
                                                data-id="{{ $team->id }}"
                                                data-name="{{ $team->name }}"
                                                data-role="{{ $team->role }}"
                                                title="Delete Team Member">
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
                    <i class="bi bi-people fs-1 text-muted mb-3"></i>
                    <h5 class="text-muted">No Team Members Found</h5>
                    <p class="text-muted">Add your first team member to get started.</p>
                    <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="bi bi-plus-circle me-1"></i>Add First Member
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Team Member Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('about.team.store') }}" enctype="multipart/form-data" id="addTeamForm">
                @csrf
                <div class="modal-header modal-header-gradient text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Add Team Member</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Initial</label>
                            <input name="initial" class="form-control filter-input" placeholder="Enter initials (e.g., JD)" maxlength="1">
                            <small class="text-muted">Maximum 3 characters</small>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Full Name *</label>
                            <input name="name" class="form-control filter-input" placeholder="Enter full name" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Role</label>
                            <input name="role" class="form-control filter-input" placeholder="Enter role/position">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Profile Image (Optional)</label>
                            <input type="file" name="image" class="form-control filter-input" accept="image/*" id="addTeamImage">
                            <div class="mt-2 text-center">
                                <img id="addImagePreview" class="img-preview-large d-none" src="#" alt="Image Preview">
                            </div>
                            <small class="text-muted">Recommended: Square image, max 2MB</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i>Save Team Member
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Team Member Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" id="editForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header modal-header-gradient text-white">
                    <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Team Member</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Initial</label>
                            <input name="initial" id="editInitial" class="form-control filter-input" placeholder="Enter initials" maxlength="1">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Full Name *</label>
                            <input name="name" id="editName" class="form-control filter-input" placeholder="Enter full name" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Role</label>
                            <input name="role" id="editRole" class="form-control filter-input" placeholder="Enter role/position">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Profile Image (Optional)</label>
                            <input type="file" name="image" class="form-control filter-input" accept="image/*" id="editTeamImage">
                            <div class="mt-2 text-center">
                                <img id="editImagePreview" class="img-preview-large" src="#" alt="Current Image">
                            </div>
                            <small class="text-muted">Leave empty to keep current image</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i>Update Team Member
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Make modals responsive */
    .modal-content {
        max-width: 500px;
        margin: 0 auto;
    }

    .img-preview-large {
        max-width: 150px;
        max-height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #dee2e6;
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

        .img-preview-large {
            max-width: 120px;
            max-height: 120px;
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

        .img-preview-large {
            max-width: 100px;
            max-height: 100px;
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
    var table = $('#teamTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        dom: '<"row"<"col-md-6"l><"col-md-6"f>><"row"<"col-md-12"tr>><"row"<"col-md-5"i><"col-md-7"p>>',
        language: {
            search: "🔍 Quick Search:",
            lengthMenu: "Show _MENU_ entries",
            zeroRecords: "No matching team members found",
            info: "Showing _START_ to _END_ of _TOTAL_ members",
            infoEmpty: "No team members available",
            infoFiltered: "(filtered from _MAX_ total members)",
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
                title: 'Team_Members_Export_' + new Date().toISOString().slice(0,10)
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="bi bi-file-earmark-pdf me-1"></i>PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                },
                title: 'Team_Members_Export_' + new Date().toISOString().slice(0,10),
                customize: function (doc) {
                    doc.content[1].table.widths = ['8%', '12%', '50%', '20%', '10%'];
                }
            }
        ],
        initComplete: function() {
            // Add export buttons to the export section
            $('.export-buttons').html($('.dt-buttons'));
        }
    });

    // Filter by Name
    $('#searchName').on('keyup', function() {
        table.column(2).search(this.value).draw();
    });

    // Filter by Role
    $('#searchRole').on('keyup', function() {
        table.column(3).search(this.value).draw();
    });

    // Filter by Initial
    $('#searchInitial').on('keyup', function() {
        table.column(1).search(this.value).draw();
    });

    // Clear all filters
    $('#clearFilters').on('click', function() {
        $('#searchName').val('');
        $('#searchRole').val('');
        $('#searchInitial').val('');

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

    // Edit team member
    $('.editBtn').click(function () {
        var id = $(this).data('id');

        // Set form values
        $('#editInitial').val($(this).data('initial'));
        $('#editName').val($(this).data('name'));
        $('#editRole').val($(this).data('role'));

        // Set image preview
        let image = $(this).data('image');
        if(image){
            $('#editImagePreview')
                .attr('src',image)
                .removeClass('d-none');
        } else {
            $('#editImagePreview')
                .attr('src', '#')
                .addClass('d-none');
        }

        // Set form action with dynamic id
        $('#editForm').attr('action', '{{ route("team.update", ":id") }}'.replace(':id', id));

        // Show modal
        var editModal = new bootstrap.Modal(document.getElementById('editModal'));
        editModal.show();
    });

    // Image preview for add modal
    $('#addTeamImage').on('change', function(e) {
        const reader = new FileReader();
        reader.onload = function() {
            $('#addImagePreview')
                .attr('src', reader.result)
                .removeClass('d-none');
        }
        if (e.target.files[0]) {
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // Image preview for edit modal
    $('#editTeamImage').on('change', function(e) {
        const reader = new FileReader();
        reader.onload = function() {
            $('#editImagePreview')
                .attr('src', reader.result)
                .removeClass('d-none');
        }
        if (e.target.files[0]) {
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // Delete team member confirmation
    $('.btn-delete-team').on('click', function(e) {
        e.preventDefault();
        let teamId = $(this).data('id');
        let teamName = $(this).data('name');
        let teamRole = $(this).data('role');
        let deleteUrl = "{{ route('delete.team', ':id') }}".replace(':id', teamId);

        Swal.fire({
            title: 'Are you sure?',
            html: `You are about to delete team member <strong>"${teamName}"</strong> (${teamRole}). This action cannot be undone!`,
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
    $('#teamTable tbody').on('click', 'tr', function(e) {
        // Don't trigger if clicking on action buttons or images
        if (!$(e.target).closest('.action-buttons').length && !$(e.target).is('img')) {
            $(this).find('.editBtn').click();
        }
    });

    // Style rows on hover
    $('#teamTable tbody tr').css('cursor', 'pointer');

    // Auto-focus first input in add modal
    $('#addModal').on('shown.bs.modal', function () {
        $(this).find('input[name="name"]').focus();
    });

    // Clear image preview when add modal is closed
    $('#addModal').on('hidden.bs.modal', function () {
        $('#addImagePreview').addClass('d-none').attr('src', '#');
        $('#addTeamForm')[0].reset();
    });

    // Clear image preview when edit modal is closed
    $('#editModal').on('hidden.bs.modal', function () {
        $('#editTeamImage').val('');
    });
});
</script>
@endsection