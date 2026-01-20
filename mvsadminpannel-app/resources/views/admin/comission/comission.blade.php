@extends('layouts.app')

@section('head')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<style>
    /* Card polish */
    .card {
        border: none;
        border-radius: 12px;
    }

    .card-header {
        border-radius: 12px 12px 0 0;
        padding: 14px 20px;
    }

    /* Label */
    .form-label {
        font-weight: 600;
        color: #374151;
    }

    /* Select2 height fix */
    .select2-container .select2-selection--single {
        height: 44px;
        display: flex;
        align-items: center;
        border-radius: 8px;
        border: 1px solid #d1d5db;
    }

    .select2-selection__rendered {
        padding-left: 12px !important;
    }

    .select2-selection__arrow {
        height: 44px !important;
    }

    /* Focus effect */
    .select2-container--default.select2-container--focus
    .select2-selection--single {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.15rem rgba(13,110,253,.25);
    }

    /* Button polish */
    .btn-success {
        border-radius: 8px;
        font-weight: 600;
    }
    </style>

<div class="container" style="width: 750px;">
    <div class="row justify-content-center">
        <!-- Centered and wider card -->
        <div class="col-lg-8 col-md-10">
            <div class="card shadow mt-5">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Set Comission</h5>
                </div>
                <div class="card-body" style="height: 200px;">
                    <form action="{{route('updateCommission')}}" method="POST">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label class="form-label">Commission</label>

                            <div class="input-group">
                                <input type="number"
                                       class="form-control"
                                       step="0.01"
                                       name="comission"
                                       value="{{ $comission->comission }}"
                                       min="0"
                                       max="100">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>


                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-success px-3"  style="margin-top: 20px;">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <!-- jQuery (required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
{{--
    <script>
        $(document).ready(function() {
            // Initialize Select2 on category dropdown
            $('#category').select2({
                placeholder: "Select a category",
                allowClear: true,
                width: '100%'
            });
        });
    </script> --}}
@endsection
