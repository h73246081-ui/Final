@extends('layouts.app')

@section('head')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="d-flex justify-content-between mb-3">
                <h2 class="text-primary">All Roles</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                    <i class="bi bi-plus-circle"></i> Add New Role
                </button>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-2">
                    <table id="roleTable" class="table table-striped table-hover mb-0">
                        <thead class="table-primary">
                            <tr>
                                <th width="8%">#</th>
                                <th>Role Name</th>
                                <th width="25%">Created At</th>
                                <th width="20%" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roles as $index => $role)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->created_at->format('d M Y, h:i A') }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-success"
                                        onclick="openEditRoleModal({{ $role->id }}, '{{ addslashes($role->name) }}', '{{ addslashes($role->description ?? '') }}')">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <form id="delete-role-form-{{ $role->id }}" 
                                          action="{{ route('role.destroy', $role->id) }}" 
                                          method="POST" 
                                          style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="confirmDeleteRole({{ $role->id }})">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No roles available.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('role.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addRoleModalLabel">Add New Role</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Full width column -->
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Role Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Role Name" required>
                            </div>
                            {{-- <div class="mb-3">
                                <label class="form-label">Description (Optional)</label>
                                <input type="text" name="description" class="form-control" placeholder="Enter Role Description">
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save Role</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Role Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editRoleForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Full width column -->
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Role Name</label>
                                <input type="text" name="name" id="editRoleName" class="form-control" placeholder="Enter Role Name" required>
                            </div>
                            {{-- <div class="mb-3">
                                <label class="form-label">Description (Optional)</label>
                                <input type="text" name="description" id="editRoleDescription" class="form-control" placeholder="Enter Role Description">
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update Role</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- jQuery first -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    $('#roleTable').DataTable({
        responsive: true,
        autoWidth: false,
        language: {
            search: "🔍 Search:",
            lengthMenu: "Show _MENU_ entries",
            zeroRecords: "No matching records found",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            paginate: { previous: "←", next: "→" }
        }
    });
});

// Open Edit Role Modal
function openEditRoleModal(id, name, description){
    let url = '{{ route("roles.update.role", ":id") }}';
    url = url.replace(':id', id);
    $('#editRoleForm').attr('action', url);

    $('#editRoleName').val(name);
    $('#editRoleDescription').val(description);

    var editModal = new bootstrap.Modal(document.getElementById('editRoleModal'));
    editModal.show();
}

// Delete confirmation

</script>
@endsection
