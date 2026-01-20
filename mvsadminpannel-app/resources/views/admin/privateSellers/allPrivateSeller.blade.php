@extends('layouts.app')

@section('head')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
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
    #privateSellerTable thead th {
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

    /* User avatar styling */
    .user-avatar {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #dee2e6;
    }

    /* Contact info styling */
    .contact-info {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .contact-info a {
        text-decoration: none;
        color: #495057;
        transition: color 0.2s;
    }

    .contact-info a:hover {
        color: #0d6efd;
    }

    /* Seller type badge */
    .seller-badge {
        background: linear-gradient(135deg, #6f42c1 0%, #6610f2 100%);
        color: white;
        padding: 3px 12px;
        border-radius: 15px;
        font-size: 0.85em;
        font-weight: 500;
    }

    /* Action buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    /* Responsive table */
    .table-responsive {
        overflow-x: auto;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <!-- Main Card containing everything -->
    <div class="card main-card" style="margin-top: -30px;">
        <!-- Card Header with Title -->
        <div class="card-header card-header-custom d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <i class="bi bi-person-circle text-white fs-3 me-3"></i>
                <h4 class="mb-0 text-white">Private Sellers Management</h4>
            </div>
            <div  style="margin-left: 20rem;">
                <button id="exportExcel" class="btn btn-success btn-export me-2">
                    <i class="bi bi-file-earmark-excel me-1"></i>Export Excel
                </button>
                <button id="exportPDF" class="btn btn-danger btn-export">
                    <i class="bi bi-file-earmark-pdf me-1"></i>Export PDF
                </button>
            </div>
        </div>

        <!-- Card Body with Filter Section -->
        <div class="card-body">
            <!-- Filter Card -->
            <div class="filter-card mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0 text-primary"><i class="bi bi-funnel me-2"></i>Filter Options</h6>
                    <div class="text-muted">
                        <small><i class="bi bi-person me-1"></i>{{ $privateSeller->count() }} private sellers found</small>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Seller Name</label>
                        <input type="text" id="searchName" class="form-control filter-input" placeholder="Search by name...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Phone Number</label>
                        <input type="text" id="searchPhone" class="form-control filter-input" placeholder="Search phone...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Email Address</label>
                        <input type="text" id="searchEmail" class="form-control filter-input" placeholder="Search email...">
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
            @if($privateSeller->count() > 0)
                <div class="table-responsive">
                    <table id="privateSellerTable" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>Seller Details</th>
                                <th>Contact Information</th>
                                <th>Registration Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($privateSeller as $index => $private)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            @if($private->image)
                                                <img src="{{ asset($private->image) }}" class="user-avatar" alt="{{ $private->user->name }}">
                                            @else
                                                <div class="user-avatar bg-primary d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-person text-white"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $private->user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-2">
                                        <div class="contact-info">
                                            <i class="bi bi-telephone text-primary"></i>
                                            @if($private->user->phone)
                                                <a href="tel:{{ $private->user->phone }}">{{ $private->user->phone }}</a>
                                            @else
                                                <span class="text-muted">Not provided</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <div class="contact-info">
                                            <i class="bi bi-envelope text-primary"></i>
                                            @if($private->user->email)
                                                <a href="mailto:{{ $private->user->email }}">{{ $private->user->email }}</a>
                                            @else
                                                <span class="text-muted">Not provided</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small">{{ $private->created_at->format('d M, Y') }}</div>
                                    <div class="text-muted">{{ $private->created_at->format('h:i A') }}</div>
                                    <div class="text-muted small">{{ $private->created_at->diffForHumans() }}</div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-person-x fs-1 text-muted mb-3"></i>
                    <h5 class="text-muted">No Private Sellers Found</h5>
                    <p class="text-muted">There are no private sellers registered yet.</p>

                </div>
            @endif
        </div>
    </div>
</div>

<!-- View Seller Modal -->

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<script>
$(document).ready(function () {
    // Initialize DataTable with Export Buttons
    var table = $('#privateSellerTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        dom: '<"row"<"col-md-6"l><"col-md-6"f>><"row"<"col-md-12"tr>><"row"<"col-md-5"i><"col-md-7"p>>',
        language: {
            search: "🔍 Quick Search:",
            lengthMenu: "Show _MENU_ entries",
            zeroRecords: "No matching sellers found",
            info: "Showing _START_ to _END_ of _TOTAL_ sellers",
            infoEmpty: "No sellers available",
            infoFiltered: "(filtered from _MAX_ total sellers)",
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
                    columns: [0, 1, 2, 3]
                },
                title: 'Private_Sellers_Export_' + new Date().toISOString().slice(0,10)
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="bi bi-file-earmark-pdf me-1"></i>PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                },
                title: 'Private_Sellers_Export_' + new Date().toISOString().slice(0,10),
                customize: function (doc) {
                    doc.content[1].table.widths = ['10%', '35%', '35%', '20%'];
                }
            }
        ],
        initComplete: function() {
            // Add export buttons to the export section
            $('.export-buttons').html($('.dt-buttons'));
        }
    });

    // Filter by Name
    $('#searchName').on('keyup', function() {
        table.column(1).search(this.value).draw();
    });

    // Filter by Phone
    $('#searchPhone').on('keyup', function() {
        table.column(2).search(this.value).draw();
    });

    // Filter by Email
    $('#searchEmail').on('keyup', function() {
        table.column(2).search(this.value).draw();
    });

    // Clear all filters
    $('#clearFilters').on('click', function() {
        $('#searchName').val('');
        $('#searchPhone').val('');
        $('#searchEmail').val('');

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

    // View seller details
    $('.view-seller-btn').on('click', function() {
        let sellerId = $(this).data('id');
        let sellerName = $(this).data('name');

        // Set modal title
        $('#viewSellerModal .modal-title').text('Seller Details: ' + sellerName);

        // Show modal with loading spinner
        var viewModal = new bootstrap.Modal(document.getElementById('viewSellerModal'));
        viewModal.show();

        // Load seller details via AJAX
        $.ajax({
            url: '/private-sellers/' + sellerId,
            method: 'GET',
            success: function(response) {
                $('#sellerDetailsContent').html(response);
            },
            error: function() {
                $('#sellerDetailsContent').html(`
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Failed to load seller details. Please try again.
                    </div>
                `);
            }
        });
    });

    // Edit seller (placeholder)
    $('.edit-seller-btn').on('click', function() {
        let sellerId = $(this).data('id');

        Swal.fire({
            title: 'Edit Seller',
            text: 'Edit functionality will be implemented soon.',
            icon: 'info',
            confirmButtonText: 'OK'
        });
    });

    // Delete seller confirmation
    $('.btn-delete-seller').on('click', function(e) {
        e.preventDefault();
        let form = $(this).closest('.delete-seller-form');
        let sellerName = $(this).data('name');

        Swal.fire({
            title: 'Are you sure?',
            html: `You are about to delete <strong>"${sellerName}"</strong>. This action cannot be undone!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return new Promise((resolve) => {
                    setTimeout(() => {
                        form.submit();
                        resolve();
                    }, 1000);
                });
            }
        });
    });

    // Make rows clickable for better UX
    $('#privateSellerTable tbody').on('click', 'tr', function(e) {
        // Don't trigger if clicking on action buttons
        if (!$(e.target).closest('.action-buttons').length) {
            $(this).find('.view-seller-btn').click();
        }
    });

    // Style rows on hover
    $('#privateSellerTable tbody tr').css('cursor', 'pointer');
});
</script>
@endsection