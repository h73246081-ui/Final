@extends('layouts.app')

@section('head')
    <!-- Select2 CSS for search (optional) -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Card polish */
        .card {
            border-radius: 12px;
            border: none;
        }
        .card-header {
            border-radius: 12px 12px 0 0;
            padding: 14px 20px;
        }
        .form-label {
            font-weight: 600;
            color: #374151;
        }
        .permission-checkbox {
            margin-right: 10px;
        }
        .select-all-btn {
            margin-bottom: 10px;
        }
        .search-permission {
            margin-bottom: 15px;
        }

        /* Full-width centered card */
        .card-container {
            margin: 30px auto; /* Top/Bottom spacing */
            max-width: 900px; /* Card max width */
            width: 100%; /* Take full width up to max-width */
            padding: 0 15px; /* Optional small padding for mobile */
        }
    </style>
@endsection
<div style="margin-top: 10px;
    margin-left: 235px;">
    @section('content')
    <div class="card-container" style="max-width: 1084px;">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <div style="display: flex;gap: 680px;">
                    <h5 class="mb-0">Assign Permissions to Role</h5>
                    <a href="{{route('role.index')}}" class="btn btn-secondary" style="text-decoration: none">Back</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('assignPermissions', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Role Name (read-only) -->
                    <div class="mb-3">
                        <label class="form-label">Role Name</label>
                        <input type="text" class="form-control" value="{{ $role->name }}" readonly>
                    </div>

                    <!-- Search bar -->
                    <div class="mb-3">
                        <input type="text" class="form-control search-permission" id="searchPermission" placeholder="Search permission...">
                    </div>

                    <!-- Select All / Deselect All -->
                    <button type="button" class="btn btn-sm btn-secondary select-all-btn" id="selectAllBtn">Select All</button>

                    <!-- Permissions List -->
                    <div class="row" id="permissionsList">
                        @foreach($permissions as $permission)
                            <div class="col-md-6 mb-2 permission-item">
                                <div class="form-check">
                                    <input type="checkbox"
                                           name="permissions[]"
                                           value="{{ $permission->id }}"
                                           class="form-check-input permission-checkbox"
                                           id="perm_{{ $permission->id }}"
                                           {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-success px-5">Assign</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    @endsection
</div>


@section('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {

    // Select / Deselect All Button
    $('#selectAllBtn').click(function() {
        let allChecked = $('.permission-checkbox:checked').length === $('.permission-checkbox').length;
        $('.permission-checkbox').prop('checked', !allChecked);
        $(this).text(allChecked ? 'Select All' : 'Deselect All');
    });

    // Search Permissions
    $('#searchPermission').on('keyup', function() {
        let searchText = $(this).val().toLowerCase();
        $('.permission-item').each(function() {
            let text = $(this).text().toLowerCase();
            $(this).toggle(text.includes(searchText));
        });
    });

});
</script>
@endsection
