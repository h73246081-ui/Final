<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Create Account</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="{{asset('assets/css/register.css')}}">


</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <!-- Header -->
            <div class="register-header">
                <h2>Create Account</h2>
                <p class="mb-0">Join our community today</p>
            </div>
            
            <!-- Body -->
            <div class="register-body">
                <!-- Success/Error Messages -->
                @if(session('success'))
                <div class="alert alert-success alert-container" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
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
                
                <!-- Registration Form -->
                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf
                    
                    <!-- Name Field -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autocomplete="name" 
                                   autofocus
                                   placeholder="Enter your full name">
                        </div>
                        @error('name')
                            <div class="error-message">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
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
                                   placeholder="Enter your email">
                        </div>
                        @error('email')
                            <div class="error-message">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Password Field -->
                    <div class="mb-3">
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
                                       autocomplete="new-password"
                                       placeholder="Create a password">
                            </div>
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        
                        <!-- Password Strength Indicator -->
                        <div class="password-strength">
                            <div class="strength-text" id="strengthText">Password strength: None</div>
                            <div class="strength-bar">
                                <div class="strength-fill" id="strengthFill"></div>
                            </div>
                        </div>
                        
                        @error('password')
                            <div class="error-message">
                                {{ $message }}
                            </div>
                        @enderror
                        
                        <div class="form-text">
                            Use at least 8 characters with a mix of letters, numbers & symbols
                        </div>
                    </div>
                    
                    <!-- Confirm Password Field -->
                    <div class="mb-4">
                        <label for="password-confirm" class="form-label">Confirm Password</label>
                        <div class="position-relative">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                <input type="password" 
                                       class="form-control" 
                                       id="password-confirm" 
                                       name="password_confirmation" 
                                       required 
                                       autocomplete="new-password"
                                       placeholder="Confirm your password">
                            </div>
                            <button type="button" class="password-toggle" id="toggleConfirmPassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div id="passwordMatch" class="validation-text"></div>
                        @error('password_confirmation')
                            <div class="error-message">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Terms Checkbox -->
                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">
                                I agree to the <a href="#" class="text-decoration-none">Terms of Service</a> and <a href="#" class="text-decoration-none">Privacy Policy</a>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" class="btn-register" id="submitBtn">
                        <i class="bi bi-person-plus me-2"></i>
                        Create Account
                    </button>
                </form>
                
                <!-- Login Link -->
                <div class="login-link">
                    Already have an account? 
                    <a href="{{ route('login') }}">Sign In</a>
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
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const passwordField = document.getElementById('password');
            const confirmPasswordField = document.getElementById('password-confirm');
            
            togglePassword.addEventListener('click', function() {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                this.innerHTML = type === 'password' ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
            });
            
            toggleConfirmPassword.addEventListener('click', function() {
                const type = confirmPasswordField.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPasswordField.setAttribute('type', type);
                this.innerHTML = type === 'password' ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
            });
            
            // Password strength checker
            passwordField.addEventListener('input', function() {
                const password = this.value;
                const strengthText = document.getElementById('strengthText');
                const strengthFill = document.getElementById('strengthFill');
                const strengthBar = document.querySelector('.strength-bar');
                
                let strength = 0;
                let text = 'Password strength: ';
                
                // Length check
                if (password.length >= 8) strength += 1;
                
                // Lowercase check
                if (/[a-z]/.test(password)) strength += 1;
                
                // Uppercase check
                if (/[A-Z]/.test(password)) strength += 1;
                
                // Number check
                if (/[0-9]/.test(password)) strength += 1;
                
                // Special character check
                if (/[^A-Za-z0-9]/.test(password)) strength += 1;
                
                // Update strength bar
                strengthBar.className = 'strength-bar strength-' + strength;
                
                // Update text
                switch(strength) {
                    case 0:
                        text += 'None';
                        break;
                    case 1:
                        text += 'Weak';
                        break;
                    case 2:
                        text += 'Fair';
                        break;
                    case 3:
                        text += 'Good';
                        break;
                    case 4:
                    case 5:
                        text += 'Strong';
                        break;
                }
                
                strengthText.textContent = text;
            });
            
            // Password confirmation check
            confirmPasswordField.addEventListener('input', function() {
                const password = document.getElementById('password').value;
                const confirmPassword = this.value;
                const matchText = document.getElementById('passwordMatch');
                
                if (confirmPassword === '') {
                    matchText.textContent = '';
                    matchText.className = 'validation-text';
                } else if (password === confirmPassword) {
                    matchText.textContent = '✓ Passwords match';
                    matchText.className = 'validation-text text-success';
                } else {
                    matchText.textContent = '✗ Passwords do not match';
                    matchText.className = 'validation-text text-danger';
                }
            });
            
            // Form validation
            const form = document.getElementById('registerForm');
            const submitBtn = document.getElementById('submitBtn');
            
            form.addEventListener('submit', function(event) {
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('password-confirm').value;
                const terms = document.getElementById('terms').checked;
                
                if (!terms) {
                    event.preventDefault();
                    alert('Please agree to the Terms of Service and Privacy Policy.');
                    return;
                }
                
                if (password !== confirmPassword) {
                    event.preventDefault();
                    alert('Passwords do not match. Please check and try again.');
                    return;
                }
                
                if (password.length < 8) {
                    event.preventDefault();
                    alert('Password must be at least 8 characters long.');
                    return;
                }
                
                // Show loading state
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Creating Account...';
                submitBtn.disabled = true;
            });
            
            // Auto-focus on name field
            document.getElementById('name').focus();
        });
    </script>
</body>
</html>