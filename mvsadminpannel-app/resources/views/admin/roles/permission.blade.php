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
    #permissionsTable thead th {
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

    /* Permission styling */
    .permission-name {
        font-weight: 600;
        color: #2c3e50;
    }

    .permission-badge {
        background: linear-gradient(135deg, #20c997 0%, #198754 100%);
        color: white;
        padding: 3px 12px;
        border-radius: 15px;
        font-size: 0.85em;
        font-weight: 500;
        display: inline-block;
    }

    /* Permission type styling */
    .permission-type {
        color: #6c757d;
        font-size: 0.9em;
    }

    /* Role count styling */
    .role-count {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 0.8em;
    }

    /* Date styling */
    .date-cell {
        min-width: 140px;
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

    /* Permission categories */
    .permission-category {
        font-size: 0.8em;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 4px;
    }

    /* Permission format helper */
    .permission-format {
        font-size: 0.8em;
        color: #20c997;
        font-family: monospace;
        margin-top: 2px;
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <!-- Main Card containing everything -->
    <div class="card main-card" style="margin-top: -30px;">
        <!-- Card Header with Title and Add Button -->
        <div class="card-header card-header-custom d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <i class="bi bi-shield-lock text-white fs-3 me-3"></i>
                <h4 class="mb-0 text-white">Permissions Management</h4>
            </div>
            <div class="d-flex align-items-center gap-2">
                {{-- <div class="export-buttons">
                    <button id="exportExcel" class="btn btn-success btn-export me-2">
                        <i class="bi bi-file-earmark-excel me-1"></i>Export Excel
                    </button>
                    <button id="exportPDF" class="btn btn-danger btn-export me-3">
                        <i class="bi bi-file-earmark-pdf me-1"></i>Export PDF
                    </button>
                </div> --}}
                <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addPermissionModal" style="margin-left: 21rem;">
                    <i class="bi bi-plus-circle me-2"></i>Add New Permission
                </button>
            </div>
        </div>

        <!-- Card Body with Filter Section -->
        <div class="card-body">
            <!-- Filter Card -->
            <div class="filter-card mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0 text-primary"><i class="bi bi-funnel me-2"></i>Filter Options</h6>
                    <div class="text-muted">
                        <small><i class="bi bi-key me-1"></i>{{ $permission->count() }} permissions found</small>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Permission Name</label>
                        <input type="text" id="searchPermission" class="form-control filter-input" placeholder="Search permission...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Permission Type</label>
                        <select id="filterType" class="form-control filter-input">
                            <option value="">All Types</option>
                            <option value="create">Create</option>
                            <option value="read">Read</option>
                            <option value="update">Update</option>
                            <option value="delete">Delete</option>
                            <option value="manage">Manage</option>
                            <option value="view">View</option>
                        </select>
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
            @if($permission->count() > 0)
                <div class="table-responsive">
                    <table id="permissionsTable" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>Permission Details</th>
                                <th>Assigned to Roles</th>
                                <th>Created</th>
                                <th width="120" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permission as $index => $item)
                            @php
                                // Extract permission type from name
                                $permissionName = $item->name;
                                $permissionParts = explode('.', $permissionName);
                                $permissionType = count($permissionParts) > 1 ? $permissionParts[1] : 'general';
                                $permissionCategory = count($permissionParts) > 0 ? $permissionParts[0] : 'general';

                                // Get roles count (you may need to add this relationship to your model)
                                $rolesCount = $item->roles ? $item->roles->count() : 0;
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="permission-name">{{ ucfirst(str_replace(['-', '_'], ' ', $item->name)) }}</div>
                                    <div class="permission-type text-capitalize">{{ $permissionType }}</div>
                                    <div class="permission-category">{{ $permissionCategory }}</div>
                                    <div class="permission-format">
                                        <small>{{ $item->name }}</small>
                                    </div>
                                </td>
                                <td>
                                    @if($rolesCount > 0)
                                        <span class="role-count">{{ $rolesCount }} role(s)</span>
                                        <div class="text-muted small mt-1">
                                            @if($item->roles && $item->roles->count() > 0)
                                                @php
                                                    $roleNames = $item->roles->take(3)->pluck('name')->map(function($name) {
                                                        return ucfirst($name);
                                                    })->implode(', ');
                                                @endphp
                                                {{ $roleNames }}
                                                @if($item->roles->count() > 3)
                                                    +{{ $item->roles->count() - 3 }} more
                                                @endif
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted">No roles assigned</span>
                                    @endif
                                </td>
                                <td class="date-cell">
                                    <div class="small">{{ $item->created_at->format('d M, Y') }}</div>
                                    <div class="text-muted">{{ $item->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline-warning edit-permission-btn"
                                                data-id="{{ $item->id }}"
                                                data-name="{{ $item->name }}"
                                                title="Edit Permission">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ route('destroyPermission', $item->id) }}"
                                              method="POST"
                                              class="d-inline delete-permission-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete-permission"
                                                    data-name="{{ $item->name }}"
                                                    data-roles="{{ $rolesCount }}"
                                                    title="Delete Permission">
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
                    <i class="bi bi-shield-lock fs-1 text-muted mb-3"></i>
                    <h5 class="text-muted">No Permissions Found</h5>
                    <p class="text-muted">Create your first permission to manage access control.</p>
                    <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#addPermissionModal">
                        <i class="bi bi-plus-circle me-1"></i>Create First Permission
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Permission Modal -->
<div class="modal fade" id="addPermissionModal" tabindex="-1" aria-hidden="true" style="margin-top: 75px; margin-left: 160px;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="width: 520px;">
            <form action="{{ route('storePermission') }}" method="POST">
                @csrf
                <div class="modal-header modal-header-gradient text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Add New Permission</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">Permission Name *</label>
                            <input type="text" name="name" class="form-control filter-input"
                                   placeholder="e.g., users.create, products.view, orders.delete" required>
                            <small class="text-muted">Use dot notation: model.action (e.g., "products.create", "users.delete")</small>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">Permission Type</label>
                            <select class="form-control filter-input" id="permissionTypeSelect">
                                <option value="">Select a type to auto-generate...</option>
                                <option value="users">Users Management</option>
                                <option value="products">Products Management</option>
                                <option value="orders">Orders Management</option>
                                <option value="categories">Categories Management</option>
                                <option value="settings">Settings Management</option>
                                <option value="reports">Reports Management</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                <small>Common permission actions: create, read, update, delete, view, manage, export, import</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i>Create Permission
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Permission Modal -->
<div class="modal fade" id="editPermissionModal" tabindex="-1" aria-hidden="true" style="margin-top: 75px; margin-left: 160px;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="width: 520px;">
            <form id="editPermissionForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header modal-header-gradient text-white">
                    <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Permission</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">Permission Name *</label>
                            <input type="text" name="name" id="editPermissionName" class="form-control filter-input" required>
                            <small class="text-muted">Current format: <span id="currentFormat"></span></small>
                        </div>
                        <div class="col-md-12">
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <small>Changing permission names may affect existing role assignments. Use caution.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i>Update Permission
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
    var table = $('#permissionsTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        dom: '<"row"<"col-md-6"l><"col-md-6"f>><"row"<"col-md-12"tr>><"row"<"col-md-5"i><"col-md-7"p>>',
        language: {
            search: "🔍 Quick Search:",
            lengthMenu: "Show _MENU_ entries",
            zeroRecords: "No matching permissions found",
            info: "Showing _START_ to _END_ of _TOTAL_ permissions",
            infoEmpty: "No permissions available",
            infoFiltered: "(filtered from _MAX_ total permissions)",
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
                title: 'Permissions_Export_' + new Date().toISOString().slice(0,10)
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="bi bi-file-earmark-pdf me-1"></i>PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                },
                title: 'Permissions_Export_' + new Date().toISOString().slice(0,10),
                customize: function (doc) {
                    doc.content[1].table.widths = ['10%', '35%', '25%', '15%', '15%'];
                }
            }
        ],
        initComplete: function() {
            // Add export buttons to the export section
            $('.export-buttons').html($('.dt-buttons'));
        }
    });

    // Filter by Permission Name
    $('#searchPermission').on('keyup', function() {
        table.column(1).search(this.value).draw();
    });

    // Filter by Permission Type
    $('#filterType').on('change', function() {
        var typeFilter = this.value;
        if (typeFilter) {
            table.column(1).search(typeFilter).draw();
        } else {
            table.column(1).search('').draw();
        }
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
        $('#searchPermission').val('');
        $('#filterType').val('');
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

    // Auto-generate permission suggestions
    $('#permissionTypeSelect').on('change', function() {
        var type = $(this).val();
        if (type) {
            var permissionInput = $('input[name="name"]');
            var currentValue = permissionInput.val();

            if (!currentValue || currentValue === permissionInput.attr('placeholder')) {
                var suggestions = {
                    'users': 'users.',
                    'products': 'products.',
                    'orders': 'orders.',
                    'categories': 'categories.',
                    'settings': 'settings.',
                    'reports': 'reports.'
                };

                if (suggestions[type]) {
                    permissionInput.val(suggestions[type]).focus();

                    // Set cursor position after the suggestion
                    var input = permissionInput[0];
                    var position = suggestions[type].length;
                    input.setSelectionRange(position, position);
                }
            }
        }
    });

    // Edit permission button
    $('.edit-permission-btn').on('click', function() {
        let permissionId = $(this).data('id');
        let permissionName = $(this).data('name');

        // Set form action
        let url = '{{ route("permission.update", ":id") }}';
        url = url.replace(':id', permissionId);
        $('#editPermissionForm').attr('action', url);

        // Fill form fields
        $('#editPermissionName').val(permissionName);
        $('#currentFormat').text(permissionName);

        // Update modal title
        $('#editPermissionModal .modal-title').html('<i class="bi bi-pencil-square me-2"></i>Edit Permission');

        // Show modal
        var editModal = new bootstrap.Modal(document.getElementById('editPermissionModal'));
        editModal.show();
    });

    // Delete permission confirmation
    $('.btn-delete-permission').on('click', function(e) {
        e.preventDefault();
        let form = $(this).closest('.delete-permission-form');
        let permissionName = $(this).data('name');
        let rolesCount = $(this).data('roles');

        let warningMessage = `You are about to delete permission <strong>"${permissionName}"</strong>.`;

        if (rolesCount > 0) {
            warningMessage += `<br><span class="text-danger"><i class="bi bi-exclamation-triangle me-1"></i>Warning: This permission is assigned to ${rolesCount} role(s). Deleting it may affect their access.</span>`;
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
    $('#addPermissionModal').on('shown.bs.modal', function () {
        $(this).find('input[name="name"]').focus();
    });

    $('#editPermissionModal').on('shown.bs.modal', function () {
        $(this).find('input[name="name"]').focus();
    });

    // Parse permission names for better display
    function formatPermissionName(name) {
        return name
            .replace(/\./g, ' ')
            .replace(/-/g, ' ')
            .replace(/_/g, ' ')
            .replace(/\b\w/g, l => l.toUpperCase());
    }

    // Apply formatting to existing permission names in table
    $('.permission-name').each(function() {
        var originalName = $(this).text();
        $(this).text(formatPermissionName(originalName));
    });
});
</script>
@endsection