{{-- resources/views/testimonials/index.blade.php --}}
@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
            <style>
        /* Force table header to match Add Brand button color */
        #userTable thead th {
            background-color: #0d6efd !important; /* Bootstrap primary */
            color: #fff !important;
        }
    </style>
@endsection


@section('title', 'All About Journey')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>All About Journey</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Add About Journey</button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if($abouts->count() > 0)
            <div class="table-responsive">
                <table id="userTable" class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Year</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($abouts as $about)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $about->title }}</td>
                            <td>{{ $about->description ?? '-' }}</td>
                            <td>{{ $about->year }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning editBtn"
                                    data-id="{{ $about->id }}"
                                    data-title="{{ $about->title }}"
                                    data-description="{{ $about->description }}"
                                    data-year="{{ $about->year }}">
                                    Edit
                                </button>

                                <form  id="delete-aboutjourney-form-{{ $about->id }}" action="{{ route('journey.delete', $about->id) }}" method="POST" class="d-inline"  onclick="confirmDeleteAboutJourny({{ $about->id }})">
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
                <p class="text-center">No About Journey found. <a href="#" data-bs-toggle="modal" data-bs-target="#addModal">Add a Journey entry</a>.</p>
            @endif
        </div>
    </div>
</div>

{{-- ADD MODAL --}}
<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('cms.journey.save') }}" class="modal-content">
            @csrf
            <div class="modal-header bg-primary text-white">
                <h5>Add About Journey</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input name="title" class="form-control mb-2" placeholder="Title" required>
                <textarea name="description" class="form-control mb-2" placeholder="Description"></textarea>
                <input name="year" class="form-control mb-2" placeholder="Year" required>
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
        <form method="POST" id="editForm" class="modal-content">
            @csrf
            <div class="modal-header bg-primary text-white">
                <h5>Edit About Journey</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input name="title" id="editTitle" class="form-control mb-2" placeholder="Title" required>
                <textarea name="description" id="editDescription" class="form-control mb-2" placeholder="Description"></textarea>
                <input name="year" id="editYear" class="form-control mb-2" placeholder="Year" required>
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

    // Edit button click
   // Edit button click
$('.editBtn').click(function () {
    let id = $(this).data('id');
    $('#editTitle').val($(this).data('title'));
    $('#editDescription').val($(this).data('description'));
    $('#editYear').val($(this).data('year'));

    // Set action dynamically using route placeholder
    let url = '{{ route("journey.update", ":id") }}';
    url = url.replace(':id', id);
    $('#editForm').attr('action', url);

    $('#editModal').modal('show');
});

});
</script>
@endsection
