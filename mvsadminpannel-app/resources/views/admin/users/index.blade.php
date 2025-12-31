@extends('layouts.app')
@section('head')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endsection
@section('content')
<div class="container p-4">
    <div class="row justify-content-center">
        <div class="col-md-12">

            {{-- Session Messages --}}
             {{-- @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
               {{ session('success') }}
                </div>
            @endif --}}

            {{-- Session Messages --}}
            {{-- @if(session('warning'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('warning') }}
                </div>
            @endif --}}

            {{-- <div class="card shadow-sm border-0">
                    <h6 class="mb-0 card-header"><i class="fa fa-users me-2"></i> All Users</h6s>
                <div class="card-header bg-light text-primary d-flex justify-content-end align-items-center">
                    <a href="" class="btn btn-md btn-success">
                        <i class="fa fa-plus mr-2"></i> Add User
                    </a>               
                </div> --}}

        <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Users</h5>
            {{-- <a href="" class="btn btn-light btn-sm ms-auto">
                <i class="bi bi-plus-circle"></i> Add New User
            </a> --}}
        </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id = "userTable" class="table table-bordered table-hover align-middle p-1">
                            <thead class="table-thead">
                                <tr>
                                    <th>#</th>
                                    <th>Profile</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Country</th>
                                    <th>Role</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if($user->image)
                                                <img src="{{ asset('storage/'.$user->image) }}" 
                                                     alt="Profile" 
                                                     class="rounded-circle" 
                                                     width="40" height="40">
                                            @else
                                                <img src="{{asset('assets/img/tijaar2.jpeg')}}" 
                                                     class="rounded-circle" 
                                                     alt="Default2"
                                                     width="40" height="40">
                                            @endif
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone ?? '03704587890' }}</td>
                                        <td>{{$user->country ?? 'Pakistan'}}</td>
                                        <td>
                                            <span class="badge bg-primary">{{ $user->role->name ?? 'N/A' }}</span>
                                        </td>
                                        <td class="text-center">       
                                          <a href="{{route('user.delete', $user->id)}}" 
                                            onclick="return confirm('Are you sure you want to delete this user?')" 
                                            class="btn btn-sm btn-danger">
                                             <i class="bi bi-trash3"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No users found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    {{-- <div class="d-flex justify-content-center mt-3">
                        {{ $users->links('pagination::bootstrap-5') }}
                    </div> --}}
                </div>
            </div>

        </div>
    </div>
</div> 

 @endsection

 @section('scripts')
    <!-- jQuery must come first -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#userTable').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    search: "🔍 Search:",
                    lengthMenu: "Show _MENU_ entries",
                    zeroRecords: "No matching records found",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        previous: "←",
                        next: "→"
                    }
                }
            });
        });
    </script>
@endsection