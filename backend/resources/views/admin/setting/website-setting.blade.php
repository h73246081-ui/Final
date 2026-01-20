@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Website Settings</h2>

    <form action="{{route('website-settings.update')}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Site Info Section -->
        <div class="card mb-4">
            <div class="card-header">Site Info</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label for="site_name" class="form-label">Site Name</label>
                        <input type="text" name="site_name" id="site_name" class="form-control" value="{{ old('site_name', $setting->site_name ?? '') }}">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="logo" class="form-label">Logo</label>
                        <input type="file" name="logo" id="logo" class="form-control">
                        @if($setting->logo && file_exists(public_path('storage/' . $setting->logo)))
                            <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo" class="img-thumbnail mt-2" width="150">
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Info Section -->
        <div class="card mb-4">
            <div class="card-header">Contact Info</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $setting->email ?? '') }}">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $setting->phone ?? '') }}">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="contact" class="form-label">Contact</label>
                        <input type="text" name="contact" id="contact" class="form-control" value="{{ old('contact', $setting->contact ?? '') }}">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $setting->address ?? '') }}">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="support_hours" class="form-label">Support Hours</label>
                        <input type="text" name="support_hours" id="support_hours" class="form-control" value="{{ old('support_hours', $setting->support_hours ?? '') }}">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="direction_address" class="form-label">Direction Address</label>
                        <input type="text" name="direction_address" id="direction_address" class="form-control" value="{{ old('direction_address', $setting->direction_address ?? '') }}">
                    </div>
                    <div class="col-12">
                        <label for="direction_link" class="form-label">Direction Link</label>
                        <textarea name="direction_link" id="direction_link" class="form-control">{{ old('direction_link', $setting->direction_link ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Social Links Section -->
        <div class="card mb-4">
            <div class="card-header">Social Links</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label for="facebook" class="form-label">Facebook</label>
                        <input type="text" name="facebook" id="facebook" class="form-control" value="{{ old('facebook', $setting->facebook ?? '') }}">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="twitter" class="form-label">Twitter</label>
                        <input type="text" name="twitter" id="twitter" class="form-control" value="{{ old('twitter', $setting->twitter ?? '') }}">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="instagram" class="form-label">Instagram</label>
                        <input type="text" name="instagram" id="instagram" class="form-control" value="{{ old('instagram', $setting->instagram ?? '') }}">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="tiktok" class="form-label">TikTok</label>
                        <input type="text" name="tiktok" id="tiktok" class="form-control" value="{{ old('tiktok', $setting->tiktok ?? '') }}">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="youtube" class="form-label">YouTube</label>
                        <input type="text" name="youtube" id="youtube" class="form-control" value="{{ old('youtube', $setting->youtube ?? '') }}">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="linkedin" class="form-label">LinkedIn</label>
                        <input type="text" name="linkedin" id="linkedin" class="form-control" value="{{ old('linkedin', $setting->linkedin ?? '') }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Responsive Button Section -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-center justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Update Settings
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    /* Responsive button styles */
    @media (max-width: 768px) {
        .btn-primary {
            width: 100%;
            padding: 0.75rem;
            font-size: 1rem;
        }

        .container {
            padding: 15px !important;
        }

        h2 {
            font-size: 1.5rem;
        }

        .card-header {
            font-size: 1.1rem;
            padding: 0.75rem 1rem;
        }
    }

    @media (max-width: 576px) {
        .btn-primary {
            padding: 0.625rem;
            font-size: 0.95rem;
        }

        h2 {
            font-size: 1.3rem;
        }

        .form-label {
            font-size: 0.9rem;
        }

        .form-control {
            font-size: 0.9rem;
            padding: 0.5rem 0.75rem;
        }
    }

    @media (max-width: 400px) {
        .btn-primary {
            padding: 0.5rem;
            font-size: 0.9rem;
        }

        .btn-primary i {
            margin-right: 0.5rem !important;
        }
    }
</style>
@endsection