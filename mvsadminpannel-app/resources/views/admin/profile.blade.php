@extends('layouts.app')

@section('content')
<style>

    .profile-container {
        max-width: 1200px;
        margin: auto;
        padding: 20px;
    }

    .profile-header,
    .profile-card {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,.08);
        margin-bottom: 20px;
    }

    .section-title {
        font-weight: 600;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .profile-image {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: contain;
        border: 3px solid #eee;
        margin-bottom: 10px;
        padding: 10px;
      }

    .btn-submit {
        background: #4a6de5;
        color: #fff;
        border: none;
        padding: 10px;
        border-radius: 6px;
        width: 100%;
    }

    .btn-submit:hover {
        background: #3a5bd0;
    }
</style>

<div class="profile-container">

    <!-- Header -->
    <div class="profile-header">
        <h2>Admin Profile</h2>
        <p class="text-muted">Update your personal details & photo</p>
    </div>

    <!-- FORM START -->
    <form method="POST" action="{{ route('update.profile') }}" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div class="row">

            <!-- LEFT: IMAGE -->
            <div class="col-lg-4">
                <div class="profile-card text-center" style="height: 398px;">
                    <h4 class="section-title">Profile Image</h4>

                    <img
                        src="{{ $user->image ? asset($user->image) : asset('images/default-user.png') }}"
                        class="profile-image"
                        id="profilePreview"
                    >

                    <input type="file" name="image" class="form-control mt-2" accept="image/*"
                           onchange="previewImage(event)">
                </div>
            </div>

            <!-- RIGHT: DETAILS -->
            <div class="col-lg-8">
                <div class="profile-card">
                    <h4 class="section-title">Personal Details</h4>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>First Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control"
                               placeholder="Leave blank to keep current password">
                    </div>

                    <button type="submit" class="btn-submit mt-3">
                        Update Profile
                    </button>
                </div>
            </div>

        </div>
    </form>
    <!-- FORM END -->

</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('profilePreview').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection
