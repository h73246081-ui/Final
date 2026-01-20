@extends('layouts.app')

@section('head')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<!-- Buttons for Excel/PDF Export -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<!-- CKEditor CSS -->
<link href="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.css" rel="stylesheet">
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
    #blogTable thead th {
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

    /* Blog image styling */
    .blog-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
        border: 2px solid #dee2e6;
        transition: transform 0.3s ease;
    }

    .blog-img:hover {
        transform: scale(1.1);
    }

    .img-preview-large {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #dee2e6;
    }

    /* Description column styling */
    .description-col {
        max-width: 300px;
        word-wrap: break-word;
        line-height: 1.5;
    }

    /* Author badge */
    .author-badge {
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 0.85em;
        font-weight: 500;
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
        border: 1px solid #0d6efd;
    }

    /* Date styling */
    .date-badge {
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 0.85em;
        background-color: rgba(108, 117, 125, 0.1);
        color: #6c757d;
        border: 1px solid #6c757d;
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

    .status-published {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border: 1px solid #28a745;
    }

    .status-draft {
        background-color: rgba(255, 193, 7, 0.1);
        color: #856404;
        border: 1px solid #ffc107;
    }

    /* Modal styling */
    .modal-header-gradient {
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
        border-radius: 0;
    }

    /* CKEditor styling */
    .ck-editor__editable {
        min-height: 200px;
        max-height: 400px;
        overflow-y: auto;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }

    /* Blog title styling */
    .blog-title {
        font-weight: 600;
        color: #2c3e50;
        transition: color 0.2s;
    }

    .blog-title:hover {
        color: #0d6efd;
    }

    /* Author image preview */
    .author-img-preview {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #dee2e6;
        margin: 5px auto;
    }

    /* Author image upload area */
    .author-upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background-color: #f8f9fa;
        margin-bottom: 10px;
    }

    .author-upload-area:hover {
        border-color: #0d6efd;
        background-color: #f0f8ff;
    }

    /* Image preview container */
    .img-preview-container {
        text-align: center;
        margin-top: 10px;
    }
</style>
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

