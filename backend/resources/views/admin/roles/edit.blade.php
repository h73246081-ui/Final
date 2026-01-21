@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

      @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

            <!-- Card for Create Role -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light text-danger">
                    <h5 class="mb-0"><i class="fa fa-plus-circle mr-2"></i> Update Role</h5>
                </div>


                <div class="card-body">
                    <form action="{{route('roles.update.role', $role->id)}}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="name" class="mb-2">Role Name</label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{$role->name}}"
                                   class="form-control @error('name') is-invalid @enderror" 
                                   placeholder="Enter role name (e.g. Admin, User)" 
                                   >

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group d-flex justify-content-end">
                            <button type="submit" class="btn btn-md btn-primary mt-3">
                                <i class="fa fa-save mr-1"></i> Update Role
                            </button>
                        </div>
                    </form>
                </div>
            </div>

           

        </div>
    </div>
</div>
@endsection
