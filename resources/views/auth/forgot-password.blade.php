<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Forgot Password - Sentiment Analysis Engineering</title>

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
            --dark-gray: #BF3100;
            --light-green: #8EA604;
            --coral-pink: #FF4E00;
            --golden-orange: #F5BB00;
            --light-blue: #EC9F05;
        }
        
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            position: relative;
            overflow-x: hidden;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 20% 80%, rgba(236, 159, 5, 0.03) 0%, transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(142, 166, 4, 0.03) 0%, transparent 50%),
                        radial-gradient(circle at 40% 40%, rgba(245, 187, 0, 0.02) 0%, transparent 50%);
            animation: backgroundFloat 20s ease-in-out infinite;
            z-index: -1;
        }
        
        @keyframes backgroundFloat {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(-30px, -30px) rotate(1deg); }
            66% { transform: translate(30px, -15px) rotate(-1deg); }
        }
        
        .forgot-container {
            background: white;
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(73, 72, 80, 0.12);
            margin: 2rem auto;
            max-width: 480px;
            overflow: hidden;
            position: relative;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        @media (max-width: 768px) {
            .forgot-container {
                margin: 0.5rem;
                border-radius: 15px;
            }
        }
        
        .forgot-header {
            background: linear-gradient(135deg, var(--light-blue) 0%, var(--coral-pink) 100%);
            color: white;
            padding: 2.5rem 2rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
            border-radius: 24px 24px 0 0;
        }
        
        .forgot-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 8s ease-in-out infinite;
        }
        
        .forgot-header::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 0;
            right: 0;
            height: 40px;
            background: white;
            border-radius: 50% 50% 0 0;
            transform: translateY(50%);
        }
        
        @media (max-width: 768px) {
            .forgot-header {
                padding: 2rem 1rem;
            }
        }
        
        .forgot-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        .logo-section {
            margin-bottom: 2rem;
            position: relative;
            z-index: 2;
        }
        
        .logo-section img {
            height: 80px;
            width: auto;
            margin-bottom: 0.5rem;
            filter: brightness(1.1) contrast(1.1);
            transition: transform 0.3s ease;
        }
        
        .logo-section img:hover {
            transform: scale(1.05);
        }
        
        .forgot-header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            position: relative;
            z-index: 2;
            color: white;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        @media (max-width: 768px) {
            .forgot-header h1 {
                font-size: 1.8rem;
            }
        }
        
        @media (max-width: 480px) {
            .forgot-header h1 {
                font-size: 1.5rem;
            }
        }
        
        .forgot-header p {
            font-size: 1.1rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
            color: white;
        }
        
        @media (max-width: 768px) {
            .forgot-header p {
                font-size: 1rem;
            }
        }
        
        .forgot-body {
            padding: 2rem 2rem 2rem;
            background: white;
            position: relative;
            z-index: 1;
        }
        
        @media (max-width: 768px) {
            .forgot-body {
                padding: 2rem 1rem;
            }
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 16px;
            padding: 1.25rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            position: relative;
        }
        
        @media (max-width: 768px) {
            .form-control {
                padding: 0.875rem;
                font-size: 16px; /* Prevents zoom on iOS */
            }
        }
        
        .form-control:focus {
            border-color: var(--light-blue);
            box-shadow: 0 8px 25px rgba(236, 159, 5, 0.15);
            background-color: white;
            transform: translateY(-3px);
        }
        
        .input-group-text {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-right: none;
            border-radius: 12px 0 0 12px;
            color: var(--dark-gray);
        }
        
        .form-control {
            border-left: none;
            border-radius: 0 12px 12px 0;
        }
        
        .btn-reset {
            background: linear-gradient(135deg, var(--golden-orange) 0%, var(--light-green) 100%);
            border: none;
            color: white;
            padding: 1.5rem 3rem;
            border-radius: 16px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(245, 187, 0, 0.3);
            width: 100%;
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
            position: relative;
            overflow: hidden;
        }
        
        .btn-reset::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-reset:hover::before {
            left: 100%;
        }
        
        @media (max-width: 768px) {
            .btn-reset {
                padding: 1rem 2rem;
                font-size: 1rem;
            }
        }
        
        .btn-reset:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 35px rgba(245, 187, 0, 0.4);
            color: white;
        }
        
        .btn-reset:active {
            transform: translateY(-1px);
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
            color: #155724;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, var(--coral-pink) 0%, #e55a5c 100%);
            color: #721c24;
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
        }
        
        .info-section i {
            font-size: 4rem;
            color: var(--light-blue);
            margin-bottom: 1rem;
        }
        
        @media (max-width: 768px) {
            .info-section i {
                font-size: 3rem;
            }
        }
        
        .info-section p {
            color: var(--dark-gray);
            font-size: 1rem;
            line-height: 1.6;
        }
        
        .links-section {
            text-align: center;
            margin-top: 2rem;
        }
        
        .links-section a {
            color: var(--light-blue);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            background: rgba(236, 159, 5, 0.08);
            border: 1px solid rgba(236, 159, 5, 0.1);
        }
        
        .links-section a:hover {
            color: var(--light-blue);
            background: rgba(236, 159, 5, 0.15);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(236, 159, 5, 0.2);
        }
        
        .divider {
            margin: 2rem 0;
            border-top: 1px solid #e9ecef;
            position: relative;
        }
        
        .divider::before {
            content: 'or';
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            padding: 0 1rem;
            color: var(--dark-gray);
            font-size: 0.875rem;
        }
        
        .footer {
            text-align: center;
            padding: 2rem;
            color: var(--dark-gray);
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .footer {
                padding: 1rem;
                font-size: 0.8rem;
            }
        }
        
        .footer a {
            color: var(--light-blue);
            text-decoration: none;
        }
        
        .footer a:hover {
            text-decoration: underline;
        }
        
        /* Mobile-specific improvements */
        @media (max-width: 768px) {
            .container {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }
            
            /* Improve touch targets */
            .form-check-input {
                min-width: 20px;
                min-height: 20px;
            }
            
            /* Better spacing for mobile */
            .mb-3 {
                margin-bottom: 1rem !important;
            }
            
            /* Improve button touch area */
            .btn {
                min-height: 44px;
                display: flex;
                align-items: center;
                justify-content: center;
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
            outline: 2px solid var(--light-blue);
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
    <div class="container">
        <div class="forgot-container">
            <div class="forgot-header">
                <div class="logo-section">
                    <img src="{{ asset('images/logo.png') }}" alt="Sentiment Analysis Engineering" class="logo">
                </div>
                <h1>Sentiment Analysis Engineering</h1>
                <p>Student Feedback System</p>
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

                <div class="info-section">
                    <i class="fas fa-key"></i>
                    <p>
                        Enter your email address and we'll send you a link to reset your password.
                    </p>
                </div>

                <form method="POST" action="{{ route('password.email') }}" id="forgotForm">
                    @csrf
                    
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="Enter your email" required autofocus>
                        </div>
                        @error('email')
                            <div class="error-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-reset" id="resetBtn">
                            <i class="fas fa-paper-plane me-2"></i>Send Reset Link
                        </button>
                    </div>
                </form>

                <div class="divider"></div>

                <div class="links-section">
                    <p class="text-muted mb-0">
                        Remember your password? 
                        <a href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i>Login here
                        </a>
                    </p>
                </div>

                <div class="links-section">
                    <a href="{{ route('survey.index') }}">
                        <i class="fas fa-external-link-alt me-1"></i>Access Engineering Survey
                    </a>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Sentiment Analysis Engineering. All rights reserved.</p>
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