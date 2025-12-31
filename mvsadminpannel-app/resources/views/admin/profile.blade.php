@extends('layouts.app')
@section('content')
    <style>
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            padding: 20px;
            margin: 0;
        }
        
        .profile-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .profile-header {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .profile-header h1 {
            color: #333;
            font-weight: 600;
            margin-bottom: 5px;
            font-size: 24px;
        }
        
        .profile-header .subtitle {
            color: #666;
            font-size: 14px;
        }
        
        .profile-card {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .section-title {
            color: #333;
            font-weight: 600;
            font-size: 18px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
            font-size: 14px;
        }
        
        .form-control {
            border-radius: 6px;
            background:  #4670ab !important;
            border: 1px solid #ddd;
            padding: 10px 12px;
            width: 100%;
            font-size: 14px;
        }
        
        .form-control:focus {
            border-color: #4c70e8;
            outline: none;
            box-shadow: 0 0 0 2px rgba(74, 109, 229, 0.2);
        }
        
        .profile-image-section {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #f0f0f0;
            margin-bottom: 15px;
        }
        
        .file-upload {
            margin: 15px 0;
        }
        
        .file-upload-input {
            display: none;
        }
        
        .file-upload-label {
            display: inline-block;
            padding: 8px 20px;
            background-color: #f8f9fa;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .file-name {
            margin-top: 5px;
            font-size: 12px;
            color: #666;
        }
        
        .btn-submit {
            background-color: #4a6de5;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            border: none;
            width: 100%;
            cursor: pointer;
            font-size: 14px;
            margin-top: 20px;
        }
        
        .btn-submit:hover {
            background-color: #3a5bd0;
        }
        
        .password-note {
            background-color: #fff9e6;
            padding: 10px;
            margin-top: 10px;
            border-radius: 4px;
            font-size: 12px;
            color: #856404;
            border-left: 3px solid #ffc107;
        }
        
        .info-text {
            color: #666;
            font-size: 12px;
            margin-top: 5px;
        }
        
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
        }
        
        .col-lg-4, .col-lg-8, .col-md-6 {
            padding: 0 15px;
            box-sizing: border-box;
        }
        
        .col-lg-4 {
            width: 33.33%;
        }
        
        .col-lg-8 {
            width: 66.66%;
        }
        
        .col-md-6 {
            width: 50%;
        }
        
        .mb-3 {
            margin-bottom: 15px;
        }
        
        .mt-3 {
            margin-top: 15px;
        }
        
        .w-100 {
            width: 100%;
        }
        
        .d-flex {
            display: flex;
        }
        
        .align-items-center {
            align-items: center;
        }
        
        .me-1 { margin-right: 5px; }
        .me-2 { margin-right: 10px; }
        .ms-2 { margin-left: 10px; }
        
        .d-block {
            display: block;
        }
        
        .fs-5 {
            font-size: 16px;
        }
        
        .text-primary {
            color: #4a6de5 !important;
        }
        
        .text-success {
            color: #28a745 !important;
        }
        
        strong {
            font-weight: 600;
        }
        
        @media (max-width: 992px) {
            .col-lg-4, .col-lg-8 {
                width: 100%;
            }
        }
        
        @media (max-width: 768px) {
            .col-md-6 {
                width: 100%;
            }
            
            .profile-container {
                padding: 10px;
            }
            
            .profile-header, .profile-card {
                padding: 15px;
            }
        }
    </style>

    <div class="profile-container">
        <!-- Header Section -->
        <div class="profile-header">
            <h1>Admin Profile</h1>
            <p class="subtitle">IT Nextro - Updates Your Photo and Personal Details.</p>
        </div>
        
        <div class="row">
            <!-- Left Column - Profile Image -->
            <div class="col-lg-4">
                <div class="profile-card">
                    <h3 class="section-title">Profile Image</h3>
                    
                    <div class="profile-image-section">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=4a6de5&color=fff&size=120" alt="Admin Profile" class="profile-image" id="profileImage">
                        
                        <div class="file-upload">
                            <input type="file" id="fileInput" class="file-upload-input" accept="image/*">
                            <label for="fileInput" class="file-upload-label">Choose File</label>
                            <div class="file-name" id="fileName">No file chosen</div>
                        </div>
                        
                        <p class="info-text mt-3">Recommended: Square image, at least 300x300 pixels</p>
                    </div>
                    
                    <button type="button" class="btn-submit">Update Profile</button>
                </div>
            </div>
            
            <!-- Right Column - Personal Details -->
            <div class="col-lg-8">
                <div class="profile-card">
                    <h3 class="section-title">Personal Details</h3>
                    
                    <form id="profileForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" value="IT Nextro">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" placeholder="Enter your last name">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" value="admin@gmail.com">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="company" class="form-label">Company</label>
                                <input type="text" class="form-control" id="company" placeholder="Enter your company name">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="phone" value="23142324">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Enter new password">
                                <div class="password-note">
                                    If you don't enter a password then your early password will be accepted
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- Additional Info Section -->
                <div class="profile-card">
                    <h3 class="section-title">Account Information</h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-user-shield text-primary me-2 fs-5"></i>
                                <div>
                                    <strong class="d-block">Account Type</strong>
                                    <span>Administrator</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-calendar-alt text-primary me-2 fs-5"></i>
                                <div>
                                    <strong class="d-block">Member Since</strong>
                                    <span>January 2023</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-id-badge text-primary me-2 fs-5"></i>
                                <div>
                                    <strong class="d-block">User ID</strong>
                                    <span>ADM-001</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-check-circle text-primary me-2 fs-5"></i>
                                <div>
                                    <strong class="d-block">Status</strong>
                                    <span class="text-success">Active</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    
    <script>
        // File input handling
        document.getElementById('fileInput').addEventListener('change', function(e) {
            const fileNameDisplay = document.getElementById('fileName');
            const profileImage = document.getElementById('profileImage');
            
            if (this.files && this.files[0]) {
                fileNameDisplay.textContent = this.files[0].name;
                
                // Preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    profileImage.src = e.target.result;
                }
                reader.readAsDataURL(this.files[0]);
            } else {
                fileNameDisplay.textContent = 'No file chosen';
            }
        });
        
        // Form submission handling
        document.querySelector('.btn-submit').addEventListener('click', function() {
            const firstName = document.getElementById('firstName').value;
            const lastName = document.getElementById('lastName').value;
            const email = document.getElementById('email').value;
            const company = document.getElementById('company').value;
            const phone = document.getElementById('phone').value;
            
            // Simple validation
            if (!firstName.trim() || !email.trim()) {
                alert('Please fill in required fields (First Name and Email)');
                return;
            }
            
            // Show success message
            alert('Profile updated successfully!');
        });
    </script> 
@endsection