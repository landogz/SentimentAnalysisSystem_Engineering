<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Forgot Password - PRMSU ENGINEERING Student Feedback System</title>

    <!-- Google Font: Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        :root {
            --dark-gray: #494850;
            --light-green: #8FCFA8;
            --coral-pink: #FF4E00;
            --golden-orange: #F5B445;
            --light-blue: #98AAE7;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            display: flex;
            overflow: hidden;
        }
        
        .forgot-wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }
        
        /* Left Section - Welcome Area */
        .welcome-section {
            flex: 2;
            background: linear-gradient(135deg, #6B46C1 0%, #9333EA 50%, #EC4899 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
        }
        
        .welcome-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:rgba(255,255,255,0.1);stop-opacity:1" /><stop offset="100%" style="stop-color:rgba(255,255,255,0);stop-opacity:1" /></linearGradient></defs><ellipse cx="50" cy="50" rx="40" ry="20" fill="url(%23grad)" /></svg>') repeat;
            opacity: 0.3;
            animation: float 20s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(5deg); }
        }
        
        .welcome-content {
            position: relative;
            z-index: 1;
            color: white;
            max-width: 500px;
        }
        
        .welcome-content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }
        
        .welcome-content p {
            font-size: 1.1rem;
            line-height: 1.8;
            opacity: 0.95;
        }
        
        /* Abstract shapes */
        .abstract-shape {
            position: absolute;
            border-radius: 50px;
            opacity: 0.4;
            animation: moveShape 15s ease-in-out infinite;
        }
        
        .shape-1 {
            width: 300px;
            height: 80px;
            background: linear-gradient(135deg, #EC4899 0%, #F97316 100%);
            top: 20%;
            left: 10%;
            transform: rotate(-25deg);
        }
        
        .shape-2 {
            width: 250px;
            height: 70px;
            background: linear-gradient(135deg, #F97316 0%, #EC4899 100%);
            bottom: 25%;
            right: 15%;
            transform: rotate(35deg);
            animation-delay: -5s;
        }
        
        .shape-3 {
            width: 200px;
            height: 60px;
            background: linear-gradient(135deg, #EC4899 0%, #F97316 100%);
            top: 60%;
            left: 20%;
            transform: rotate(-15deg);
            animation-delay: -10s;
        }
        
        @keyframes moveShape {
            0%, 100% { transform: translateY(0) rotate(var(--rotation, 0deg)); }
            50% { transform: translateY(-30px) rotate(calc(var(--rotation, 0deg) + 10deg)); }
        }
        
        /* Right Section - Forgot Password Form */
        .form-section {
            flex: 1;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            overflow-y: auto;
        }
        
        .forgot-container {
            width: 100%;
            max-width: 400px;
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .logo-container img {
            height: 120px;
            width: auto;
            max-width: 100%;
            object-fit: contain;
        }
        
        .form-title {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        
        .form-title h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #6B46C1;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .forgot-body {
            padding: 0;
        }
        
        .form-group {
            margin-bottom: 2rem;
        }
        
        .form-control {
            border: none;
            border-radius: 12px;
            padding: 1rem 1rem 1rem 3.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #F3F4F6;
            width: 100%;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
        
        .form-control:focus {
            outline: none;
            background-color: #E5E7EB;
            box-shadow: 0 0 0 3px rgba(107, 70, 193, 0.1);
        }
        
        .input-wrapper {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6B46C1;
            font-size: 1.1rem;
            z-index: 1;
        }
        
        .btn-reset {
            background: linear-gradient(135deg, #EC4899 0%, #6B46C1 100%);
            border: none;
            color: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(107, 70, 193, 0.3);
            width: 100%;
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
        }
        
        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(107, 70, 193, 0.4);
            color: white;
        }
        
        .btn-reset:active {
            transform: translateY(0);
        }
        
        .btn-reset:disabled {
            opacity: 0.6;
            transform: none;
            box-shadow: none;
        }
        
        .alert {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 15px rgba(73, 72, 80, 0.1);
            margin-bottom: 1.5rem;
        }
        
        .alert-success {
            background: linear-gradient(135deg, var(--light-green) 0%, #7bb894 100%);
            color: white;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, var(--coral-pink) 0%, #E64500 100%);
            color: white;
        }
        
        .error-feedback {
            color: var(--coral-pink);
            font-size: 0.875rem;
            margin-top: 0.5rem;
            font-weight: 500;
        }
        
        .info-section {
            text-align: center;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, rgba(107, 70, 193, 0.05) 0%, rgba(236, 72, 153, 0.05) 100%);
            border-radius: 12px;
            border: 1px solid rgba(107, 70, 193, 0.2);
        }
        
        .info-section i {
            font-size: 3rem;
            color: #6B46C1;
            margin-bottom: 1rem;
        }
        
        .info-section p {
            color: var(--dark-gray);
            font-size: 0.95rem;
            line-height: 1.6;
            margin: 0;
        }
        
        .login-link {
            text-align: center;
            margin-top: 2rem;
            color: #6c757d;
        }
        
        .login-link a {
            color: #6B46C1;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .login-link a:hover {
            color: #9333EA;
            text-decoration: underline;
        }
        
        .public-survey-link {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .public-survey-link a {
            color: #6B46C1;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .public-survey-link a:hover {
            color: #9333EA;
            text-decoration: underline;
        }
        
        /* Mobile-specific improvements */
        @media (max-width: 968px) {
            .forgot-wrapper {
                flex-direction: column;
            }
            
            .welcome-section {
                display: none;
            }
            
            .form-section {
                flex: 1;
                padding: 2rem 1.5rem;
            }
        }
        
        @media (max-width: 768px) {
            .welcome-content h1 {
                font-size: 1.5rem;
            }
            
            .form-title h2 {
                font-size: 1.5rem;
            }
            
            .btn {
                min-height: 44px;
            }
        }
        
        /* Prevent zoom on double tap (iOS) */
        @media screen and (-webkit-min-device-pixel-ratio: 0) {
            select,
            textarea,
            input {
                font-size: 16px;
            }
        }
        
        /* Smooth scrolling for mobile */
        html {
            scroll-behavior: smooth;
        }
        
        /* Better focus indicators for accessibility */
        .form-control:focus,
        .btn:focus {
            outline: 2px solid #6B46C1;
            outline-offset: 2px;
        }
        
        /* Loading animation */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .fa-spin {
            animation: spin 1s linear infinite;
        }
    </style>
</head>

<body>
    <div class="forgot-wrapper">
        <!-- Left Section - Welcome Area -->
        <div class="welcome-section">
            <div class="abstract-shape shape-1"></div>
            <div class="abstract-shape shape-2"></div>
            <div class="abstract-shape shape-3"></div>
            <div class="welcome-content">
                <h1>Welcome to PRMSU ENGINEERING</h1>
                <p>Student Feedback System - Forgot your password? No worries! We'll help you reset it quickly and securely. Enter your email address to receive a password reset link.</p>
            </div>
        </div>
        
        <!-- Right Section - Forgot Password Form -->
        <div class="form-section">
            <div class="forgot-container">
                <div class="logo-container">
                    <img src="{{ asset('images/logo.png') }}" alt="PRMSU ENGINEERING Logo">
                </div>
                
                <div class="form-title">
                    <h2>Forgot Password</h2>
                </div>
                
                <div class="public-survey-link">
                    <a href="{{ route('survey.index') }}">
                        <i class="fas fa-external-link-alt me-1"></i>Access Public Survey
                    </a>
                </div>
                
                <div class="forgot-body">
                @if(session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" id="forgotForm">
                    @csrf
                    
                    <div class="info-section">
                        <i class="fas fa-key"></i>
                        <p>Enter your email address and we'll send you a link to reset your password.</p>
                    </div>
                    
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" 
                               placeholder="Email" required autofocus>
                        @error('email')
                            <div class="error-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-reset" id="resetBtn">
                            Send Reset Link
                        </button>
                    </div>
                </form>

                <div class="login-link">
                    <p class="mb-0">
                        Remember your password? 
                        <a href="{{ route('login') }}">
                            Login here
                        </a>
                    </p>
                </div>

            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Form submission with AJAX
            $('#forgotForm').submit(function(e) {
                e.preventDefault();
                
                const resetBtn = $('#resetBtn');
                const originalText = resetBtn.html();
                
                resetBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Sending...');
                
                $.ajax({
                    url: '{{ route("password.email") }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Email Sent!',
                            text: 'If an account exists with that email, we have sent a password reset link.',
                            confirmButtonColor: '#98AAE7'
                        });
                        
                        resetBtn.prop('disabled', false).html(originalText);
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred while sending the reset link.';
                        
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            errorMessage = Object.values(errors).flat().join('\n');
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage,
                            confirmButtonColor: '#F16E70'
                        });
                        
                        resetBtn.prop('disabled', false).html(originalText);
                    }
                });
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
            
            // Prevent zoom on double tap (iOS)
            let lastTouchEnd = 0;
            document.addEventListener('touchend', function (event) {
                const now = (new Date()).getTime();
                if (now - lastTouchEnd <= 300) {
                    event.preventDefault();
                }
                lastTouchEnd = now;
            }, false);
        });
    </script>
</body>
</html> 