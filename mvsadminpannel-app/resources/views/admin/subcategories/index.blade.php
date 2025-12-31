@extends('layouts.app')

@section('head')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Table header style */
    #subcategoryTable thead th {
        background-color: #0d6efd !important;
        color: #fff !important;
    }
</style>
@endsection

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h2>All SubCategories</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubcategoryModal">
            Add SubCategory
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="subcategoryTable" class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Created At</th>
                        <th width="180">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subcategories as $sub)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $sub->name }}</td>
                        <td>{{ $sub->category->name ?? '-' }}</td>
                        <td>{{ $sub->created_at->format('d M Y') }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning"
                                onclick="openEditSubModal({{ $sub->id }}, '{{ addslashes($sub->name) }}', '{{ $sub->category_id }}')">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <form id="delete-subcategory-form-{{ $sub->id }}" 
                                  action="{{ route('subcategory.destroy', $sub->id) }}" 
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDeleteSubcategory({{ $sub->id }})">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No SubCategories Found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addSubcategoryModal" tabindex="-1" aria-labelledby="addSubcategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('subcategory.store') }}" method="POST">
        @csrf
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="addSubcategoryModalLabel">Add SubCategory</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">SubCategory Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter SubCategory Name" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Select Category</label>
                    <select name="category_id" class="form-control select-category-add" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editSubcategoryModal" tabindex="-1" aria-labelledby="editSubcategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="editSubcategoryForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="editSubcategoryModalLabel">Edit SubCategory</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">SubCategory Name</label>
                    <input type="text" name="name" id="editSubName" class="form-control" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Select Category</label>
                    <select name="category_id" id="editSubCategory" class="form-control select-category-edit" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Update</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function () {

    // Initialize DataTable
    $('#subcategoryTable').DataTable({
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

    // Initialize Select2 inside Add Modal
    $('.select-category-add').select2({
        placeholder: "Search Category...",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#addSubcategoryModal')
    });

    // Initialize Select2 inside Edit Modal
    $('.select-category-edit').select2({
        placeholder: "Search Category...",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#editSubcategoryModal')
    });

});

// Open Edit Modal
function openEditSubModal(id, name, category_id){
    let url = '{{ route("subcategory.update", ":id") }}';
    url = url.replace(':id', id);
    $('#editSubcategoryForm').attr('action', url);

    $('#editSubName').val(name);
    $('#editSubCategory').val(category_id).trigger('change');

    new bootstrap.Modal(document.getElementById('editSubcategoryModal')).show();
}

// Confirm Delete
function confirmDeleteSubcategory(id){
    if(confirm('Are you sure you want to delete this subcategory?')){
        $('#delete-subcategory-form-' + id).submit();
    }
}
</script>
@endsection
