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
    #usersTable thead th {
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

    /* User avatar styling */
    .user-avatar {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #dee2e6;
    }

    /* User info styling */
    .user-info {
        display: flex;
        flex-direction: column;
    }

    .user-name {
        font-weight: 600;
        color: #2c3e50;
    }

    .user-email {
        font-size: 0.9em;
        color: #6c757d;
    }

    /* Role badge styling */
    .role-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.85em;
        font-weight: 500;
    }

    .role-admin {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border: 1px solid #dc3545;
    }

    .role-editor {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
        border: 1px solid #0d6efd;
    }

    .role-user {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border: 1px solid #28a745;
    }

    /* Country styling */
    .country-flag {
        display: inline-block;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        margin-right: 6px;
        vertical-align: middle;
    }

    .country-pk {
        background: linear-gradient(135deg, #01411C 50%, white 50%);
    }

    /* Action buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    /* Status styling */
    .status-badge {
        padding: 4px 10px;
        border-radius: 15px;
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

    /* Phone link styling */
    .phone-link {
        text-decoration: none;
        color: #495057;
        transition: color 0.2s;
    }

    .phone-link:hover {
        color: #0d6efd;
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
                <i class="bi bi-people text-white fs-3 me-3"></i>
                <h4 class="mb-0 text-white">Users Management</h4>
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
                <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="bi bi-plus-circle me-1 me-md-2"></i>
                    <span class="d-none d-sm-inline">Add New User</span>
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
                        <small><i class="bi bi-person me-1"></i>{{ $users->count() }} users found</small>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">User Name</label>
                        <input type="text" id="searchName" class="form-control filter-input" placeholder="Search by name...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="text" id="searchEmail" class="form-control filter-input" placeholder="Search email...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Role</label>
                        <select id="filterRole" class="form-control filter-input">
                            <option value="">All Roles</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Country</label>
                        <input type="text" id="searchCountry" class="form-control filter-input" placeholder="Search country...">
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
            @if($users->count() > 0)
                <div class="table-responsive">
                    <table id="usersTable" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>Profile</th>
                                <th>User Details</th>
                                <th>Contact</th>
                                <th>Country</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th width="150" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $index => $user)
                            @php
                                // Determine role class
                                $roleName = $user->role->name ?? 'user';
                                $roleClass = 'role-' . strtolower($roleName);

                                // Determine status (you might have a status field in your model)
                                $status = 'active'; // Default, you can change this based on your data
                                $statusClass = 'status-' . $status;
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($user->image)
                                        <img src="{{ asset($user->image) }}" class="user-avatar" alt="{{ $user->name }}">
                                    @else
                                        <div class="user-avatar bg-primary d-flex align-items-center justify-content-center">
                                            <i class="bi bi-person text-white"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="user-info">
                                        <div class="user-name">{{ $user->name }}</div>
                                        <div class="user-email">{{ $user->email }}</div>
                                        <small class="text-muted">ID: USER{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</small>
                                    </div>
                                </td>
                                <td>
                                    @if($user->phone)
                                        <a href="tel:{{ $user->phone }}" class="phone-link">
                                            <i class="bi bi-telephone me-1"></i>{{ $user->phone }}
                                        </a>
                                    @else
                                        <span class="text-muted">Not provided</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="country-flag country-pk"></div>
                                        <span>{{ $user->country ?? 'Pakistan' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="role-badge {{ $roleClass }}">
                                        {{ ucfirst($roleName) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge {{ $statusClass }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline-primary view-user-btn"
                                                data-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}"
                                                title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <form action="{{ route('user.delete', $user->id) }}"
                                              method="POST"
                                              class="d-inline delete-user-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete-user"
                                                    data-name="{{ $user->name }}"
                                                    data-email="{{ $user->email }}"
                                                    title="Delete User">
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
                    <i class="bi bi-people fs-1 text-muted mb-3"></i>
                    <h5 class="text-muted">No Users Found</h5>
                    <p class="text-muted">Create your first user to get started.</p>
                    <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="bi bi-plus-circle me-1"></i>Create First User
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header modal-header-gradient text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Add New User</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Full Name *</label>
                            <input type="text" name="name" class="form-control filter-input" placeholder="Enter full name" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Email Address *</label>
                            <input type="email" name="email" class="form-control filter-input" placeholder="user@example.com" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <input type="text" name="phone" class="form-control filter-input" placeholder="+92 300 1234567">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Country</label>
                            <input type="text" name="country" class="form-control filter-input" value="Pakistan">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Role *</label>
                            <select name="role_id" class="form-control filter-input" required>
                                <option value="">-- Select Role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Password *</label>
                            <input type="password" name="password" class="form-control filter-input" placeholder="Enter password" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Confirm Password *</label>
                            <input type="password" name="password_confirmation" class="form-control filter-input" placeholder="Confirm password" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Profile Image (Optional)</label>
                            <input type="file" name="image" class="form-control filter-input" accept="image/*">
                        </div>
                        <div class="col-12">
                            <div class="alert alert-info p-2 p-md-3">
                                <i class="bi bi-info-circle me-2"></i>
                                <small>All fields marked with * are required. User will receive email notification.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i>Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View User Modal -->
<div class="modal fade" id="viewUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">User Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="userDetailsContent">
                <!-- Details will be loaded here via AJAX -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
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

        .alert-info {
            font-size: 0.85rem;
            padding: 0.5rem !important;
        }

        select {
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

        select {
            font-size: 0.8rem;
        }

        .spinner-border {
            width: 2rem;
            height: 2rem;
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

        select {
            font-size: 0.75rem;
        }

        .alert-info small {
            font-size: 0.75rem;
        }

        .spinner-border {
            width: 1.5rem;
            height: 1.5rem;
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
    var table = $('#usersTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        dom: '<"row"<"col-md-6"l><"col-md-6"f>><"row"<"col-md-12"tr>><"row"<"col-md-5"i><"col-md-7"p>>',
        language: {
            search: "🔍 Quick Search:",
            lengthMenu: "Show _MENU_ entries",
            zeroRecords: "No matching users found",
            info: "Showing _START_ to _END_ of _TOTAL_ users",
            infoEmpty: "No users available",
            infoFiltered: "(filtered from _MAX_ total users)",
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
                title: 'Users_Export_' + new Date().toISOString().slice(0,10)
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="bi bi-file-earmark-pdf me-1"></i>PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6]
                },
                title: 'Users_Export_' + new Date().toISOString().slice(0,10),
                customize: function (doc) {
                    doc.content[1].table.widths = ['5%', '8%', '22%', '15%', '12%', '12%', '10%', '16%'];
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

    // Filter by Email
    $('#searchEmail').on('keyup', function() {
        table.column(2).search(this.value).draw();
    });

    // Filter by Role
    $('#filterRole').on('change', function() {
        var roleFilter = this.value;
        if (roleFilter) {
            table.column(5).search(roleFilter, true, false).draw();
        } else {
            table.column(5).search('').draw();
        }
    });

    // Filter by Country
    $('#searchCountry').on('keyup', function() {
        table.column(4).search(this.value).draw();
    });

    // Clear all filters
    $('#clearFilters').on('click', function() {
        $('#searchName').val('');
        $('#searchEmail').val('');
        $('#filterRole').val('');
        $('#searchCountry').val('');

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

    // View user details
    $('.view-user-btn').on('click', function() {
        let userId = $(this).data('id');
        let userName = $(this).data('name');

        // Set modal title
        $('#viewUserModal .modal-title').text('User Details: ' + userName);

        // Show modal with loading spinner
        var viewModal = new bootstrap.Modal(document.getElementById('viewUserModal'));
        viewModal.show();

        // Load user details via AJAX (placeholder - you can implement actual AJAX call)
        setTimeout(() => {
            $('#userDetailsContent').html(`
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="bi bi-person me-2"></i>Basic Information</h6>
                        <div class="mb-3">
                            <strong>Full Name:</strong> ${userName}<br>
                            <strong>Email:</strong> user${userId}@example.com<br>
                            <strong>User ID:</strong> USER${String(userId).padStart(5, '0')}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="bi bi-geo-alt me-2"></i>Contact Information</h6>
                        <div class="mb-3">
                            <strong>Phone:</strong> +92 300 1234567<br>
                            <strong>Country:</strong> Pakistan<br>
                            <strong>Joined:</strong> Just now
                        </div>
                    </div>
                </div>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Full user details will be available soon with actual data.
                </div>
            `);
        }, 500);
    });

    // Edit user (placeholder)
    $('.edit-user-btn').on('click', function() {
        let userId = $(this).data('id');

        Swal.fire({
            title: 'Edit User',
            text: 'User edit functionality will be implemented soon.',
            icon: 'info',
            confirmButtonText: 'OK'
        });
    });

    // Delete user confirmation
    $('.btn-delete-user').on('click', function(e) {
        e.preventDefault();
        let form = $(this).closest('.delete-user-form');
        let userName = $(this).data('name');
        let userEmail = $(this).data('email');

        Swal.fire({
            title: 'Are you sure?',
            html: `You are about to delete user <strong>"${userName}"</strong> (${userEmail}). This action cannot be undone!`,
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

    // Make rows clickable for better UX
    $('#usersTable tbody').on('click', 'tr', function(e) {
        // Don't trigger if clicking on action buttons
        if (!$(e.target).closest('.action-buttons').length) {
            $(this).find('.view-user-btn').click();
        }
    });

    // Style rows on hover
    $('#usersTable tbody tr').css('cursor', 'pointer');

    // Auto-focus first input in add modal
    $('#addUserModal').on('shown.bs.modal', function () {
        $(this).find('input[name="name"]').focus();
    });
});
</script>
@endsection