@extends('layouts.app')

@section('head')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<!-- Buttons for Excel/PDF Export -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<!-- SweetAlert CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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
    #contactTable thead th {
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

    /* Badge styling */
    .badge-pending {
        background-color: #ffc107;
        color: #000;
    }

    .badge-replied {
        background-color: #198754;
        color: #fff;
    }

    /* Message column width */
    .message-col {
        max-width: 200px;
        word-wrap: break-word;
    }

    /* Action buttons */
    .btn-action {
        padding: 4px 8px;
        font-size: 0.875rem;
    }
</style>
<style>
    /* Make modal responsive */
    @media (max-width: 992px) {
        .modal-dialog.modal-lg {
            max-width: 90%;
            margin: 30px auto;
        }

        .modal-header, .modal-body, .modal-footer {
            padding: 1rem !important;
        }

        .modal-title {
            font-size: 1.1rem;
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

        textarea {
            min-height: 80px;
        }

        textarea[rows="3"] {
            min-height: 60px;
        }

        textarea[rows="4"] {
            min-height: 80px;
        }
    }

    @media (max-width: 576px) {
        .col-md-6 {
            width: 100%;
        }

        textarea[rows="3"] {
            min-height: 50px;
        }

        textarea[rows="4"] {
            min-height: 70px;
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

        textarea[rows="3"] {
            min-height: 40px;
        }

        textarea[rows="4"] {
            min-height: 60px;
        }
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
                        <i class="bi bi-envelope text-white fs-3 me-3"></i>
                        <h4 class="mb-0 text-white">Contact Messages Management</h4>
                    </div>
                </div>

                <!-- Buttons on Right -->
                <div class="col-12 col-md-6">
                    <div class="d-flex flex-wrap justify-content-center justify-content-md-end align-items-center gap-2">
                        <button id="exportExcel" class="btn btn-light btn-export">
                            <i class="bi bi-file-earmark-excel me-1"></i>
                            <span class="d-none d-sm-inline">Excel</span>
                        </button>
                        <button id="exportPDF" class="btn btn-light btn-export">
                            <i class="bi bi-file-earmark-pdf me-1"></i>
                            <span class="d-none d-sm-inline">PDF</span>
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
                    min-width: 80px;
                }

                .card-header-custom h4 {
                    font-size: 1.1rem;
                }
            }

            @media (max-width: 400px) {
                .d-flex.flex-wrap {
                    flex-direction: column;
                    width: 100%;
                    gap: 8px !important;
                }

                .btn-export {
                    width: 100%;
                    justify-content: center;
                }
            }
        </style>

        <!-- Card Body with Filter Section -->
        <div class="card-body">
            <!-- Filter Card -->
            <div class="filter-card mb-4">
                <div style="display: flex; gap: 670px; margin-top: -6px;">
                    <h6 class="mb-3 text-primary"><i class="bi bi-funnel me-2"></i>Filter Options</h6>
                </div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Name</label>
                        <input type="text" id="filterName" class="form-control filter-input" placeholder="Search by name...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="text" id="filterEmail" class="form-control filter-input" placeholder="Search by email...">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Status</label>
                        <select id="filterStatus" class="form-control filter-input">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="replied">Replied</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Start Date</label>
                        <input type="date" id="filterStartDate" class="form-control filter-input">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">End Date</label>
                        <input type="date" id="filterEndDate" class="form-control filter-input">
                    </div>
                </div>
                <button id="clearFilters" class="btn btn-outline-secondary btn-sm mt-4">
                    <i class="bi bi-x-circle me-1"></i>Clear Filters
                </button>
            </div>

            <!-- DataTable -->
            <div class="table-responsive">
                <table id="contactTable" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th width="50">#</th>
                            <th width="150">Name</th>
                            <th width="200">Email</th>
                            <th class="message-col">Message</th>
                            <th width="120">Date</th>
                            <th width="100">Status</th>
                            <th width="150" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contacts as $index => $contact)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-semibold">{{ $contact->name }}</td>
                            <td>
                                <a href="mailto:{{ $contact->email }}" class="text-decoration-none">
                                    {{ $contact->email }}
                                </a>
                            </td>
                            <td class="message-col">{{ Str::limit($contact->message, 80) }}</td>
                            <td>{{ $contact->created_at->format('d M Y') }}</td>
                            <td>
                                @if($contact->status === 'replied')
                                    <span class="badge bg-success">Replied</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group" style="gap: 6px;">
                                    @if($contact->status !== 'replied')
                                    <button class="btn btn-sm btn-outline-primary"
                                        onclick="openReplyModal({{ $contact->id }}, '{{ addslashes($contact->email) }}', `{{ addslashes($contact->message) }}`)"
                                        title="Reply">
                                        <i class="bi bi-reply me-1"></i>Reply
                                    </button>
                                    @endif

                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="confirmDelete({{ $contact->id }})"
                                            title="Delete">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No contact messages found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Reply Modal -->
