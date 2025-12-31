@extends('layouts.app')

@section('head')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<style>
    #blogTable thead th {
        background-color: #0d6efd !important;
        color: #fff !important;
    }
    .img-preview {
        width: 80px;
        height: 80px;
        object-fit: cover;
    }
</style>
@endsection

@section('content')
<div class="container p-4">
    <div class="d-flex justify-content-between mb-3">
        <h2 class="text-primary">All Blogs</h2>
        <button class="btn btn-primary p-3" data-bs-toggle="modal" data-bs-target="#addBlogModal">
            <i class="bi bi-plus-circle"></i> Add New Blog
        </button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="blogTable" class="table table-bordered table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Date</th>
                            <th>Image</th>
                            <th>Description</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($blogs as $index => $blog)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $blog->title }}</td>
                            <td>{{ $blog->author }}</td>
                            <td>{{ \Carbon\Carbon::parse($blog->date)->format('d M, Y') }}</td>
                            <td>
                                @if($blog->image)
                                    <img src="{{ asset('storage/' . $blog->image) }}" class="img-preview img-thumbnail">
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($blog->description, 50) }}</td>
                            <td class="d-flex justify-content-center align-items-center gap-2">
                                <button 
                                    class="btn btn-sm btn-warning edit-blog-btn"
                                    data-id="{{ $blog->id }}"
                                    data-title="{{ $blog->title }}"
                                    data-author="{{ $blog->author }}"
                                    data-date="{{ \Carbon\Carbon::parse($blog->date)->format('Y-m-d') }}"
                                    data-description="{{ $blog->description }}"
                                    data-image="{{ $blog->image ? asset('storage/' . $blog->image) : '' }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editBlogModal"
                                >
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('cms.blog.delete', $blog->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this blog?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No blogs found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Blog Modal -->
<div class="modal fade" id="addBlogModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('cms.blog.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add Blog</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Title *</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Author *</label>
                            <input type="text" name="author" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date *</label>
                            <input type="date" name="date" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event, 'addPreview')">
                            <img id="addPreview" class="img-preview mt-2 d-none" src="#" alt="Image Preview">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add Blog</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Blog Modal -->
<div class="modal fade" id="editBlogModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editBlogForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Edit Blog</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Title *</label>
                            <input type="text" name="title" id="editTitle" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Author *</label>
                            <input type="text" name="author" id="editAuthor" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date *</label>
                            <input type="date" name="date" id="editDate" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event, 'editPreview')">
                            <img id="editPreview" class="img-preview mt-2 d-none" src="#" alt="Image Preview">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="editDescription" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Blog</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
    $('#blogTable').DataTable({
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

    // Fill edit modal
    $('.edit-blog-btn').click(function () {
        const btn = $(this);
        const form = $('#editBlogForm');
        const route = "{{ route('cms.blog.update', ':id') }}".replace(':id', btn.data('id'));
        form.attr('action', route);

        $('#editTitle').val(btn.data('title'));
        $('#editAuthor').val(btn.data('author'));
        $('#editDate').val(btn.data('date'));
        $('#editDescription').val(btn.data('description'));

        if(btn.data('image')){
            $('#editPreview').attr('src', btn.data('image')).removeClass('d-none');
        } else {
            $('#editPreview').addClass('d-none');
        }
    });
});

// Image preview
function previewImage(event, previewId){
    const reader = new FileReader();
    reader.onload = function(){
        const output = document.getElementById(previewId);
        output.src = reader.result;
        output.classList.remove('d-none');
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection
