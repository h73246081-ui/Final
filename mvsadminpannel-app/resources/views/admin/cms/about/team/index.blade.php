{{-- resources/views/teams/index.blade.php --}}
@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        #userTable thead th {
            background-color: #0d6efd !important;
            color: #fff !important;
        }
        .img-preview {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
@endsection

@section('title', 'All Team')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>All About Team</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Add Team</button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if($teams->count() > 0)
            <div class="table-responsive">
                <table id="userTable" class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Initial</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teams as $team)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $team->initial ?? 'Na' }}</td>
                            <td>{{ $team->name }}</td>
                            <td>{{ $team->role ?? '-' }}</td>
                            <td>
                                @if($team->image)
                                    <img src="{{ asset('storage/'.$team->image) }}" class="img-preview">
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning editBtn"
                                    data-id="{{ $team->id }}"
                                    data-initial="{{ $team->initial }}"
                                    data-name="{{ $team->name }}"
                                    data-role="{{ $team->role }}"
                                    data-image="{{ $team->image ?? '' }}">
                                    Edit
                                </button>

                                <form id="delete-team-form-{{ $team->id }}"  action="{{ route('delete.team',$team->id) }}" method="POST" class="d-inline" onclick="confirmDeleteTeam({{ $team->id }})">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <p class="text-center">No About Team found. <a href="#" data-bs-toggle="modal" data-bs-target="#addModal">Add a team member</a>.</p>
            @endif
        </div>
    </div>
</div>

{{-- ADD MODAL --}}
<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('about.team.store') }}" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header bg-primary text-white">
                <h5 class="bg-primary text-white">Add Team Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input name="initial" class="form-control mb-2" placeholder="Initial">
                <input name="name" class="form-control mb-2" placeholder="Name" required>
                <input name="role" class="form-control mb-2" placeholder="Role">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Image</label>
                    <input type="file" name="image" class="form-control" onchange="previewAddImage(event)">
                    <img id="addPreview" class="img-preview mt-2" style="display:none;">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

{{-- EDIT MODAL --}}
<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <form method="POST" id="editForm" enctype="multipart/form-data" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header bg-primary text-white">
                <h5 class="mt-2">Edit Team Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input name="initial" id="editInitial" class="form-control mb-2" placeholder="Initial">
                <input name="name" id="editName" class="form-control mb-2" placeholder="Name" required>
                <input name="role" id="editRole" class="form-control mb-2" placeholder="Role">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Image</label>
                    <input type="file" name="image" class="form-control" onchange="previewEditImage(event)">
                    <img id="editPreview" class="img-preview mt-2" style="display:none;">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    $('#userTable').DataTable({
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

    $('.editBtn').click(function () {
    var id = $(this).data('id');
    $('#editInitial').val($(this).data('initial'));
    $('#editName').val($(this).data('name'));
    $('#editRole').val($(this).data('role'));

    let image = $(this).data('image');
    if(image){
        $('#editPreview').attr('src', '/storage/' + image).show();
    } else {
        $('#editPreview').hide();
    }

    // Correct route with dynamic id
    $('#editForm').attr('action', '{{ route("team.update", ":id") }}'.replace(':id', id));
    $('#editModal').modal('show');
});

   
});

// Image preview functions
function previewAddImage(event){
    let reader = new FileReader();
    reader.onload = function(){
        let output = document.getElementById('addPreview');
        output.src = reader.result;
        output.style.display = 'block';
    }
    reader.readAsDataURL(event.target.files[0]);
}

function previewEditImage(event){
    let reader = new FileReader();
    reader.onload = function(){
        let output = document.getElementById('editPreview');
        output.src = reader.result;
        output.style.display = 'block';
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection
