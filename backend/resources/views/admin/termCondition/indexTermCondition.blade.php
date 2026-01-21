@extends('layouts.app')

@section('head')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<!-- Buttons for Excel/PDF Export -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<!-- CKEditor 5 Classic -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

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
    #termsTable thead th {
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

    /* CKEditor height */
    .ck-editor__editable_inline {
        min-height: 250px;
    }

    /* Description column width */
    .description-col {
        max-width: 400px;
        word-wrap: break-word;
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

        .card-header-custom h4 {
            font-size: 1.1rem;
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

        textarea {
            min-height: 200px;
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

        small.text-danger {
            font-size: 0.8rem;
        }

        textarea {
            min-height: 150px;
        }
    }

    @media (max-width: 576px) {
        textarea {
            min-height: 120px;
        }

        .modal-title {
            font-size: 1rem;
        }

        .btn-success i, .btn-secondary i {
            margin-right: 0.25rem !important;
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

        textarea {
            min-height: 100px;
        }

        .form-control {
            padding: 0.375rem 0.5rem;
            font-size: 0.85rem;
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
                <i class="bi bi-file-text text-white fs-3 me-3"></i>
                <h4 class="mb-0 text-white">Terms & Conditions Management</h4>
            </div>
        </div>

        <!-- Buttons on Right -->
        <div class="col-12 col-md-6">
            <div class="d-flex flex-wrap justify-content-center justify-content-md-end align-items-center gap-2">
                <div class="d-flex gap-2">
                    <button id="exportExcel" class="btn btn-success btn-export">
                        <i class="bi bi-file-earmark-excel me-1"></i>
                        <span class="d-none d-sm-inline">Excel</span>
                    </button>
                    <button id="exportPDF" class="btn btn-danger btn-export">
                        <i class="bi bi-file-earmark-pdf me-1"></i>
                        <span class="d-none d-sm-inline">PDF</span>
                    </button>
                </div>
                <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addTermModal">
                    <i class="bi bi-plus-circle me-1 me-md-2"></i>
                    <span class="d-none d-sm-inline">Add Terms</span>
                    <span class="d-inline d-sm-none">Add</span>
                </button>
            </div>
        </div>
    </div>
</div>

        <!-- Card Body with Filter Section -->
        <div class="card-body">
            <!-- Filter Card -->
            <div class="filter-card mb-4">
                <div style="display: flex; gap: 540px; margin-top: -6px;">
                    <h6 class="mb-3 text-primary"><i class="bi bi-funnel me-2"></i>Filter Options</h6>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Title</label>
                        <input type="text" id="filterTitle" class="form-control filter-input" placeholder="Search by title...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Start Date</label>
                        <input type="date" id="filterStartDate" class="form-control filter-input">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">End Date</label>
                        <input type="date" id="filterEndDate" class="form-control filter-input">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 d-flex justify-content-between">
                        <div>
                            <button id="clearFilters" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-x-circle me-1"></i>Clear Filters
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DataTable -->
            <div class="table-responsive">
                <table id="termsTable" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th width="50">#</th>
                            <th width="200">Title</th>
                            <th class="description-col">Description</th>
                            <th width="150">Created At</th>
                            <th width="120" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-semibold">{{ $item->title }}</td>
                            <td class="description-col">{!! Str::limit(strip_tags($item->description), 150) !!}</td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group" style="gap: 6px;">
                                    <button class="btn btn-sm btn-outline-warning"
                                        onclick="openEditModal(
                                            {{ $item->id }},
                                            '{{ addslashes($item->title) }}',
                                            `{{ addslashes($item->description) }}`
                                        )"
                                        title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <form id="delete-form-{{ $item->id }}"
                                          action="{{ route('deleteTerm', $item->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                onclick="confirmDelete({{ $item->id }})"
                                                title="Delete">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No terms & conditions found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Terms & Conditions Modal -->
<div class="modal fade" id="addTermModal" tabindex="-1" aria-labelledby="addTermModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <form action="{{ route('storeTerm') }}" method="POST">
          @csrf
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="addTermModalLabel">Add Terms & Conditions</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
              <div class="mb-3">
                  <label class="form-label fw-semibold">Title</label>
                  <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                  @error('title')<small class="text-danger">{{ $message }}</small>@enderror
              </div>
              <div class="mb-3">
                  <label class="form-label fw-semibold">Description</label>
                  <textarea name="description" class="form-control" id="addDescription" rows="6"></textarea>
                  @error('description')<small class="text-danger">{{ $message }}</small>@enderror
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success">
                  <i class="bi bi-check-circle me-1"></i>Save
              </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit Terms & Conditions Modal -->
  <div class="modal fade" id="editTermModal" tabindex="-1" aria-labelledby="editTermModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="editTermForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editTermModalLabel">Edit Terms & Conditions</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Title</label>
                        <input type="text" name="title" id="editTitle" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" id="editDescription" class="form-control" rows="6"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i>Update
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
let addEditor, editEditor;

$(document).ready(function () {
    // Initialize CKEditor for Add modal
    ClassicEditor.create(document.querySelector('#addDescription'))
        .then(editor => { addEditor = editor; })
        .catch(error => console.error(error));

    // Initialize CKEditor for Edit modal
    ClassicEditor.create(document.querySelector('#editDescription'))
        .then(editor => { editEditor = editor; })
        .catch(error => console.error(error));

    // Initialize DataTable with Export Buttons
    var table = $('#termsTable').DataTable({
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
                    columns: [0, 1, 3] // Export #, Title, and Created At columns
                },
                title: 'Terms_Conditions_Export_' + new Date().toISOString().slice(0,10)
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="bi bi-file-earmark-pdf me-1"></i>PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: {
                    columns: [0, 1, 3] // Export #, Title, and Created At columns
                },
                title: 'Terms_Conditions_Export_' + new Date().toISOString().slice(0,10),
                customize: function (doc) {
                    doc.content[1].table.widths = ['10%', '40%', '50%'];
                }
            }
        ],
        initComplete: function() {
            // Add export buttons to the custom export section
            $('.export-buttons').append($('.dt-buttons').html());
            $('.dt-buttons').remove();
        }
    });

    // Filter by Title
    $('#filterTitle').on('keyup', function() {
        table.column(1).search(this.value).draw();
    });

    // Filter by Date Range
    $('#filterStartDate, #filterEndDate').on('change', function() {
        var startDate = $('#filterStartDate').val();
        var endDate = $('#filterEndDate').val();

        if (startDate || endDate) {
            // Custom filtering logic for date range
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var dateColumn = data[3]; // Created At column

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
            table.column(3).search('').draw();
        }
    });

    // Clear all filters
    $('#clearFilters').on('click', function() {
        $('#filterTitle').val('');
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

    // Clean up CKEditor instances when modal is closed
    $('#addTermModal').on('hidden.bs.modal', function () {
        if (addEditor) {
            addEditor.setData('');
        }
    });

    $('#editTermModal').on('hidden.bs.modal', function () {
        // Don't clear edit editor as it will be set when opening modal
    });
});

// Open Edit Modal
function openEditModal(id, title, description) {
    let url = '{{ route("updateTerm", ":id") }}';
    url = url.replace(':id', id);
    $('#editTermForm').attr('action', url);

    $('#editTitle').val(title);

    // Set content in CKEditor
    if (editEditor) {
        editEditor.setData(description);
    }

    var editModal = new bootstrap.Modal(document.getElementById('editTermModal'));
    editModal.show();
}

// Confirm Delete
function confirmDelete(id){
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#delete-form-' + id).submit();
        }
    });
}
</script>
@endsection