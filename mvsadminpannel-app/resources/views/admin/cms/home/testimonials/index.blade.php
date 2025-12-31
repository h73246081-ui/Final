{{-- resources/views/testimonials/index.blade.php --}}
@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<style>
#testimonialTable thead th {
    background-color: #0d6efd !important;
    color: #fff !important;
}
</style>
@endsection

@section('title', 'All Testimonials')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>All Testimonials</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Add Testimonial</button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if($testimonials->count() > 0)
            <div class="table-responsive">
                <table id="testimonialTable" class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Profession</th>
                            <th>Location</th>
                            <th>Rating</th>
                            <th>Comments</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($testimonials as $testimonial)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $testimonial->name }}</td>
                            <td>{{ $testimonial->role }}</td>
                            <td>{{ $testimonial->location }}</td>
                            <td>
                                {{ str_repeat('⭐', $testimonial->rating) }}
                            </td>
                            <td>{{ $testimonial->comments }}</td>
                            <td>
                                @if($testimonial->avatar)
                                    <img src="{{ asset('storage/'.$testimonial->avatar) }}" width="60">
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning editBtn"
                                    data-id="{{ $testimonial->id }}"
                                    data-name="{{ $testimonial->name }}"
                                    data-role="{{ $testimonial->role }}"
                                    data-location="{{ $testimonial->location }}"
                                    data-rating="{{ $testimonial->rating }}"
                                    data-comments="{{ $testimonial->comments }}"
                                    data-avatar="{{ $testimonial->avatar ? asset('storage/'.$testimonial->avatar) : '' }}">
                                    Edit
                                </button>

                                <form id="delete-testimonial-form-{{ $testimonial->id }}" action="{{ route('delete.testimonial', $testimonial->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onclick="confirmDeleteTestimonial({{ $testimonial->id }})">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- ADD MODAL --}}
<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('cms.testimonials.store') }}" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header bg-primary text-light">
                <h5 class="mt-3">Add Testimonial</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input name="name" class="form-control mb-2" placeholder="Name" required>
                <input name="profession" class="form-control mb-2" placeholder="Profession">
                <input name="location" class="form-control mb-2" placeholder="Location">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Rating</label>
                    <select name="rating" class="form-select">
                        @for($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}">{{ str_repeat('⭐', $i) }} ({{ $i }})</option>
                        @endfor
                    </select>
                </div>

                <textarea name="comments" class="form-control mb-2" placeholder="Comments"></textarea>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Avatar</label>
                    <input type="file" name="image" id="addAvatar" class="form-control">
                    <div class="mt-2">
                        <img id="addAvatarPreview" src="" alt="Preview" style="max-width:120px; max-height:120px; display:none;" class="rounded">
                    </div>
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
            <div class="modal-header bg-primary text-light">
                <h5 class="mt-3">Edit Testimonial</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input name="name" id="editName" class="form-control mb-2" required>
                <input name="profession" id="editRole" class="form-control mb-2">
                <input name="location" id="editLocation" class="form-control mb-2">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Rating</label>
                    <select name="rating" id="editRating" class="form-select">
                        @for($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}">{{ str_repeat('⭐', $i) }} ({{ $i }})</option>
                        @endfor
                    </select>
                </div>

                <textarea name="comments" id="editComments" class="form-control mb-2"></textarea>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Avatar</label>
                    <input type="file" name="image" id="editAvatar" class="form-control">
                    <div class="mt-2">
                        <img id="editAvatarPreview" src="" alt="Preview" style="max-width:120px; max-height:120px; display:none;" class="rounded">
                    </div>
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
    $('#testimonialTable').DataTable();

    // Edit button click
    $('.editBtn').click(function () {
        $('#editName').val($(this).data('name'));
        $('#editRole').val($(this).data('role'));
        $('#editLocation').val($(this).data('location'));
        $('#editRating').val($(this).data('rating'));
        $('#editComments').val($(this).data('comments'));

        var avatar = $(this).data('avatar');
        if(avatar){
            $('#editAvatarPreview').attr('src', avatar).show();
        } else {
            $('#editAvatarPreview').hide();
        }

        var id = $(this).data('id');
$('#editForm').attr('action', '{{ route("cms.testimonials.update", ":id") }}'.replace(':id', id));

        $('#editModal').modal('show');
    });

    // Live preview for Add Modal
    $('#addAvatar').change(function(event){
        var reader = new FileReader();
        reader.onload = function(){
            $('#addAvatarPreview').attr('src', reader.result).show();
        }
        reader.readAsDataURL(event.target.files[0]);
    });

    // Live preview for Edit Modal
    $('#editAvatar').change(function(event){
        var reader = new FileReader();
        reader.onload = function(){
            $('#editAvatarPreview').attr('src', reader.result).show();
        }
        reader.readAsDataURL(event.target.files[0]);
    });
});
</script>
@endsection
