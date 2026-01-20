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
    #ordersTable thead th {
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

    /* Payment method badges */
    .payment-badge {
        padding: 4px 12px;
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

    /* Amount styling */
    .amount {
        font-weight: bold;
        color: #198754;
    }

    /* Customer info styling */
    .customer-info {
        display: flex;
        flex-direction: column;
    }

    .customer-name {
        font-weight: 600;
        color: #2c3e50;
    }

    .customer-contact a {
        text-decoration: none;
        color: #495057;
        transition: color 0.2s;
    }

    .customer-contact a:hover {
        color: #0d6efd;
    }

    /* Order status styling */
    .order-status {
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 0.85em;
        font-weight: 500;
    }

    .status-pending {
        background-color: rgba(255, 193, 7, 0.1);s
        border: 1px solid #ffc107;
    }

    .status-processing {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
        border: 1px solid #0d6efd;
    }

    .status-completed {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border: 1px solid #28a745;
    }

    .status-cancelled {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border: 1px solid #dc3545;
    }

    /* Action buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    /* Address styling */
    .address-cell {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Responsive table */
    .table-responsive {
        overflow-x: auto;
    }

    /* Date styling */
    .date-cell {
        min-width: 100px;
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <!-- Main Card containing everything -->
    <div class="card main-card" style="margin-top: -30px;">
        <!-- Card Header with Title -->
       <!-- Card Header with Title -->
<div class="card-header card-header-custom">
    <div class="row align-items-center">
        <!-- Title on Left -->
        <div class="col-12 col-md-6 mb-3 mb-md-0">
            <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                <i class="bi bi-cart-check text-white fs-3 me-3"></i>
                <h4 class="mb-0 text-white">Orders Management</h4>
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
                    <div class="text-muted">
                        <small><i class="bi bi-receipt me-1"></i>{{ $order->count() }} orders found</small>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Customer Name</label>
                        <input type="text" id="searchCustomer" class="form-control filter-input" placeholder="Search by name...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="text" id="searchEmail" class="form-control filter-input" placeholder="Search email...">
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
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Date Range</label>
                        <input type="date" id="filterDate" class="form-control filter-input">
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
            @if($order->count() > 0)
                <div class="table-responsive">
                    <table id="ordersTable" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>Customer</th>
                                <th>Contact</th>
                                <th>Address</th>
                                <th>Payment Method</th>
                                <th>Payment Status</th>
                                <th>Total Amount</th>
                                <th>Date</th>
                                <th>Deliverd Status</th>
                                <th width="120" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order as $key => $item)
                            @php
                                // Determine payment method class
                                $paymentMethod = strtolower($item->payment_method);
                                $paymentClass = '';
                                if (str_contains($paymentMethod, 'cash')) $paymentClass = 'payment-cash';
                                elseif (str_contains($paymentMethod, 'card')) $paymentClass = 'payment-card';
                                elseif (str_contains($paymentMethod, 'online') || str_contains($paymentMethod, 'digital')) $paymentClass = 'payment-online';
                                else $paymentClass = 'payment-cash';

                                // Determine order status (you can add status field to your orders table)
                                $status = 'pending'; // Default, you can change this based on your data
                                $statusClass = 'status-' . $status;
                            @endphp
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <div class="customer-info">
                                        <div class="customer-name">{{ $item->first_name }} {{ $item->last_name ?? '' }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="customer-contact">
                                        @if($item->email)
                                                <i class="bi bi-envelope me-1"></i>{{ $item->email }}
                                        @endif
                                        @if($item->phone)
                                                <i class="bi bi-telephone me-1"></i>{{ $item->phone }}
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="address-cell" title="{{ $item->address }}">
                                        {{ $item->address }}
                                    </div>
                                </td>
                                <td>
                                    <span class="payment-badge {{ $paymentClass }}">
                                        {{ ucfirst($item->payment_method) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="payment-badge">
                                        <span class="badge badge-status" style="background:#48a734;">{{$item->payment_status}}</span>
                                    </span>
                                </td>
                                <td>
                                    <div class="amount">${{ number_format($item->total_bill, 2) }}</div>
                                    <small class="text-muted">Total Bill</small>
                                </td>
                                <td class="date-cell">
                                    <div class="small">{{ $item->created_at->format('d M, Y') }}</div>
                                    <div class="text-muted">{{ $item->created_at->format('h:i A') }}</div>
                                    <div class="text-muted small">{{ $item->created_at->diffForHumans() }}</div>
                                </td>
                                <td>
                                    <span class="order-status {{ $statusClass }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <a href="{{ route('detailOrder', $item->id) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           title="View Order Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center text-muted py-5">
                    <i class="bi bi-cart-x fs-1 d-block mb-3"></i>
                    <h5>No Orders Found</h5>
                    <p class="mb-0">No orders have been placed yet.</p>
                </div>
            @endif
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
    var table = $('#ordersTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        order: [[6, 'desc']], // Sort by date descending by default
        dom: '<"row"<"col-md-6"l><"col-md-6"f>><"row"<"col-md-12"tr>><"row"<"col-md-5"i><"col-md-7"p>>',
        language: {
            search: "🔍 Quick Search:",
            lengthMenu: "Show _MENU_ entries",
            zeroRecords: "No matching orders found",
            info: "Showing _START_ to _END_ of _TOTAL_ orders",
            infoEmpty: "No orders available",
            infoFiltered: "(filtered from _MAX_ total orders)",
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
                title: 'Orders_Export_' + new Date().toISOString().slice(0,10)
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="bi bi-file-earmark-pdf me-1"></i>PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                },
                title: 'Orders_Export_' + new Date().toISOString().slice(0,10),
                customize: function (doc) {
                    doc.content[1].table.widths = ['5%', '15%', '15%', '15%', '12%', '12%', '12%', '8%', '6%'];
                }
            }
        ],
        initComplete: function() {
            // Add export buttons to the export section
            $('.export-buttons').html($('.dt-buttons'));
        }
    });

    // Filter by Customer Name
    $('#searchCustomer').on('keyup', function() {
        table.column(1).search(this.value).draw();
    });

    // Filter by Email
    $('#searchEmail').on('keyup', function() {
        table.column(2).search(this.value).draw();
    });

    // Filter by Payment Method
    $('#filterPayment').on('change', function() {
        var paymentMethod = this.value;
        if (paymentMethod) {
            table.column(4).search(paymentMethod, true, false).draw();
        } else {
            table.column(4).search('').draw();
        }
    });

    // Filter by Date
    $('#filterDate').on('change', function() {
        var selectedDate = this.value;
        if (selectedDate) {
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var rowDate = new Date(data[6]).toDateString();
                    var filterDate = new Date(selectedDate).toDateString();
                    return rowDate === filterDate;
                }
            );
            table.draw();
            $.fn.dataTable.ext.search.pop();
        } else {
            table.column(6).search('').draw();
        }
    });

    // Clear all filters
    $('#clearFilters').on('click', function() {
        $('#searchCustomer').val('');
        $('#searchEmail').val('');
        $('#filterPayment').val('');
        $('#filterDate').val('');

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




    // Make rows clickable for better UX
    $('#ordersTable tbody').on('click', 'tr', function(e) {
        // Don't trigger if clicking on action buttons
        if (!$(e.target).closest('.action-buttons').length) {
            window.location.href = $(this).find('.btn-outline-primary').attr('href');
        }
    });

    // Style rows on hover
    $('#ordersTable tbody tr').css('cursor', 'pointer');
});
</script>
@endsection