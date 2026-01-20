
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
    #subscribersTable thead th {
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

    /* Email styling */
    .email-cell {
        font-weight: 500;
        color: #2c3e50;
    }

    .email-domain {
        color: #6c757d;
        font-weight: normal;
    }

    /* Subscriber badge */
    .subscriber-badge {
        background: linear-gradient(135deg, #20c997 0%, #198754 100%);
        color: white;
        padding: 3px 12px;
        border-radius: 15px;
        font-size: 0.85em;
        font-weight: 500;
    }

    /* Date styling */
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

    /* Status indicators */
    .status-indicator {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
    }

    .status-active {
        background-color: #28a745;
        box-shadow: 0 0 0 2px rgba(40, 167, 69, 0.2);
    }

    .status-inactive {
        background-color: #6c757d;
        box-shadow: 0 0 0 2px rgba(108, 117, 125, 0.2);
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <!-- Main Card containing everything -->
    <div class="card main-card" style="margin-top: -30px;">
        <!-- Card Header with Title -->
<div class="card-header card-header-custom">
    <div class="row align-items-center">
        <!-- Title on Left -->
        <div class="col-12 col-md-6 mb-3 mb-md-0">
            <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                <i class="bi bi-people text-white fs-3 me-3"></i>
                <h4 class="mb-0 text-white">Subscribers Management</h4>
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
                        <small><i class="bi bi-envelope me-1"></i>{{ $sub->count() }} subscribers</small>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Search Email</label>
                        <input type="text" id="searchEmail" class="form-control filter-input" placeholder="Search by email...">
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
            @if($sub->count() > 0)
                <div class="table-responsive">
                    <table id="subscribersTable" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>Email Address</th>
                                <th>Subscription Date</th>
                                <th width="120" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sub as $index => $subscriber)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <small class="text-muted">
                                        <i class="bi bi-globe me-1"></i>{{ $subscriber->email }}
                                    </small>
                                </td>
                                <td class="date-cell">
                                    <div class="small">{{ $subscriber->created_at->format('d M, Y') }}</div>
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        {{-- <button class="btn btn-sm btn-outline-primary view-subscriber-btn"
                                                data-id="{{ $subscriber->id }}"
                                                data-email="{{ $subscriber->email }}"
                                                data-date="{{ $subscriber->created_at->format('d M, Y') }}"
                                                title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-info send-email-btn"
                                                data-id="{{ $subscriber->id }}"
                                                data-email="{{ $subscriber->email }}"
                                                title="Send Email">
                                            <i class="bi bi-envelope"></i>
                                        </button> --}}
                                        <form action="{{ route('deleteSub', $subscriber->id) }}"
                                              method="POST"
                                              class="d-inline delete-subscriber-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete-subscriber"
                                                    data-email="{{ $subscriber->email }}"
                                                    title="Delete Subscriber">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-people fs-1 text-muted mb-3"></i>
                    <h5 class="text-muted">No Subscribers Found</h5>
                    <p class="text-muted">No one has subscribed to your newsletter yet.</p>
                    {{-- <button class="btn btn-primary mt-2" onclick="window.location.href='{{ route('marketing.newsletter') }}'">
                        <i class="bi bi-megaphone me-1"></i>Create Newsletter Campaign
                    </button> --}}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- View Subscriber Modal -->
<div class="modal fade" id="viewSubscriberModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Subscriber Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="subscriberDetailsContent">
                <!-- Details will be loaded here via AJAX -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- <!-- Send Email Modal -->
<div class="modal fade" id="sendEmailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="sendEmailForm" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Send Email to Subscriber</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="sendEmailContent">
                        <!-- Content will be loaded via AJAX -->
                        <div class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-send me-1"></i>Send Email
                    </button>
                </div> --}}
            {{-- </form>
        </div>
    </div>
</div> --}}
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
    var table = $('#subscribersTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        order: [[3, 'desc']], // Sort by subscription date descending
        dom: '<"row"<"col-md-6"l><"col-md-6"f>><"row"<"col-md-12"tr>><"row"<"col-md-5"i><"col-md-7"p>>',
        language: {
            search: "🔍 Quick Search:",
            lengthMenu: "Show _MENU_ entries",
            zeroRecords: "No matching subscribers found",
            info: "Showing _START_ to _END_ of _TOTAL_ subscribers",
            infoEmpty: "No subscribers available",
            infoFiltered: "(filtered from _MAX_ total subscribers)",
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
                    columns: [0, 1, 2, 3, 4]
                },
                title: 'Subscribers_Export_' + new Date().toISOString().slice(0,10)
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="bi bi-file-earmark-pdf me-1"></i>PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                },
                title: 'Subscribers_Export_' + new Date().toISOString().slice(0,10),
                customize: function (doc) {
                    doc.content[1].table.widths = ['10%', '20%', '25%', '25%', '10%', '10%'];
                }
            }
        ],
        initComplete: function() {
            // Add export buttons to the export section
            $('.export-buttons').html($('.dt-buttons'));
        }
    });

    // Filter by Email
    $('#searchEmail').on('keyup', function() {
        table.column(2).search(this.value).draw();
    });

    // Filter by Email Domain
    $('#filterDomain').on('change', function() {
        var domain = this.value;
        if (domain) {
            table.column(2).search('@' + domain).draw();
        } else {
            table.column(2).search('').draw();
        }
    });

    // Clear all filters
    $('#clearFilters').on('click', function() {
        $('#searchEmail').val('');
        $('#filterDomain').val('');

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

    // View subscriber details
    $('.view-subscriber-btn').on('click', function() {
        let subscriberId = $(this).data('id');
        let subscriberEmail = $(this).data('email');
        let subscriptionDate = $(this).data('date');

        // Set modal title
        $('#viewSubscriberModal .modal-title').text('Subscriber Details');

        // Show modal with loading spinner
        var viewModal = new bootstrap.Modal(document.getElementById('viewSubscriberModal'));
        viewModal.show();

        // Load subscriber details (simulated with static content)
        setTimeout(() => {
            $('#subscriberDetailsContent').html(`
                <div class="mb-4">
                    <h6><i class="bi bi-envelope me-2"></i>Email Address</h6>
                    <div class="alert alert-primary">
                        <strong>${subscriberEmail}</strong>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="bi bi-calendar me-2"></i>Subscription Info</h6>
                        <div class="mb-3">
                            <strong>Subscribed on:</strong> ${subscriptionDate}<br>
                            <strong>Status:</strong> <span class="badge bg-success">Active</span><br>
                            <strong>ID:</strong> SUB${String(subscriberId).padStart(6, '0')}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="bi bi-bell me-2"></i>Preferences</h6>
                        <div class="mb-3">
                            <strong>Newsletter:</strong> <span class="badge bg-success">Subscribed</span><br>
                            <strong>Promotions:</strong> <span class="badge bg-success">Subscribed</span><br>
                            <strong>Updates:</strong> <span class="badge bg-success">Subscribed</span>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    This subscriber is receiving all newsletter updates.
                </div>
            `);
        }, 500);
    });

    // Send email to subscriber
    $('.send-email-btn').on('click', function() {
        let subscriberId = $(this).data('id');
        let subscriberEmail = $(this).data('email');

        // Set modal title
        $('#sendEmailModal .modal-title').text('Send Email to: ' + subscriberEmail);

        // Show modal with loading spinner
        var emailModal = new bootstrap.Modal(document.getElementById('sendEmailModal'));
        emailModal.show();

        // Load email form
        setTimeout(() => {
            $('#sendEmailContent').html(`
                <div class="mb-3">
                    <label class="form-label">Subject *</label>
                    <input type="text" name="subject" class="form-control" placeholder="Email subject" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Message *</label>
                    <textarea name="message" class="form-control" rows="6" placeholder="Type your message here..." required></textarea>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="send_copy" class="form-check-input" id="sendCopy">
                        <label class="form-check-label" for="sendCopy">Send a copy to myself</label>
                    </div>
                </div>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    This email will be sent to ${subscriberEmail}
                </div>
            `);

            // Set form action
            $('#sendEmailForm').attr('action', '/admin/subscribers/send-email/' + subscriberId);
        }, 500);
    });

    // Delete subscriber confirmation
    $('.btn-delete-subscriber').on('click', function(e) {
        e.preventDefault();
        let form = $(this).closest('.delete-subscriber-form');
        let subscriberEmail = $(this).data('email');

        Swal.fire({
            title: 'Are you sure?',
            html: `You are about to remove <strong>"${subscriberEmail}"</strong> from your subscribers list. This action cannot be undone!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, remove it!',
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
    $('#subscribersTable tbody').on('click', 'tr', function(e) {
        // Don't trigger if clicking on action buttons
        if (!$(e.target).closest('.action-buttons').length) {
            $(this).find('.view-subscriber-btn').click();
        }
    });

    // Style rows on hover
    $('#subscribersTable tbody tr').css('cursor', 'pointer');
});
</script>
@endsection