{{-- resources/views/testimonials/index.blade.php --}}
@extends('layouts.app')

@section('head')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
            <style>
        /* Force table header to match Add Brand button color */
        #userTable thead th {
            background-color: #0d6efd !important; /* Bootstrap primary */
            color: #fff !important;
        }
    </style>
@endsection

@section('title', 'All About Value')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>All About Value</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addValueModal">Add About Value</button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if($points->count() > 0)
            <div class="table-responsive">
                <table id="userTable" class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Icon</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($points as $point)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $point->title }}</td>
                            <td>{{ $point->description ?? '-' }}</td>
                            <td>{{ $point->icon ?? '.' }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning mb-1" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editValueModal" 
                                        data-id="{{ $point->id }}" 
                                        data-title="{{ $point->title }}" 
                                        data-description="{{ $point->description }}" 
                                        data-icon="{{ $point->icon }}">
                                    Edit
                                </button>

                                <form id="delete-aboutvalue-form-{{ $point->id }}"  
                                      action="{{ route('cms.value.delete', $point->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger mb-1" 
                                            onclick="confirmDeleteAboutValue({{ $point->id }})">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <p class="text-center">No About value found. Add a About value.</p>
            @endif
        </div>
    </div>
</div>

<!-- Add About Value Modal -->
<div class="modal fade" id="addValueModal" tabindex="-1" aria-labelledby="addValueModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('cms.value.save') }}" method="POST">
        @csrf
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="addValueModalLabel">Add About Value</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control"></textarea>
          </div>
          <div class="mb-3">
            <label for="icon" class="form-label">Icon</label>
            <input type="text" name="icon" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit About Value Modal -->
<div class="modal fade" id="editValueModal" tabindex="-1" aria-labelledby="editValueModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editValueForm" method="POST">
        @csrf
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="editValueModalLabel">Edit About Value</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          @method('POST')
          <div class="mb-3">
            <label for="edit_title" class="form-label">Title</label>
            <input type="text" name="title" id="edit_title" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="edit_description" class="form-label">Description</label>
            <textarea name="description" id="edit_description" class="form-control"></textarea>
          </div>
          <div class="mb-3">
            <label for="edit_icon" class="form-label">Icon</label>
            <input type="text" name="icon" id="edit_icon" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Update</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
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
});


$('#editValueModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var title = button.data('title');
    var description = button.data('description');
    var icon = button.data('icon');

    var modal = $(this);
    modal.find('#edit_title').val(title);
    modal.find('#edit_description').val(description);
    modal.find('#edit_icon').val(icon);

    // ✅ Use named route dynamically
    var updateUrl = "{{ route('cms.value.update', ':id') }}";
    updateUrl = updateUrl.replace(':id', id);
    modal.find('#editValueForm').attr('action', updateUrl);
});




</script>
@endsection
