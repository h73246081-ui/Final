@extends('layouts.app')

@section('head')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    #flashTable thead th {
        background-color: #0d6efd !important;
        color: #fff !important;
    }
</style>
@endsection

@section('content')
<div class="container p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-primary">Flash Deals</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFlashModal">
            <i class="bi bi-plus-circle"></i> Add New Deal
        </button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="flashTable" class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Discount</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deals as $index => $deal)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $deal->title }}</td>
                            <td>{{ $deal->category?->name ?? '-' }}</td>
                            <td>{{ $deal->discount }}%</td>
                            <td>{{ \Carbon\Carbon::parse($deal->start_at)->format('d M, Y H:i') }}</td>
                            <td>{{ \Carbon\Carbon::parse($deal->end_at)->format('d M, Y H:i') }}</td>
                            <td>
                                @if($deal->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td class="text-center d-flex justify-content-center gap-2">
                                <button class="btn btn-sm btn-outline-primary edit-flash-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editFlashModal"
                                    data-id="{{ $deal->id }}"
                                    data-title="{{ $deal->title }}"
                                    data-description="{{ $deal->description }}"
                                    data-discount="{{ $deal->discount }}"
                                    data-category="{{ $deal->category_id }}"
                                    data-product="{{ $deal->product_id }}"
                                    data-start="{{ \Carbon\Carbon::parse($deal->start_at)->format('Y-m-d\TH:i') }}"
                                    data-end="{{ \Carbon\Carbon::parse($deal->end_at)->format('Y-m-d\TH:i') }}"
                                    data-active="{{ $deal->is_active }}"
                                >
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form id="delete-flash-form-{{ $deal->id }}" 
                                      action="{{ route('flash.destroy', $deal->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="confirmDeleteFlashdeal({{ $deal->id }})">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No flash deals found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Flash Deal Modal -->
<div class="modal fade" id="addFlashModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="flashForm" action="{{ route('flash.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add Flash Deal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Title *</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select name="category_id" class="form-select select-category-add">
                                    <option value="">-- Select Category --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Start Date & Time *</label>
                                <input type="datetime-local" name="start_at" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Discount (%) *</label>
                                <input type="number" name="discount" class="form-control" min="0" max="100" value="0" required>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Product</label>
                                <select name="product_id" class="form-select select-product-add">
                                    <option value="">-- Select Product --</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-category="{{ $product->category_id }}">
                                            {{ $product->name }} ({{ $product->vendor->store_name ?? 'No Vendor' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">End Date & Time *</label>
                                <input type="datetime-local" name="end_at" class="form-control" required>
                            </div>
                            <div class="form-check mb-3">
                                <input type="checkbox" name="is_active" value="1" class="form-check-input" checked>
                                <label class="form-check-label">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Deal</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Flash Deal Modal -->
<div class="modal fade" id="editFlashModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editFlashForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Edit Flash Deal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Title *</label>
                                <input type="text" name="title" id="editTitle" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select name="category_id" id="editCategory" class="form-select select-category-edit">
                                    <option value="">-- Select Category --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Start Date & Time *</label>
                                <input type="datetime-local" name="start_at" id="editStart" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Discount (%) *</label>
                                <input type="number" name="discount" id="editDiscount" class="form-control" min="0" max="100" required>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" id="editDescription" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Product</label>
                                <select name="product_id" id="editProduct" class="form-select select-product-edit">
                                    <option value="">-- Select Product --</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-category="{{ $product->category_id }}">
                                            {{ $product->name }} ({{ $product->vendor->store_name ?? 'No Vendor' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">End Date & Time *</label>
                                <input type="datetime-local" name="end_at" id="editEnd" class="form-control" required>
                            </div>
                            <div class="form-check mb-3">
                                <input type="checkbox" name="is_active" value="1" id="editIsActive" class="form-check-input">
                                <label class="form-check-label">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Deal</button>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
 $(document).ready(function () {

    // DataTable
    $('#flashTable').DataTable({
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

    // Initialize Select2 for Add modal
    $('#addFlashModal').find('.select-category-add').select2({
        placeholder: "Search Category...",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#addFlashModal')
    });
    $('#addFlashModal').find('.select-product-add').select2({
        placeholder: "Search Product...",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#addFlashModal')
    });

    // Initialize Select2 for Edit modal
    $('#editFlashModal').find('.select-category-edit').select2({
        placeholder: "Search Category...",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#editFlashModal')
    });
    $('#editFlashModal').find('.select-product-edit').select2({
        placeholder: "Search Product...",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#editFlashModal')
    });

    // Store all product options separately
    const allProductsAdd = $('#addFlashModal .select-product-add option').clone();
    const allProductsEdit = $('#editFlashModal .select-product-edit option').clone();

    function filterProducts(categorySelect, productSelect, allProducts) {
        const selectedCat = categorySelect.val();
        productSelect.empty().append('<option value="">-- Select Product --</option>');
        allProducts.each(function () {
            const prodCat = $(this).data('category');
            if (!selectedCat || prodCat == selectedCat) {
                productSelect.append($(this).clone());
            }
        });
        productSelect.val(null).trigger('change');
    }

    // Filter products on category change
    $('#addFlashModal .select-category-add').on('change', function () {
        filterProducts($(this), $('#addFlashModal .select-product-add'), allProductsAdd);
    });
    $('#editFlashModal .select-category-edit').on('change', function () {
        filterProducts($(this), $('#editFlashModal .select-product-edit'), allProductsEdit);
    });


    // Prepare route template
let updateUrlTemplate = "{{ route('flash.update', ['id' => ':id']) }}";

// Fill edit modal
$('.edit-flash-btn').click(function () {
    const btn = $(this);
    const modal = $('#editFlashModal');

    // Replace :id in route template with actual id
    let updateUrl = updateUrlTemplate.replace(':id', btn.data('id'));
    modal.find('#editFlashForm').attr('action', updateUrl);

    // Fill form fields
    modal.find('#editTitle').val(btn.data('title'));
    modal.find('#editDescription').val(btn.data('description'));
    modal.find('#editDiscount').val(btn.data('discount'));
    modal.find('#editStart').val(btn.data('start'));
    modal.find('#editEnd').val(btn.data('end'));
    modal.find('#editIsActive').prop('checked', btn.data('active'));

    // Set category first (triggers product filtering)
    modal.find('#editCategory').val(btn.data('category')).trigger('change');

    // Filter products for selected category
    filterProducts(modal.find('#editCategory'), modal.find('#editProduct'), allProductsEdit);

    // Set product after filtering
    modal.find('#editProduct').val(btn.data('product')).trigger('change');
});


 
});

// Delete confirm
function confirmDeleteFlash(id) {
    if (confirm('Are you sure you want to delete this flash deal?')) {
        $('#delete-flash-form-' + id).submit();
    }
}

</script>
@endsection
