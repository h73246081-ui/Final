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
    #sellerPackagesTable thead th {
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

    /* Package styling */
    .package-name {
        font-weight: 600;
        color: #2c3e50;
    }

    .package-badge {
        background: linear-gradient(135deg, #6f42c1 0%, #6610f2 100%);
        color: white;
        padding: 3px 12px;
        border-radius: 15px;
        font-size: 0.85em;
        font-weight: 500;
        display: inline-block;
    }

    /* Seller styling */
    .seller-info {
        display: flex;
        flex-direction: column;
    }

    .seller-name {
        font-weight: 600;
        color: #2c3e50;
    }

    /* Store styling */
    .store-badge {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
        padding: 3px 10px;
        border-radius: 15px;
        font-size: 0.85em;
        font-weight: 500;
    }

    /* Amount styling */
    .amount {
        font-weight: bold;
        color: #198754;
        font-size: 1.1em;
    }

    /* Payment method badges */
    .payment-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.85em;
        font-weight: 500;
    }

    .payment-cash {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border: 1px solid #28a745;
    }

    .payment-card {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
        border: 1px solid #0d6efd;
    }

    .payment-online {
        background-color: rgba(255, 193, 7, 0.1);
        color: #ffc107;
        border: 1px solid #ffc107;
    }

    /* Purchase date styling */
    .date-cell {
        min-width: 120px;
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

    /* Status badges */
    .status-badge {
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 0.85em;
        font-weight: 500;
    }

    .status-active {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border: 1px solid #28a745;
    }

    .status-expired {
        background-color: rgba(108, 117, 125, 0.1);
        color: #6c757d;
        border: 1px solid #6c757d;
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <!-- Main Card containing everything -->
    <div class="card main-card" style="margin-top: -30px;">
        <div class="card-header card-header-custom">
            <div class="row align-items-center">
                <!-- Title on Left -->
                <div class="col-12 col-md-6 mb-3 mb-md-0">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        <i class="bi bi-credit-card text-white fs-3 me-3"></i>
                        <h4 class="mb-0 text-white">Seller Packages Management</h4>
                    </div>
                </div>

                <!-- Buttons on Right -->
                <div class="col-12 col-md-6">
                    <div class="d-flex flex-wrap justify-content-center justify-content-md-end align-items-center gap-2">
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
                </div>
            </div>
        </div>

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

        <!-- Card Body with Filter Section -->
        <div class="card-body">
            <!-- Filter Card -->
            <div class="filter-card mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0 text-primary"><i class="bi bi-funnel me-2"></i>Filter Options</h6>
                    @php
                        $totalPurchases = 0;
                        foreach($pack as $item) {
                            $totalPurchases += $item->vendorPackages->count();
                        }
                    @endphp
                    <div class="text-muted">
                        <small><i class="bi bi-cart-check me-1"></i>{{ $totalPurchases }} package purchases</small>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Seller Name</label>
                        <input type="text" id="searchSeller" class="form-control filter-input" placeholder="Search seller...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Store Name</label>
                        <input type="text" id="searchStore" class="form-control filter-input" placeholder="Search store...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Package Name</label>
                        <input type="text" id="searchPackage" class="form-control filter-input" placeholder="Search package...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Payment Method</label>
                        <select id="filterPayment" class="form-control filter-input">
                            <option value="">All Methods</option>
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                            <option value="online">Online</option>
                        </select>
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
            @if($totalPurchases > 0)
                <div class="table-responsive">
                    <table id="sellerPackagesTable" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>Package Details</th>
                                <th>Seller Information</th>
                                <th>Store</th>
                                <th>Purchase Amount</th>
                                <th>Payment Method</th>
                                <th>Purchase Date</th>
                                <th>Status</th>
                                <th width="100" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $globalIndex = 1;
                            @endphp
                            @foreach($pack as $item)
                                @foreach($item->vendorPackages as $vendorPackage)
                                    @php
                                        // Determine payment method class
                                        $paymentMethod = strtolower($vendorPackage->payment_method);
                                        $paymentClass = '';
                                        if (str_contains($paymentMethod, 'cash')) $paymentClass = 'payment-cash';
                                        elseif (str_contains($paymentMethod, 'card')) $paymentClass = 'payment-card';
                                        elseif (str_contains($paymentMethod, 'online') || str_contains($paymentMethod, 'digital')) $paymentClass = 'payment-online';
                                        else $paymentClass = 'payment-cash';

                                        // Determine package status (you can calculate based on purchase date and package duration)
                                        $purchaseDate = $vendorPackage->created_at ?? now();
                                        $packageDuration = $item->duration ?? 30;
                                        $expiryDate = $purchaseDate->copy()->addDays($packageDuration);
                                        $isActive = now()->lte($expiryDate);
                                        $statusClass = $isActive ? 'status-active' : 'status-expired';
                                        $statusText = $isActive ? 'Active' : 'Expired';
                                    @endphp
                                    <tr>
                                        <td>{{ $globalIndex++ }}</td>
                                        <td>
                                            <div class="package-name">{{ $item->package_name }}</div>
                                            <div class="text-muted small mt-1">
                                                <i class="bi bi-clock me-1"></i>{{ $item->duration }} days
                                                <span class="mx-2">|</span>
                                                <i class="bi bi-box me-1"></i>{{ $item->product_limit }} products
                                            </div>
                                            <div class="text-muted small">
                                                <i class="bi bi-percent me-1"></i>{{ $item->commission_percent }}% commission
                                            </div>
                                        </td>
                                        <td>
                                            <div class="seller-info">
                                                <div class="seller-name">{{ $vendorPackage->vendor->user->name ?? 'N/A' }}</div>
                                                @if($vendorPackage->vendor->user->email ?? false)
                                                    <small class="text-muted">
                                                        <i class="bi bi-envelope me-1"></i>{{ $vendorPackage->vendor->user->email }}
                                                    </small>
                                                @endif
                                                @if($vendorPackage->vendor->user->phone ?? false)
                                                    <small class="text-muted">
                                                        <i class="bi bi-telephone me-1"></i>{{ $vendorPackage->vendor->user->phone }}
                                                    </small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if($vendorPackage->vendor->vendorStore && $vendorPackage->vendor->vendorStore->store_name)
                                                <span class="store-badge">{{ $vendorPackage->vendor->vendorStore->store_name }}</span>
                                            @else
                                                <span class="text-muted">No Store</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="amount">${{ number_format($vendorPackage->amount, 2) }}</div>
                                            <small class="text-muted">Paid</small>
                                        </td>
                                        <td>
                                            <span class="payment-badge {{ $paymentClass }}">
                                                {{ ucfirst($vendorPackage->payment_method) }}
                                            </span>
                                        </td>
                                        <td class="date-cell">
                                            <div class="small">{{ $purchaseDate->format('d M, Y') }}</div>
                                            <div class="text-muted">{{ $purchaseDate->format('h:i A') }}</div>
                                            @if(!$isActive)
                                                <div class="text-danger small">Expired: {{ $expiryDate->format('d M, Y') }}</div>
                                            @else
                                                <div class="text-success small">Valid until: {{ $expiryDate->format('d M, Y') }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="status-badge {{ $statusClass }}">
                                                {{ $statusText }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="action-buttons">
                                                <button class="btn btn-sm btn-outline-primary view-purchase-btn"
                                                        data-id="{{ $vendorPackage->id }}"
                                                        data-package="{{ $item->package_name }}"
                                                        data-seller="{{ $vendorPackage->vendor->user->name ?? 'N/A' }}"
                                                        data-amount="${{ number_format($vendorPackage->amount, 2) }}"
                                                        title="View Details">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-cart-x fs-1 text-muted mb-3"></i>
                    <h5 class="text-muted">No Package Purchases Found</h5>
                    <p class="text-muted">Sellers haven't purchased any packages yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- View Purchase Details Modal -->
<div class="modal fade" id="viewPurchaseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Purchase Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="purchaseDetailsContent">
                <!-- Details will be loaded here via AJAX -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="printInvoiceBtn">
                    <i class="bi bi-printer me-1"></i>Print Invoice
                </button>
            </div>
        </div>
    </div>
</div>


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
    var table = $('#sellerPackagesTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        order: [[6, 'desc']], // Sort by purchase date descending
        dom: '<"row"<"col-md-6"l><"col-md-6"f>><"row"<"col-md-12"tr>><"row"<"col-md-5"i><"col-md-7"p>>',
        language: {
            search: "🔍 Quick Search:",
            lengthMenu: "Show _MENU_ entries",
            zeroRecords: "No matching purchases found",
            info: "Showing _START_ to _END_ of _TOTAL_ purchases",
            infoEmpty: "No purchases available",
            infoFiltered: "(filtered from _MAX_ total purchases)",
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
                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                },
                title: 'Seller_Packages_Export_' + new Date().toISOString().slice(0,10)
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="bi bi-file-earmark-pdf me-1"></i>PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                },
                title: 'Seller_Packages_Export_' + new Date().toISOString().slice(0,10),
                customize: function (doc) {
                    doc.content[1].table.widths = ['5%', '20%', '15%', '10%', '10%', '10%', '12%', '8%', '10%'];
                }
            }
        ],
        initComplete: function() {
            // Add export buttons to the export section
            $('.export-buttons').html($('.dt-buttons'));
        }
    });

    // Filter by Seller Name
    $('#searchSeller').on('keyup', function() {
        table.column(2).search(this.value).draw();
    });

    // Filter by Store Name
    $('#searchStore').on('keyup', function() {
        table.column(3).search(this.value).draw();
    });

    // Filter by Package Name
    $('#searchPackage').on('keyup', function() {
        table.column(1).search(this.value).draw();
    });

    // Filter by Payment Method
    $('#filterPayment').on('change', function() {
        var paymentMethod = this.value;
        if (paymentMethod) {
            table.column(5).search(paymentMethod, true, false).draw();
        } else {
            table.column(5).search('').draw();
        }
    });

    // Clear all filters
    $('#clearFilters').on('click', function() {
        $('#searchSeller').val('');
        $('#searchStore').val('');
        $('#searchPackage').val('');
        $('#filterPayment').val('');

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

    // View purchase details
    $('.view-purchase-btn').on('click', function() {
        let purchaseId = $(this).data('id');
        let packageName = $(this).data('package');
        let sellerName = $(this).data('seller');
        let amount = $(this).data('amount');

        // Set modal title
        $('#viewPurchaseModal .modal-title').html(`Purchase Details: ${packageName}`);

        // Show modal with loading spinner
        var viewModal = new bootstrap.Modal(document.getElementById('viewPurchaseModal'));
        viewModal.show();

        // Load purchase details via AJAX (placeholder)
        setTimeout(() => {
            $('#purchaseDetailsContent').html(`
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="bi bi-box-seam me-2"></i>Package Information</h6>
                        <div class="mb-3">
                            <strong>Package:</strong> ${packageName}<br>
                            <strong>Seller:</strong> ${sellerName}<br>
                            <strong>Amount:</strong> ${amount}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="bi bi-receipt me-2"></i>Payment Details</h6>
                        <div class="mb-3">
                            <strong>Date:</strong> ${new Date().toLocaleDateString()}<br>
                            <strong>Status:</strong> <span class="badge bg-success">Completed</span>
                        </div>
                    </div>
                </div>
            `);
        }, 500);
    });

    // Extend package button
    $('.extend-package-btn').on('click', function() {
        let purchaseId = $(this).data('id');
        let sellerName = $(this).data('seller');

        // Set modal title
        $('#extendPackageModal .modal-title').html(`Extend Package for ${sellerName}`);

        // Show modal with loading spinner
        var extendModal = new bootstrap.Modal(document.getElementById('extendPackageModal'));
        extendModal.show();

        // Load extend package form via AJAX (placeholder)
        setTimeout(() => {
            $('#extendPackageContent').html(`
                <div class="mb-3">
                    <label class="form-label">Extension Period (Days)</label>
                    <select name="extension_days" class="form-control">
                        <option value="30">30 days</option>
                        <option value="60">60 days</option>
                        <option value="90">90 days</option>
                        <option value="180">180 days</option>
                        <option value="365">365 days</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Additional Amount ($)</label>
                    <input type="number" step="0.01" name="additional_amount" class="form-control" value="0.00">
                </div>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    This will extend the package validity period. The seller will be notified.
                </div>
            `);

            // Set form action
            $('#extendPackageForm').attr('action', '/admin/vendor-packages/extend/' + purchaseId);
        }, 500);
    });

    // Print invoice button
    $('#printInvoiceBtn').on('click', function() {
        // Print current modal content
        var printContent = $('#purchaseDetailsContent').html();
        var originalContent = document.body.innerHTML;

        document.body.innerHTML = `
            <div class="container mt-4">
                <h4 class="mb-4">Invoice - Package Purchase</h4>
                ${printContent}
                <hr>
                <div class="text-center mt-4">
                    <p>Generated on: ${new Date().toLocaleDateString()}</p>
                    <p>Thank you for your business!</p>
                </div>
            </div>
        `;

        window.print();
        document.body.innerHTML = originalContent;
        location.reload();
    });

    // Make rows clickable for better UX
    $('#sellerPackagesTable tbody').on('click', 'tr', function(e) {
        // Don't trigger if clicking on action buttons
        if (!$(e.target).closest('.action-buttons').length) {
            $(this).find('.view-purchase-btn').click();
        }
    });

    // Style rows on hover
    $('#sellerPackagesTable tbody tr').css('cursor', 'pointer');
});
</script>
@endsection