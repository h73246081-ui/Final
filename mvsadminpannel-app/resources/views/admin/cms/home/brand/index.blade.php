@extends('layouts.app')

@section('head')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
        /* Force table header to match Add Brand button color */
        #brandTable thead th {
            background-color: #0d6efd !important; /* Bootstrap primary */
            color: #fff !important;
        }
    </style>
@endsection

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h2>Brands</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBrandModal">
           Add Brand
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="brandTable" class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>BW Image</th>
                        <th>Color Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($brands as $brand)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $brand->name }}</td>
                            <td>
                                @if($brand->image_bw)
                                    <img src="{{ asset('storage/'.$brand->image_bw) }}" width="60" class="img-thumbnail">
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($brand->image_color)
                                    <img src="{{ asset('storage/'.$brand->image_color) }}" width="60" class="img-thumbnail">
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning"
                                    onclick="openEditBrandModal(
                                        {{ $brand->id }},
                                        '{{ addslashes($brand->name) }}',
                                        '{{ $brand->image_bw ? asset('storage/'.$brand->image_bw) : '' }}',
                                        '{{ $brand->image_color ? asset('storage/'.$brand->image_color) : '' }}'
                                    )">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form id="delete-form-{{ $brand->id }}" 
                                      action="{{ route('brands.destroy', $brand->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDeleteBrand({{ $brand->id }})">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No Brands Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Brand Modal -->
<div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addBrandModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="addBrandModalLabel">Add Brand</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label">Brand Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">BW Image</label>
                        <input type="file" name="image_bw" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Color Image</label>
                        <input type="file" name="image_color" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save Brand</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Brand Modal -->
<div class="modal fade" id="editBrandModal" tabindex="-1" aria-labelledby="editBrandModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="editBrandForm" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-header bg-warning text-white">
          <h5 class="modal-title" id="editBrandModalLabel">Edit Brand</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label">Brand Name</label>
                        <input type="text" name="name" id="editBrandName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">BW Image</label>
                        <input type="file" name="image_bw" class="form-control" id="editBrandBWInput">
                        <div class="mt-2" id="editBrandBWPreview"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Color Image</label>
                        <input type="file" name="image_color" class="form-control" id="editBrandColorInput">
                        <div class="mt-2" id="editBrandColorPreview"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Update Brand</button>
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
    $('#brandTable').DataTable({
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

function openEditBrandModal(id, name, bwImage = '', colorImage = '') {
    let url = '{{ route("brands.update", ":id") }}';
    url = url.replace(':id', id);
    $('#editBrandForm').attr('action', url);
    $('#editBrandName').val(name);
    $('#editBrandBWPreview').html(bwImage ? '<img src="'+bwImage+'" width="120" class="mt-2">' : '');
    $('#editBrandColorPreview').html(colorImage ? '<img src="'+colorImage+'" width="120" class="mt-2">' : '');
    new bootstrap.Modal(document.getElementById('editBrandModal')).show();
}

function confirmDeleteBrand(id){
    if(confirm('Are you sure you want to delete this brand?')){
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endsection
