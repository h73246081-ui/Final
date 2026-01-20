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
    #rolesTable thead th {
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

    /* Role styling */
    .role-name {
        font-weight: 600;
        color: #2c3e50;
    }

    .role-badge {
        background: linear-gradient(135deg, #6f42c1 0%, #6610f2 100%);
        color: white;
        padding: 3px 12px;
        border-radius: 15px;
        font-size: 0.85em;
        font-weight: 500;
        display: inline-block;
    }

    /* Permission styling */
    .permissions-container {
        max-height: 80px;
        overflow-y: auto;
        padding-right: 10px;
    }

    .permission-badge {
        background-color: rgba(32, 201, 151, 0.1);
        color: #20c997;
        border: 1px solid #20c997;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.75em;
        margin: 2px;
        display: inline-block;
    }

    .no-permissions {
        color: #6c757d;
        font-style: italic;
        font-size: 0.9em;
    }

    /* Action buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    /* Date styling */
    .date-cell {
        min-width: 120px;
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

    /* User count */
    .user-count {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 0.8em;
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
        <div class="col-12 col-md-8 mb-3 mb-md-0">
            <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                <i class="bi bi-shield-check text-white fs-3 me-3"></i>
                <h4 class="mb-0 text-white">Roles & Permissions Management</h4>
            </div>
        </div>

        <!-- Button on Right -->
        <div class="col-12 col-md-4">
            <div class="d-flex justify-content-center justify-content-md-end">
                <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                    <i class="bi bi-plus-circle me-1 me-md-2"></i>
                    <span class="d-none d-sm-inline">Add New Role</span>
                    <span class="d-inline d-sm-none">Add Role</span>
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

        .btn-light {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }

        .btn i {
            margin-right: 0.25rem !important;
        }
    }

    @media (max-width: 576px) {
        .card-header-custom .col-md-8,
        .card-header-custom .col-md-4 {
            text-align: center;
        }

        .d-flex.justify-content-center {
            width: 100%;
        }

        .btn-light {
            width: 100%;
            justify-content: center;
        }

        .card-header-custom h4 {
            font-size: 1.1rem;
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
                        <small><i class="bi bi-shield me-1"></i>{{ $roles->count() }} roles found</small>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Role Name</label>
                        <input type="text" id="searchRole" class="form-control filter-input" placeholder="Search role...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Permission</label>
                        <input type="text" id="searchPermission" class="form-control filter-input" placeholder="Search permission...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Date Created</label>
                        <input type="date" id="filterDate" class="form-control filter-input">
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
            @if($roles->count() > 0)
                <div class="table-responsive">
                    <table id="rolesTable" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>Role Details</th>
                                <th>Permissions</th>
                                <th>Created</th>
                                <th width="180" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $index => $role)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="role-name">{{ ucfirst($role->name) }}</div>
                                    <div class="text-muted small mt-1">
                                        <i class="bi bi-people me-1"></i>
                                        <span class="user-count">{{ $role->users_count ?? 0 }} users</span>
                                        @if($role->description)
                                            <div class="mt-1">{{ $role->description }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($role->permissions->count() > 0)
                                        <div class="permissions-container">
                                            @foreach($role->permissions as $permission)
                                                <span class="permission-badge">{{ $permission->name }}</span>
                                            @endforeach
                                        </div>
                                        <small class="text-muted">{{ $role->permissions->count() }} permissions</small>
                                    @else
                                        <span class="no-permissions">No permissions assigned</span>
                                    @endif
                                </td>
                                <td class="date-cell">
                                    <div class="small">{{ $role->created_at->format('d M, Y') }}</div>
                                    <div class="text-muted">{{ $role->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline-warning edit-role-btn"
                                                data-id="{{ $role->id }}"
                                                data-name="{{ $role->name }}"
                                                data-description="{{ $role->description ?? '' }}"
                                                title="Edit Role">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <a href="{{ route('editPermissions', $role->id) }}"
                                           class="btn btn-sm btn-outline-info"
                                           title="Manage Permissions">
                                            <i class="bi bi-shield-lock"></i>
                                        </a>
                                        <form action="{{ route('role.destroy', $role->id) }}"
                                              method="POST"
                                              class="d-inline delete-role-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete-role"
                                                    data-name="{{ $role->name }}"
                                                    data-users="{{ $role->users_count ?? 0 }}"
                                                    title="Delete Role">
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
                    <i class="bi bi-shield fs-1 text-muted mb-3"></i>
                    <h5 class="text-muted">No Roles Found</h5>
                    <p class="text-muted">Create your first role to manage permissions.</p>
                    <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                        <i class="bi bi-plus-circle me-1"></i>Create First Role
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="{{ route('role.store') }}" method="POST">
                @csrf
                <div class="modal-header modal-header-gradient text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Add New Role</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Role Name *</label>
                            <input type="text" name="name" class="form-control filter-input" placeholder="e.g., Admin, Editor, Viewer" required>
                            <small class="text-muted">Use descriptive names for roles (e.g., "Content Manager", "Sales Executive")</small>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Description (Optional)</label>
                            <textarea name="description" class="form-control filter-input" rows="3" placeholder="Brief description of this role..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i>Create Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Role Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="editRoleForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header modal-header-gradient text-white">
                    <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Role</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Role Name *</label>
                            <input type="text" name="name" id="editRoleName" class="form-control filter-input" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Description (Optional)</label>
                            <textarea name="description" id="editRoleDescription" class="form-control filter-input" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i>Update Role
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

        textarea {
            min-height: 80px;
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

        small.text-muted {
            font-size: 0.8rem;
        }

        textarea {
            min-height: 70px;
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
            min-height: 60px;
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
            min-height: 50px;
        }

        small.text-muted {
            font-size: 0.75rem;
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
    var table = $('#rolesTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        dom: '<"row"<"col-md-6"l><"col-md-6"f>><"row"<"col-md-12"tr>><"row"<"col-md-5"i><"col-md-7"p>>',
        language: {
            search: "🔍 Quick Search:",
            lengthMenu: "Show _MENU_ entries",
            zeroRecords: "No matching roles found",
            info: "Showing _START_ to _END_ of _TOTAL_ roles",
            infoEmpty: "No roles available",
            infoFiltered: "(filtered from _MAX_ total roles)",
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
                title: 'Roles_Export_' + new Date().toISOString().slice(0,10)
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="bi bi-file-earmark-pdf me-1"></i>PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                },
                title: 'Roles_Export_' + new Date().toISOString().slice(0,10),
                customize: function (doc) {
                    doc.content[1].table.widths = ['10%', '25%', '35%', '15%', '15%'];
                }
            }
        ],
        initComplete: function() {
            // Add export buttons to the export section
            $('.export-buttons').html($('.dt-buttons'));
        }
    });

    // Filter by Role Name
    $('#searchRole').on('keyup', function() {
        table.column(1).search(this.value).draw();
    });

    // Filter by Permission
    $('#searchPermission').on('keyup', function() {
        table.column(2).search(this.value).draw();
    });

    // Filter by Date
    $('#filterDate').on('change', function() {
        var selectedDate = this.value;
        if (selectedDate) {
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var rowDate = new Date(data[3]).toDateString();
                    var filterDate = new Date(selectedDate).toDateString();
                    return rowDate === filterDate;
                }
            );
            table.draw();
            $.fn.dataTable.ext.search.pop();
        } else {
            table.column(3).search('').draw();
        }
    });

    // Clear all filters
    $('#clearFilters').on('click', function() {
        $('#searchRole').val('');
        $('#searchPermission').val('');
        $('#filterDate').val('');

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

    // Edit role button
    $('.edit-role-btn').on('click', function() {
        let roleId = $(this).data('id');
        let roleName = $(this).data('name');
        let roleDescription = $(this).data('description');

        // Set form action
        let url = '{{ route("roles.update.role", ":id") }}';
        url = url.replace(':id', roleId);
        $('#editRoleForm').attr('action', url);

        // Fill form fields
        $('#editRoleName').val(roleName);
        $('#editRoleDescription').val(roleDescription);

        // Update modal title
        $('#editRoleModal .modal-title').html('<i class="bi bi-pencil-square me-2"></i>Edit Role: ' + roleName);

        // Show modal
        var editModal = new bootstrap.Modal(document.getElementById('editRoleModal'));
        editModal.show();
    });

    // Delete role confirmation
    $('.btn-delete-role').on('click', function(e) {
        e.preventDefault();
        let form = $(this).closest('.delete-role-form');
        let roleName = $(this).data('name');
        let userCount = $(this).data('users');

        let warningMessage = `You are about to delete role <strong>"${roleName}"</strong>.`;

        if (userCount > 0) {
            warningMessage += `<br><span class="text-danger"><i class="bi bi-exclamation-triangle me-1"></i>Warning: This role is assigned to ${userCount} user(s). Deleting it may affect their access.</span>`;
        }

        Swal.fire({
            title: 'Are you sure?',
            html: warningMessage,
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
    $('#addRoleModal').on('shown.bs.modal', function () {
        $(this).find('input[name="name"]').focus();
    });

    $('#editRoleModal').on('shown.bs.modal', function () {
        $(this).find('input[name="name"]').focus();
    });

    // Style permissions container scrollbar
    $('.permissions-container').each(function() {
        $(this).css('max-height', '80px').css('overflow-y', 'auto');
    });
});
</script>
@endsection