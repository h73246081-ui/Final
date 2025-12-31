@extends('layouts.app')

@section('head')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <style>
        /* Force table header to match Add Brand button color */
        #categoryTable thead th {
            background-color: #0d6efd !important; /* Bootstrap primary */
            color: #fff !important;
        }
    </style>
@endsection

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h2>All Categories</h2>
        <!-- Button to Open Add Modal -->
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
           Add Category
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="categoryTable" class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Meta Title</th>
                        <th>Created At</th>
                        <th width="180">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories ?? [] as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                @if($category->image)
                                    <img src="{{ asset('storage/'.$category->image) }}" width="60">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>{{ $category->meta_title }}</td>
                            <td>{{ $category->created_at->format('d M Y') }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning"
                                    onclick="openEditModal(
                                        {{ $category->id }},
                                        '{{ addslashes($category->name) }}',
                                        '{{ addslashes($category->description) }}',
                                        '{{ addslashes($category->question_description) }}',
                                        '{{ addslashes($category->meta_title) }}',
                                        '{{ addslashes($category->meta_description) }}',
                                        '{{ addslashes($category->meta_keyword) }}',
                                        '{{ $category->image ? asset('storage/'.$category->image) : '' }}'
                                    )">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form id="delete-form-{{ $category->id }}" 
                                      action="{{ route('category.delete', $category->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $category->id }})">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No Categories Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                        @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Any Question Description</label>
                        <textarea name="question_description" class="form-control" rows="3">{{ old('question_description') }}</textarea>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Keyword</label>
                        <input type="text" name="meta_keyword" class="form-control" value="{{ old('meta_keyword') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save Category</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="editCategoryForm" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="name" id="editCategoryName" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="editCategoryDescription" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Any Question Description</label>
                        <textarea name="question_description" id="editCategoryQuestionDescription" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" id="editCategoryMetaTitle" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" id="editCategoryMetaDescription" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Keyword</label>
                        <input type="text" name="meta_keyword" id="editCategoryMetaKeyword" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category Image</label>
                        <input type="file" name="image" class="form-control" id="editCategoryImageInput">
                        <div class="mt-2" id="editCategoryImagePreview"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Update Category</button>
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

<script>
$(document).ready(function () {
    $('#categoryTable').DataTable({
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

// Open Edit Modal
function openEditModal(id, name, description, questionDescription, metaTitle, metaDescription, metaKeyword, imageUrl = '') {
    let url = '{{ route("category.update", ":id") }}';
    url = url.replace(':id', id);
    $('#editCategoryForm').attr('action', url);

    $('#editCategoryName').val(name);
    $('#editCategoryDescription').val(description);
    $('#editCategoryQuestionDescription').val(questionDescription);
    $('#editCategoryMetaTitle').val(metaTitle);
    $('#editCategoryMetaDescription').val(metaDescription);
    $('#editCategoryMetaKeyword').val(metaKeyword);

    if(imageUrl){
        $('#editCategoryImagePreview').html('<img src="'+imageUrl+'" width="120" class="mt-2">');
    } else {
        $('#editCategoryImagePreview').html('');
    }

    var editModal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
    editModal.show();
}

</script>
@endsection
