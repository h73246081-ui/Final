@extends('layouts.app')

@section('head')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
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
            <table id="categoryTable" class="table table-bordered table-striped">
                <thead class="bg-primary text-white">
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
                    @forelse($categories as $category)
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
                                <!-- Edit Button -->
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
                                <!-- Delete Button -->
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
            @include('categories.partials.category_form', ['category' => null])
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
        <div class="modal-header bg-warning text-dark">
          <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            @include('categories.partials.category_form', ['category' => null, 'isEdit' => true])
            <div class="mb-3" id="currentImageDiv" style="display:none;">
                <label class="form-label">Current Image</label><br>
                <img id="currentImage" src="" width="100">
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

    function openEditModal(id, name, description, questionDescription, metaTitle, metaDescription, metaKeyword, imageUrl) {
        $('#editCategoryForm').attr('action', '/admin/category/update/' + id);
        $('#editCategoryForm input[name=name]').val(name);
        $('#editCategoryForm textarea[name=description]').val(description);
        $('#editCategoryForm textarea[name=question_description]').val(questionDescription);
        $('#editCategoryForm input[name=meta_title]').val(metaTitle);
        $('#editCategoryForm textarea[name=meta_description]').val(metaDescription);
        $('#editCategoryForm input[name=meta_keyword]').val(metaKeyword);

        if(imageUrl){
            $('#currentImageDiv').show();
            $('#currentImage').attr('src', imageUrl);
        } else {
            $('#currentImageDiv').hide();
        }

        var editModal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
        editModal.show();
    }

    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this category?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endsection
