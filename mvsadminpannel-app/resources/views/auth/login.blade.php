<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sign In</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{asset('assets/css/login.css')}}">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                {{-- <h2>Welcome Back</h2> --}}
                <p class="mb-0">Sign in to your account</p>
            </div>

            <!-- Body -->
            <div class="login-body">
                <!-- Success/Error Messages -->
                @if(session('success'))
                <div class="alert alert-success alert-container" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
                @endif

                @if(session('status'))
                <div class="alert alert-success alert-container" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('status') }}
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger alert-container" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Logo Section -->
<div class="text-center mb-4">
    <a href="{{ url('/') }}">
        <img src="{{ asset('assets/img/tijaar2.jpeg') }}" alt="Logo" class="img-fluid" style="max-height: 80px;margin-left: 61px;">
    </a>
</div>

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    <!-- Email Field -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autocomplete="email"
                                   autofocus
                                   placeholder="Enter your email" style="width: 90%;">
                        </div>
                        @error('email')
                            <div class="error-message">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="position-relative">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       id="password"
                                       name="password"
                                       required
                                       autocomplete="current-password"
                                       placeholder="Enter your password" style="width: 90%;">
                            </div>
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="error-message">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="login-options mb-4">
                        <div class="remember-me">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Remember Me
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                        <div class="forgot-password">
                            <a href="{{ route('password.request') }}">
                                Forgot Password?
                            </a>
                        </div>
                        @endif
                    </div>

                    <!-- Optional: Social Login Divider -->
                    <!--
                    <div class="social-divider">
                        <span>Or continue with</span>
                    </div>

                    <div class="social-login">
                        <button type="button" class="social-btn google">
                            <i class="bi bi-google"></i>
                            Google
                        </button>
                        <button type="button" class="social-btn facebook">
                            <i class="bi bi-facebook"></i>
                            Facebook
                        </button>
                    </div>
                    -->

                    <!-- Submit Button -->
                    <button type="submit" class="btn-login" id="submitBtn">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Sign In
                    </button>
                </form>

                <!-- Register Link -->
                <div class="register-link">
                    Don't have an account?
                    <a href="{{ route('register') }}">Create Account</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password toggle functionality
            const togglePassword = document.getElementById('togglePassword');
            const passwordField = document.getElementById('password');

            if (togglePassword && passwordField) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordField.setAttribute('type', type);
                    this.innerHTML = type === 'password' ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
                });
            }

            // Form validation
            const form = document.getElementById('loginForm');
            const submitBtn = document.getElementById('submitBtn');

            if (form && submitBtn) {
                form.addEventListener('submit', function(event) {
                    const email = document.getElementById('email').value;
                    const password = document.getElementById('password').value;

                    if (!email || !password) {
                        event.preventDefault();
                        alert('Please fill in all required fields.');
                        return;
                    }

                    // Show loading state
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Signing In...';
                    submitBtn.disabled = true;
                });
            }

            // Auto-focus on email field
            const emailField = document.getElementById('email');
            if (emailField) {
                emailField.focus();
            }

            // Display demo credentials (optional - remove in production)
            console.log('Demo Credentials:');
            console.log('Email: demo@example.com');
            console.log('Password: password123');
        });
    </script>
</body>
</html>