<div class="modal fade" id="replyModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <form id="replyForm" method="POST">
          @csrf
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title"><i class="bi bi-reply me-2"></i>Reply to Contact</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-12 col-md-6 mb-3">
                      <div>
                          <label class="form-label fw-semibold">Name</label>
                          <input type="text" id="replyName" class="form-control" disabled>
                      </div>
                  </div>
                  <div class="col-12 col-md-6 mb-3">
                      <div>
                          <label class="form-label fw-semibold">Email</label>
                          <input type="email" id="replyEmail" class="form-control" disabled>
                      </div>
                  </div>
              </div>
              <div class="mb-3">
                  <label class="form-label fw-semibold">Original Message</label>
                  <textarea id="messageReceived" class="form-control" rows="3" disabled></textarea>
              </div>
              <div class="mb-3">
                  <label class="form-label fw-semibold">Your Reply</label>
                  <textarea name="reply" class="form-control" rows="4" placeholder="Type your reply here..." required></textarea>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              Cancel
            </button>
            <button type="submit" class="btn btn-success">
              <i class="bi bi-send me-1"></i> Send Reply
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
<!-- SweetAlert for delete confirmation -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {
    // Initialize DataTable with Export Buttons
    var table = $('#contactTable').DataTable({
        responsive: true,
        autoWidth: false,
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
                    columns: [0, 1, 2, 4, 5] // Export #, Name, Email, Date, Status
                },
                title: 'Contact_Messages_Export_' + new Date().toISOString().slice(0,10)
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="bi bi-file-earmark-pdf me-1"></i>PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 4, 5] // Export #, Name, Email, Date, Status
                },
                title: 'Contact_Messages_Export_' + new Date().toISOString().slice(0,10),
                customize: function (doc) {
                    doc.content[1].table.widths = ['8%', '20%', '25%', '22%', '15%', '10%'];
                }
            }
        ],
        initComplete: function() {
            // Add export buttons to the custom export section
            $('.export-buttons').append($('.dt-buttons').html());
            $('.dt-buttons').remove();
        }
    });

    // Filter by Name
    $('#filterName').on('keyup', function() {
        table.column(1).search(this.value).draw();
    });

    // Filter by Email
    $('#filterEmail').on('keyup', function() {
        table.column(2).search(this.value).draw();
    });

    // Filter by Status
    $('#filterStatus').on('change', function() {
        var status = this.value;
        if (status === '') {
            table.column(5).search('').draw();
        } else if (status === 'pending') {
            table.column(5).search('^Pending$', true, false).draw();
        } else if (status === 'replied') {
            table.column(5).search('^Replied$', true, false).draw();
        }
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

                    // Parse date from format "d M Y"
                    var dateParts = dateColumn.split(' ');
                    var monthNames = {
                        'Jan': 0, 'Feb': 1, 'Mar': 2, 'Apr': 3, 'May': 4, 'Jun': 5,
                        'Jul': 6, 'Aug': 7, 'Sep': 8, 'Oct': 9, 'Nov': 10, 'Dec': 11
                    };

                    var rowDate = new Date(
                        dateParts[2], // Year
                        monthNames[dateParts[1]], // Month
                        dateParts[0] // Day
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
        $('#filterName').val('');
        $('#filterEmail').val('');
        $('#filterStatus').val('');
        $('#filterStartDate').val('');
        $('#filterEndDate').val('');

        table.columns().search('').draw();
        table.draw();
    });

    // Export Excel button click
    $('#exportExcel').on('click', function() {
        table.button('.buttons-excel').trigger();
    });

    // Export PDF button click
    $('#exportPDF').on('click', function() {
        table.button('.buttons-pdf').trigger();
    });
});

// Open Reply Modal
function openReplyModal(id, email, messageReceived) {
    let url = '{{ route("contact.reply", ":id") }}';
    url = url.replace(':id', id);
    $('#replyForm').attr('action', url);

    $('#replyEmail').val(email);
    $('#messageReceived').val(messageReceived);

    // Try to extract name from email
    var name = email.split('@')[0];
    $('#replyName').val(name.charAt(0).toUpperCase() + name.slice(1));

    var replyModal = new bootstrap.Modal(document.getElementById('replyModal'));
    replyModal.show();
}

// Confirm Delete
function confirmDelete(id){
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to recover this contact message!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Create a form and submit it
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("cms.contact.delete", ":id") }}'.replace(':id', id);
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
        }
    });
}
</script>
@endsection