<style>
    /* Make modals responsive */
    .modal-content {
        max-width: 700px;
        margin: 0 auto;
    }

    .author-upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        background-color: #f8f9fa;
    }

    .author-upload-area:hover {
        border-color: #6c757d;
        background-color: #e9ecef;
    }

    .author-img-preview {
        max-width: 150px;
        max-height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #dee2e6;
        margin: 0 auto;
        display: block;
    }

    .img-preview-large {
        max-width: 200px;
        max-height: 200px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid #dee2e6;
    }

    .img-preview-container {
        text-align: center;
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

        .author-upload-area {
            padding: 1rem;
        }

        .author-img-preview {
            max-width: 120px;
            max-height: 120px;
        }

        .img-preview-large {
            max-width: 180px;
            max-height: 180px;
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

        small.text-muted {
            font-size: 0.8rem;
        }

        textarea {
            min-height: 150px;
        }

        .author-upload-area {
            padding: 0.75rem;
        }

        .author-upload-area i {
            font-size: 1.75rem !important;
        }

        .author-img-preview {
            max-width: 100px;
            max-height: 100px;
        }

        .img-preview-large {
            max-width: 150px;
            max-height: 150px;
        }
    }

    @media (max-width: 576px) {
        .col-md-6 {
            width: 100%;
        }

        .author-upload-area {
            padding: 0.5rem;
        }

        .author-upload-area i {
            font-size: 1.5rem !important;
        }

        .author-img-preview {
            max-width: 80px;
            max-height: 80px;
        }

        .img-preview-large {
            max-width: 120px;
            max-height: 120px;
        }

        textarea {
            min-height: 120px;
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

        .modal-title i {
            margin-right: 0.5rem !important;
        }

        .btn i {
            margin-right: 0.25rem !important;
        }

        .author-upload-area {
            padding: 0.5rem;
        }

        .author-upload-area p {
            font-size: 0.8rem;
        }

        .author-upload-area small {
            font-size: 0.7rem;
        }

        .author-img-preview {
            max-width: 70px;
            max-height: 70px;
        }

        .img-preview-large {
            max-width: 100px;
            max-height: 100px;
        }
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
                <i class="bi bi-journal-text text-white fs-3 me-3"></i>
                <h4 class="mb-0 text-white">Blog Management</h4>
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
                <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addBlogModal">
                    <i class="bi bi-plus-circle me-1 me-md-2"></i>
                    <span class="d-none d-sm-inline">Add New Blog</span>
                    <span class="d-inline d-sm-none">Add Blog</span>
                </button>
            </div>
        </div>
    </div>
</div>


        <!-- Card Body with Filter Section -->
        <div class="card-body">
            <!-- Filter Card -->
            <div class="filter-card mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0 text-primary"><i class="bi bi-funnel me-2"></i>Filter Options</h6>
                    <div class="text-muted">
                        <small><i class="bi bi-journal me-1"></i>{{ $blogs->count() }} blogs found</small>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Blog Title</label>
                        <input type="text" id="searchTitle" class="form-control filter-input" placeholder="Search by title...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Author</label>
                        <input type="text" id="searchAuthor" class="form-control filter-input" placeholder="Search author...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">From Date</label>
                        <input type="date" id="filterStartDate" class="form-control filter-input">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">To Date</label>
                        <input type="date" id="filterEndDate" class="form-control filter-input">
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
            @if($blogs->count() > 0)
                <div class="table-responsive">
                    <table id="blogTable" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>Image</th>
                                <th>Blog Details</th>
                                <th width="130">Author</th>
                                <th width="106">Date</th>
                                <th>Description</th>
                                <th width="150" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($blogs as $index => $blog)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($blog->image)
                                        <img src="{{ asset($blog->image) }}" class="blog-img" alt="{{ $blog->title }}" title="Click to view">
                                    @else
                                        <div class="blog-img bg-light d-flex align-items-center justify-content-center">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="blog-title">{{ $blog->title }}</div>
                                    <small class="text-muted">ID: BLOG{{ str_pad($blog->id, 5, '0', STR_PAD_LEFT) }}</small>
                                </td>
                                <td>
                                    <span class="author-badge">
                                        @if($blog->author_image)
                                            <img src="{{ asset($blog->author_image) }}" alt="{{ $blog->author }}" style="width: 20px; height: 20px; border-radius: 50%; margin-right: 5px;">
                                        @else
                                            <i class="bi bi-person me-1"></i>
                                        @endif
                                        {{ $blog->author }}
                                    </span>
                                </td>
                                <td>
                                    <span class="date-badge">
                                        <i class="bi bi-calendar me-1"></i>{{ \Carbon\Carbon::parse($blog->date)->format('d M, Y') }}
                                    </span>
                                </td>
                                <td class="description-col">
                                    {{ Str::limit(strip_tags($blog->description), 100) }}
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline-warning edit-blog-btn"
                                                data-id="{{ $blog->id }}"
                                                data-title="{{ $blog->title }}"
                                                data-author="{{ $blog->author }}"
                                                data-date="{{ \Carbon\Carbon::parse($blog->date)->format('Y-m-d') }}"
                                                data-description="{{ $blog->description }}"
                                                data-image="{{ $blog->image ? asset($blog->image) : '' }}"
                                                data-author_image="{{ $blog->author_image ? asset($blog->author_image) : '' }}"
                                                title="Edit Blog">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete-blog"
                                                data-id="{{ $blog->id }}"
                                                data-title="{{ $blog->title }}"
                                                data-author="{{ $blog->author }}"
                                                title="Delete Blog">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-journal-x fs-1 text-muted mb-3"></i>
                    <h5 class="text-muted">No Blogs Found</h5>
                    <p class="text-muted">Create your first blog to get started.</p>
                    <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#addBlogModal">
                        <i class="bi bi-plus-circle me-1"></i>Create First Blog
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Blog Modal -->
<div class="modal fade" id="addBlogModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="{{ route('cms.blog.store') }}" method="POST" enctype="multipart/form-data" id="addBlogForm">
                @csrf
                <div class="modal-header modal-header-gradient text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Add New Blog</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Blog Title *</label>
                            <input type="text" name="title" class="form-control filter-input" placeholder="Enter blog title" required>
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label fw-semibold">Author Name *</label>
                            <input type="text" name="author" class="form-control filter-input" placeholder="Enter author name" required>
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label fw-semibold">Author Image (Optional)</label>
                            <div class="author-upload-area text-center" onclick="document.getElementById('addAuthorImage').click()">
                                <i class="bi bi-person-circle fs-1 text-muted"></i>
                                <p class="mt-2 mb-0 text-muted">Click to upload author image</p>
                                <small class="text-muted">Recommended: 200x200px</small>
                            </div>
                            <input type="file" name="author_image" class="form-control d-none filter-input" accept="image/*" id="addAuthorImage">
                            <div class="img-preview-container mt-2">
                                <img id="addAuthorImagePreview" class="author-img-preview d-none" src="#" alt="Author Image Preview">
                            </div>
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label fw-semibold">Publish Date *</label>
                            <input type="date" name="date" class="form-control filter-input" required>
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label fw-semibold">Blog Image (Optional)</label>
                            <input type="file" name="image" class="form-control filter-input" accept="image/*" id="addBlogImage">
                            <div class="mt-2 text-center">
                                <img id="addImagePreview" class="img-preview-large d-none" src="#" alt="Blog Image Preview">
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Description *</label>
                            <textarea name="description" class="form-control filter-input" id="addDescription" rows="5" placeholder="Enter blog description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i>Create Blog
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Blog Modal -->
<div class="modal fade" id="editBlogModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="editBlogForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header modal-header-gradient text-white">
                    <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Blog</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Blog Title *</label>
                            <input type="text" name="title" id="editTitle" class="form-control filter-input" required>
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label fw-semibold">Author Name *</label>
                            <input type="text" name="author" id="editAuthor" class="form-control filter-input" required>
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label fw-semibold">Author Image (Optional)</label>
                            <input type="hidden" name="current_author_image" id="currentAuthorImage">
                            <div class="author-upload-area text-center" onclick="document.getElementById('editAuthorImage').click()">
                                <i class="bi bi-person-circle fs-1 text-muted"></i>
                                <p class="mt-2 mb-0 text-muted">Click to change author image</p>
                                <small class="text-muted">Leave empty to keep current image</small>
                            </div>
                            <input type="file" name="author_image" class="form-control d-none filter-input" accept="image/*" id="editAuthorImage">
                            <div class="img-preview-container mt-2">
                                <img id="editAuthorImagePreview" class="author-img-preview" src="#" alt="Current Author Image">
                            </div>
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label fw-semibold">Publish Date *</label>
                            <input type="date" name="date" id="editDate" class="form-control filter-input" required>
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label fw-semibold">Blog Image (Optional)</label>
                            <input type="file" name="image" class="form-control filter-input" accept="image/*" id="editBlogImage">
                            <div class="mt-2 text-center">
                                <img id="editImagePreview" class="img-preview-large" src="#" alt="Current Blog Image">
                            </div>
                            <small class="text-muted">Leave empty to keep current image</small>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Description *</label>
                            <textarea name="description" id="editDescription" class="form-control filter-input" rows="5"></textarea>
                        </div>

                        <div class="col-12">
                            <div class="alert alert-info p-2 p-md-3">
                                <i class="bi bi-info-circle me-2"></i>
                                <small>All fields marked with * are required. Maximum image size: 2MB each.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i>Update Blog
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
<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<script>
let addEditor, editEditor;

$(document).ready(function () {
    // Initialize CKEditor for Add modal
    ClassicEditor
        .create(document.querySelector('#addDescription'))
        .then(editor => {
            addEditor = editor;
        })
        .catch(error => {
            console.error(error);
        });

    // Initialize DataTable with Export Buttons
    var table = $('#blogTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        dom: '<"row"<"col-md-6"l><"col-md-6"f>><"row"<"col-md-12"tr>><"row"<"col-md-5"i><"col-md-7"p>>',
        language: {
            search: "🔍 Quick Search:",
            lengthMenu: "Show _MENU_ entries",
            zeroRecords: "No matching blogs found",
            info: "Showing _START_ to _END_ of _TOTAL_ blogs",
            infoEmpty: "No blogs available",
            infoFiltered: "(filtered from _MAX_ total blogs)",
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
                    columns: [0, 2, 3, 4, 5]
                },
                title: 'Blogs_Export_' + new Date().toISOString().slice(0,10)
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="bi bi-file-earmark-pdf me-1"></i>PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: {
                    columns: [0, 2, 3, 4, 5]
                },
                title: 'Blogs_Export_' + new Date().toISOString().slice(0,10),
                customize: function (doc) {
                    doc.content[1].table.widths = ['5%', '25%', '15%', '15%', '40%'];
                }
            }
        ],
        initComplete: function() {
            // Add export buttons to the export section
            $('.export-buttons').html($('.dt-buttons'));
        }
    });

    // Filter by Title
    $('#searchTitle').on('keyup', function() {
        table.column(2).search(this.value).draw();
    });

    // Filter by Author
    $('#searchAuthor').on('keyup', function() {
        table.column(3).search(this.value).draw();
    });

    // Filter by Date Range
    $('#filterStartDate, #filterEndDate').on('change', function() {
        var startDate = $('#filterStartDate').val();
        var endDate = $('#filterEndDate').val();

        if (startDate || endDate) {
            // Custom filtering logic for date range
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var dateColumn = data[4]; // Date column
                    // Extract date from badge text
                    var dateMatch = dateColumn.match(/\d{1,2} \w{3}, \d{4}/);
                    if (!dateMatch) return true;

                    var dateParts = dateMatch[0].split(' ');
                    var monthNames = {
                        'Jan': 0, 'Feb': 1, 'Mar': 2, 'Apr': 3, 'May': 4, 'Jun': 5,
                        'Jul': 6, 'Aug': 7, 'Sep': 8, 'Oct': 9, 'Nov': 10, 'Dec': 11
                    };

                    var rowDate = new Date(
                        dateParts[2], // Year
                        monthNames[dateParts[1]], // Month
                        dateParts[0].replace(',', '') // Day
                    );

                    var start = startDate ? new Date(startDate) : null;
                    var end = endDate ? new Date(endDate) : null;

                    if (start && end) {
                        return rowDate >= start && rowDate <= end;
                    } else if (start) {
                        return rowDate >= start;
                    } else if (end) {
                        return rowDate <= end;
                    }
                    return true;
                }
            );

            table.draw();
            // Remove the filter function after applying
            $.fn.dataTable.ext.search.pop();
        } else {
            table.column(4).search('').draw();
        }
    });

    // Clear all filters
    $('#clearFilters').on('click', function() {
        $('#searchTitle').val('');
        $('#searchAuthor').val('');
        $('#filterStartDate').val('');
        $('#filterEndDate').val('');

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

    // Image preview for add modal - Blog Image
    $('#addBlogImage').on('change', function(e) {
        const reader = new FileReader();
        reader.onload = function() {
            $('#addImagePreview')
                .attr('src', reader.result)
                .removeClass('d-none');
        }
        if (e.target.files[0]) {
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // Image preview for add modal - Author Image
    $('#addAuthorImage').on('change', function(e) {
        const reader = new FileReader();
        reader.onload = function() {
            $('#addAuthorImagePreview')
                .attr('src', reader.result)
                .removeClass('d-none')
                .addClass('d-block');
        }
        if (e.target.files[0]) {
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // Edit blog modal
    $('.edit-blog-btn').on('click', function() {
        const btn = $(this);
        const form = $('#editBlogForm');
        const route = "{{ route('cms.blog.update', ':id') }}".replace(':id', btn.data('id'));
        form.attr('action', route);

        $('#editTitle').val(btn.data('title'));
        $('#editAuthor').val(btn.data('author'));
        $('#editDate').val(btn.data('date'));

        // Set blog image preview
        if(btn.data('image')){
            $('#editImagePreview')
                .attr('src', btn.data('image'))
                .removeClass('d-none');
        } else {
            $('#editImagePreview')
                .attr('src', '#')
                .addClass('d-none');
        }

        // Set author image preview
        if(btn.data('author_image')){
            $('#editAuthorImagePreview')
                .attr('src', btn.data('author_image'))
                .removeClass('d-none')
                .addClass('d-block');
            $('#currentAuthorImage').val(btn.data('author_image'));
        } else {
            $('#editAuthorImagePreview')
                .attr('src', '#')
                .addClass('d-none');
        }

        // Initialize CKEditor for edit modal if not already done
        if (!editEditor) {
            ClassicEditor
                .create(document.querySelector('#editDescription'))
                .then(editor => {
                    editEditor = editor;
                    editEditor.setData(btn.data('description'));
                })
                .catch(error => {
                    console.error(error);
                });
        } else {
            editEditor.setData(btn.data('description'));
        }

        // Show modal
        var editModal = new bootstrap.Modal(document.getElementById('editBlogModal'));
        editModal.show();
    });

    // Image preview for edit modal - Blog Image
    $('#editBlogImage').on('change', function(e) {
        const reader = new FileReader();
        reader.onload = function() {
            $('#editImagePreview').attr('src', reader.result);
        }
        if (e.target.files[0]) {
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // Image preview for edit modal - Author Image
    $('#editAuthorImage').on('change', function(e) {
        const reader = new FileReader();
        reader.onload = function() {
            $('#editAuthorImagePreview').attr('src', reader.result);
        }
        if (e.target.files[0]) {
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // Delete blog confirmation
    $('.btn-delete-blog').on('click', function(e) {
        e.preventDefault();
        let blogId = $(this).data('id');
        let blogTitle = $(this).data('title');
        let blogAuthor = $(this).data('author');
        let deleteUrl = "{{ route('cms.blog.delete', ':id') }}".replace(':id', blogId);

        Swal.fire({
            title: 'Are you sure?',
            html: `You are about to delete blog <strong>"${blogTitle}"</strong> by ${blogAuthor}. This action cannot be undone!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return new Promise((resolve) => {
                    // Create and submit form
                    var form = document.createElement('form');
                    form.method = 'POST';
                    form.action = deleteUrl;
                    form.style.display = 'none';

                    var csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    var methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    form.appendChild(methodField);

                    document.body.appendChild(form);
                    form.submit();
                    resolve();
                });
            }
        });
    });

    // Make rows clickable for better UX
    $('#blogTable tbody').on('click', 'tr', function(e) {
        // Don't trigger if clicking on action buttons or images
        if (!$(e.target).closest('.action-buttons').length && !$(e.target).is('img')) {
            $(this).find('.view-blog-btn').click();
        }
    });

    // Style rows on hover
    $('#blogTable tbody tr').css('cursor', 'pointer');

    // Auto-focus first input in add modal
    $('#addBlogModal').on('shown.bs.modal', function () {
        $(this).find('input[name="title"]').focus();
    });

    // Clear image preview when add modal is closed
    $('#addBlogModal').on('hidden.bs.modal', function () {
        $('#addImagePreview').addClass('d-none').attr('src', '#');
        $('#addAuthorImagePreview').addClass('d-none').attr('src', '#');
        if (addEditor) {
            addEditor.setData('');
        }
        $('#addBlogForm')[0].reset();
    });

    // Clear image preview when edit modal is closed
    $('#editBlogModal').on('hidden.bs.modal', function () {
        $('#editBlogImage').val('');
        $('#editAuthorImage').val('');
        if (editEditor) {
            editEditor.setData('');
        }
    });

    // Make author upload areas clickable
    $('.author-upload-area').on('click', function() {
        $(this).next('input[type="file"]').click();
    });
});
</script>
@endsection