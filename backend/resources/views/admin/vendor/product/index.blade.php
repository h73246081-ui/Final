@extends('layouts.app')

@section('head')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Buttons for Excel/PDF Export -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
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
    #productsTable thead th {
        background-color: #0d6efd !important;
        color: #fff !important;
        font-weight: 600;
    }

    /* Button polish */
    .btn-export {
        border-radius: 6px;
        font-weight: 500;
        padding: 8px 16px;
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

    /* Image slider styling */
    .image-slider {
        display: flex;
        gap: 6px;
        overflow-x: auto;
        max-width: 220px;
        padding-bottom: 4px;
    }

    .image-slider::-webkit-scrollbar {
        height: 6px;
    }

    .image-slider::-webkit-scrollbar-thumb {
        background: #0d6efd;
        border-radius: 10px;
    }

    .image-slider img {
        width: 45px;
        height: 45px;
        object-fit: cover;
        border-radius: 6px;
        flex-shrink: 0;
        cursor: pointer;
        transition: transform .2s;
    }

    .image-slider img:hover {
        transform: scale(1.8);
        z-index: 10;
    }

    /* Status label styling */
    .status-label {
        font-weight: bold;
    }

    .status-label.active {
        color: #198754;
    }

    .status-label.inactive {
        color: #dc3545;
    }

    /* Badge styling */
    .badge {
        margin-right: 4px;
        margin-bottom: 4px;
    }

    /* Table responsive fixes */
    .table-responsive {
        overflow-x: auto;
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

        .btn-export {
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

        .card-header-custom h4 {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 400px) {
        .d-flex.flex-wrap {
            flex-direction: column;
            width: 100%;
        }

        .btn-export {
            width: 100%;
            justify-content: center;
            margin-bottom: 5px;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Main Card containing everything -->
    <div class="card main-card">
        <div class="card-header card-header-custom">
            <div class="row align-items-center">
                <!-- Title on Left -->
                <div class="col-12 col-md-6 mb-3 mb-md-0">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        <i class="bi bi-box-seam text-white fs-3 me-3"></i>
                        <h4 class="mb-0 text-white">Seller Products Management</h4>
                    </div>
                </div>

                <!-- Buttons on Right -->
                <div class="col-12 col-md-6">
                    <div class="d-flex flex-wrap justify-content-center justify-content-md-end align-items-center gap-2">
                        <button id="exportExcel" class="btn btn-success btn-export">
                            <i class="bi bi-file-earmark-excel me-1"></i>
                            <span class="d-none d-sm-inline">Excel</span>
                        </button>
                        <button id="exportPDF" class="btn btn-danger btn-export">
                            <i class="bi bi-file-earmark-pdf me-1"></i>
                            <span class="d-none d-sm-inline">PDF</span>
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
                </div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Category</label>
                        <select id="filterCategory" class="form-control">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{$cat->id}}">{{$cat->name}}</option>

                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Stock Status</label>
                        <select id="filterStock" class="form-control filter-input">
                            <option value="">All</option>
                            <option value="in">In Stock</option>
                            <option value="out">Out of Stock</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Product Status</label>
                        <select id="filterStatus" class="form-control filter-input">
                            <option value="">All</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 d-flex justify-content-between">
                        <button id="clearFilters" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-x-circle me-1"></i>Clear Filters
                        </button>
                    </div>
                </div>
            </div>

            <!-- DataTable -->
            <div class="table-responsive">
                <table id="productsTable" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th width="50">#</th>
                            <th>Seller</th>
                            <th>Seller Store</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Stock</th>
                            <th>Category</th>
                            <th>Sizes</th>
                            <th>Colors</th>
                            <th>Images</th>
                            <th>Status</th>
                            <th width="100" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $key => $product)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $product->vendor->user->name ?? 'N/A' }}</td>
                            <td>{{ $product->vendor->vendorStore->store_name ?? 'N/A' }}</td>
                            <td>{{ $product->name }}</td>
                            <td>Rs {{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->discount }}%</td>
                            <td>
                                <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                                    {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                                </span>
                            </td>
                            <td data-category-id="{{ $product->category_id ?? '' }}">
                                {{ $product->category->name ?? 'N/A' }}
                            </td>
                            <td>
                                @php
                                    $sizes = [];
                                    if(!empty($product->sizes)) {
                                        if(is_string($product->sizes)) {
                                            $decoded = json_decode($product->sizes, true);
                                            $sizes = is_array($decoded) ? $decoded : explode(',', $product->sizes);
                                        } elseif(is_array($product->sizes)) {
                                            $sizes = $product->sizes;
                                        }
                                    }
                                @endphp

                                @if(count($sizes))
                                    @foreach($sizes as $size)
                                        <span class="badge bg-info">{{ $size }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $colors = [];
                                    if(!empty($product->color)) {
                                        if(is_string($product->color)) {
                                            $decoded = json_decode($product->color, true);
                                            $colors = is_array($decoded) ? $decoded : explode(',', $product->color);
                                        } elseif(is_array($product->color)) {
                                            $colors = $product->color;
                                        }
                                    }
                                @endphp

                                @if(count($colors))
                                    @foreach($colors as $clr)
                                        <span class="badge bg-warning text-dark">{{ $clr }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $images = is_array($product->image)
                                        ? $product->image
                                        : json_decode($product->image, true);
                                @endphp

                                @if(!empty($images))
                                    <div class="image-slider">
                                        @foreach($images as $img)
                                            <img src="{{ asset($img) }}" alt="Product Image">
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input toggle-status"
                                           type="checkbox"
                                           data-id="{{ $product->id }}"
                                           {{ $product->status == 'Active' ? 'checked' : '' }}>
                                    <label class="form-check-label status-label {{ strtolower($product->status) }}">
                                        {{ ucfirst($product->status) }}
                                    </label>
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('product.show', $product->id) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   title="View Details">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="13" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No products found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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
<!-- Export Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
$(document).ready(function () {
    // Initialize DataTable with Export Buttons
    var table = $('#productsTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        dom: '<"row"<"col-md-6"l><"col-md-6"f>><"row"<"col-md-12"tr>><"row"<"col-md-5"i><"col-md-7"p>>',
        language: {
            search: "🔍 Quick Search:",
            lengthMenu: "Show _MENU_ entries",
            zeroRecords: "No matching records found",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "No entries available",
            infoFiltered: "(filtered from _MAX_ total entries)",
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
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                },
                title: 'Vendor_Products_Export_' + new Date().toISOString().slice(0,10)
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="bi bi-file-earmark-pdf me-1"></i>PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                },
                title: 'Vendor_Products_Export_' + new Date().toISOString().slice(0,10),
                customize: function (doc) {
                    doc.content[1].table.widths = Array(12).fill('*');
                }
            }
        ],
        initComplete: function() {
            // Move export buttons to header
            $('.export-buttons').html($('.dt-buttons'));
        }
    });

    // Initialize Select2 for filters
    $('.select2-filter').select2({
        placeholder: "Select Category",
        allowClear: true,
        width: '100%'
    });

    // Filter by Product Name
    $('#searchProduct').on('keyup', function() {
        table.column(3).search(this.value).draw();
    });

// Add custom filter for Category
$.fn.dataTable.ext.search.push(
    function(settings, data, dataIndex) {
        var selectedCategory = $('#filterCategory').val();
        if (!selectedCategory) return true; // no filter

        // get category id from data attribute
        var rowCategoryId = $(table.row(dataIndex).node()).find('td').eq(7).data('category-id');

        return rowCategoryId == selectedCategory;
    }
);

// Trigger table redraw when category filter changes
$('#filterCategory').on('change', function() {
    table.draw();
});


    // Filter by Stock Status
    $('#filterStock').on('change', function() {
        var stockFilter = this.value;
        if (stockFilter === 'in') {
            table.column(6).search('^In Stock$', true, false).draw();
        } else if (stockFilter === 'out') {
            table.column(6).search('^Out of Stock$', true, false).draw();
        } else {
            table.column(6).search('').draw();
        }
    });

    // Filter by Status
    $('#filterStatus').on('change', function() {
        var statusFilter = this.value;
        table.column(11).search(statusFilter).draw();
    });

    // Clear all filters
    $('#clearFilters').on('click', function() {
        $('#searchProduct').val('');
        $('#filterCategory').val('').trigger('change');
        $('#filterStock').val('');
        $('#filterStatus').val('');

        table.columns().search('').draw();
    });

    // Export Excel button click
    $('#exportExcel').on('click', function() {
        table.button('.buttons-excel').trigger();
    });

    // Export PDF button click
    $('#exportPDF').on('click', function() {
        table.button('.buttons-pdf').trigger();
    });

    // Toggle status switch
    $(document).on('change', '.toggle-status', function(){
        let productId = $(this).data('id');
        let status = $(this).is(':checked') ? 'active' : 'inactive';
        let label = $(this).siblings('.status-label');
        let statusText = status.charAt(0).toUpperCase() + status.slice(1);

        // Update label
        label.removeClass('active inactive').addClass(status).text(statusText);

        // Send AJAX request
        $.ajax({
            url: '{{ route("product.toggleStatus") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: productId,
                status: statusText
            },
            success: function(res){
                if(!res.success){
                    alert('Something went wrong!');
                    // Revert the toggle
                    $(this).prop('checked', !$(this).prop('checked'));
                }
            },
            error: function(err){
                alert('Error! Try again.');
                // Revert the toggle
                $(this).prop('checked', !$(this).prop('checked'));
            }
        });
    });
});
</script>
@endsection