<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>PRMSU ENGINEERING - Student Feedback Survey</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo.png') }}">
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
            --coral-pink: #F16E70;
            --golden-orange: #F5B445;
            --light-blue: #98AAE7;
            --primary-gradient: linear-gradient(135deg, var(--dark-gray) 0%, #5a5a6a 100%);
            --success-gradient: linear-gradient(135deg, var(--light-green) 0%, #7bb894 100%);
            --warning-gradient: linear-gradient(135deg, var(--golden-orange) 0%, #f5a623 100%);
            --info-gradient: linear-gradient(135deg, var(--light-blue) 0%, #7a8cd6 100%);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            background-size: 400% 400%;
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
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(152, 170, 231, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(245, 180, 69, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(143, 207, 168, 0.15) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }
        
        .container {
            position: relative;
            z-index: 1;
        }
        
        .survey-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 30px;
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.1),
                0 0 0 1px rgba(255, 255, 255, 0.2) inset;
            margin: 2rem auto;
            max-width: 950px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: slideUp 0.6s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @media (max-width: 768px) {
            .survey-container {
                margin: 1rem;
                border-radius: 20px;
            }
        }
        
        .survey-header {
            background: var(--primary-gradient);
            color: white;
            padding: 3rem 2rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        /* Multi-Step Wizard Styles */
        .wizard-steps {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 2rem auto 0;
            max-width: 800px;
            position: relative;
            z-index: 2;
        }
        
        .wizard-step {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }
        
        .wizard-step::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 50%;
            width: 100%;
            height: 3px;
            background: rgba(255, 255, 255, 0.3);
            z-index: 0;
        }
        
        .wizard-step:first-child::before {
            display: none;
        }
        
        .wizard-step.completed::before {
            background: rgba(255, 255, 255, 0.6);
        }
        
        .wizard-step.active::before {
            background: rgba(255, 255, 255, 0.6);
        }
        
        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            border: 3px solid rgba(255, 255, 255, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            color: white;
            position: relative;
            z-index: 1;
            transition: all 0.4s ease;
        }
        
        .wizard-step.active .step-number {
            background: white;
            color: var(--dark-gray);
            border-color: white;
            transform: scale(1.2);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        
        .wizard-step.completed .step-number {
            background: var(--light-green);
            border-color: var(--light-green);
            color: white;
        }
        
        .wizard-step.completed .step-number::after {
            content: '✓';
            font-size: 1.2rem;
        }
        
        .step-label {
            margin-top: 0.5rem;
            font-size: 0.75rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9);
            text-align: center;
            opacity: 0.7;
            transition: all 0.4s ease;
        }
        
        .wizard-step.active .step-label {
            opacity: 1;
            font-weight: 600;
        }
        
        @media (max-width: 768px) {
            .wizard-steps {
                margin: 1.5rem auto 0;
            }
            
            .step-number {
                width: 35px;
                height: 35px;
                font-size: 0.9rem;
            }
            
            .step-label {
                font-size: 0.65rem;
                margin-top: 0.4rem;
            }
        }
        
        .wizard-content {
            display: none;
            animation: fadeIn 0.5s ease-in-out;
        }
        
        .wizard-content.active {
            display: block;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @media (max-width: 768px) {
            .survey-header {
                padding: 2.5rem 1.5rem;
            }
        }
        
        .survey-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
            animation: float 8s ease-in-out infinite;
        }
        
        .survey-header::after {
            content: '';
            position: absolute;
            bottom: -30%;
            right: -30%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
            animation: pulse 4s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(180deg); }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.2); opacity: 0.8; }
        }
        
        .logo-section {
            margin-bottom: 2rem;
            position: relative;
            z-index: 2;
        }
        
        .logo-section img {
            height: 140px;
            width: auto;
            margin-bottom: 1rem;
            filter: drop-shadow(0 10px 20px rgba(0,0,0,0.2));
            animation: logoFloat 3s ease-in-out infinite;
            transition: transform 0.3s ease;
        }
        
        .logo-section img:hover {
            transform: scale(1.05) rotate(5deg);
        }
        
        @keyframes logoFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .survey-header h1 {
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 0.75rem;
            position: relative;
            z-index: 2;
            color: white;
            text-shadow: 0 4px 15px rgba(0,0,0,0.2);
            letter-spacing: -0.5px;
        }
        
        @media (max-width: 768px) {
            .survey-header h1 {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 480px) {
            .survey-header h1 {
                font-size: 1.6rem;
            }
        }
        
        .survey-header p {
            font-size: 1.2rem;
            opacity: 0.95;
            position: relative;
            z-index: 2;
            color: white;
            font-weight: 400;
            text-shadow: 0 2px 10px rgba(0,0,0,0.15);
        }
        
        @media (max-width: 768px) {
            .survey-header p {
                font-size: 1rem;
            }
        }
        
        .survey-body {
            padding: 3.5rem 2.5rem;
            background: rgba(255, 255, 255, 0.5);
        }
        
        @media (max-width: 768px) {
            .survey-body {
                padding: 2rem 1.5rem;
            }
        }
        
        .form-group {
            margin-bottom: 2.5rem;
            position: relative;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--dark-gray);
            margin-bottom: 0.75rem;
            display: block;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
        }
        
        .form-control {
            border: 2px solid rgba(102, 126, 234, 0.2);
            border-radius: 16px;
            padding: 1.1rem 1.25rem;
            font-size: 1rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            width: 100%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        @media (max-width: 768px) {
            .form-control {
                padding: 1rem;
                font-size: 16px;
            }
        }
        
        .form-control:focus {
            border-color: var(--light-blue);
            box-shadow: 
                0 0 0 4px rgba(152, 170, 231, 0.1),
                0 8px 20px rgba(152, 170, 231, 0.15);
            background-color: white;
            transform: translateY(-2px);
            outline: none;
        }
        
        .form-control::placeholder {
            color: #adb5bd;
            opacity: 0.7;
        }
        
        .form-select {
            border: 2px solid rgba(152, 170, 231, 0.2);
            border-radius: 16px;
            padding: 1.1rem 1.25rem;
            font-size: 1rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.9) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2398AAE7' d='M6 9L1 4h10z'/%3E%3C/svg%3E") no-repeat right 1rem center;
            background-size: 12px;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .form-select:focus {
            border-color: var(--light-blue);
            box-shadow: 
                0 0 0 4px rgba(152, 170, 231, 0.1),
                0 8px 20px rgba(152, 170, 231, 0.15);
            background-color: white;
            transform: translateY(-2px);
            outline: none;
        }
        
        .form-select:hover {
            border-color: rgba(152, 170, 231, 0.4);
        }
        

        
        .btn-submit {
            background: var(--info-gradient);
            border: none;
            color: white;
            padding: 1.3rem 3rem;
            border-radius: 16px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 25px rgba(152, 170, 231, 0.4);
            width: 100%;
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
            position: relative;
            overflow: hidden;
        }
        
        .btn-submit::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .btn-submit:hover::before {
            width: 300px;
            height: 300px;
        }
        
        .btn-submit span {
            position: relative;
            z-index: 1;
        }
        
        @media (max-width: 768px) {
            .btn-submit {
                padding: 1.1rem 2rem;
                font-size: 1rem;
            }
        }
        
        .btn-submit:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 12px 35px rgba(152, 170, 231, 0.5);
            color: white;
        }
        
        .btn-submit:active {
            transform: translateY(-2px) scale(0.98);
        }
        
        .btn-submit:disabled {
            opacity: 0.6;
            transform: none;
            box-shadow: 0 4px 15px rgba(152, 170, 231, 0.2);
            cursor: not-allowed;
        }
        
        .alert {
            border-radius: 16px;
            border: none;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            padding: 1.25rem 1.5rem;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            animation: slideIn 0.5s ease-out;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .alert-success {
            background: linear-gradient(135deg, rgba(79, 172, 254, 0.9) 0%, rgba(0, 242, 254, 0.9) 100%);
            color: white;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, rgba(245, 87, 108, 0.9) 0%, rgba(250, 112, 154, 0.9) 100%);
            color: white;
        }
        
        .alert-info {
            background: var(--info-gradient);
            color: white;
        }
        
        .alert-warning {
            background: var(--warning-gradient);
            color: #333;
        }
        
        .error-feedback {
            color: #f5576c;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .error-feedback::before {
            content: '⚠';
            font-size: 1rem;
        }
        
        .footer {
            text-align: center;
            padding: 2rem;
            color: var(--dark-gray);
            font-size: 0.9rem;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        @media (max-width: 768px) {
            .footer {
                padding: 1.5rem;
                font-size: 0.85rem;
            }
        }
        
        .footer p {
            margin: 0;
            color: var(--dark-gray);
            opacity: 0.8;
        }
        
        .footer a {
            color: var(--light-blue);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .footer a:hover {
            color: var(--dark-gray);
            text-decoration: underline;
        }
        
        /* Login button hover effect */
        .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.2) !important;
            border-color: rgba(255, 255, 255, 0.6) !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15) !important;
        }
        
        /* Mobile-specific improvements */
        @media (max-width: 768px) {
            .container {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }
            
            /* Improve touch targets */
            .star {
                min-width: 44px;
                min-height: 44px;
            display: flex;
            align-items: center;
                justify-content: center;
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
        .btn:focus,
        .form-select:focus {
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
        
        /* Rating text styling */
        .rating-text {
            text-align: center;
            color: var(--dark-gray);
            font-weight: 500;
            margin-top: 0.5rem;
        }
        
        /* Form section styling */
        .form-section {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 2.5rem;
            margin-bottom: 2.5rem;
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.08),
                0 0 0 1px rgba(255, 255, 255, 0.3) inset;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        
        .form-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--info-gradient);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }
        
        .form-section:hover::before {
            transform: scaleX(1);
        }
        
        .form-section:hover {
            transform: translateY(-4px);
            box-shadow: 
                0 12px 40px rgba(0, 0, 0, 0.12),
                0 0 0 1px rgba(255, 255, 255, 0.4) inset;
        }
        
        @media (max-width: 768px) {
            .form-section {
                padding: 1.75rem;
                border-radius: 16px;
            }
        }
        
        .form-section h4 {
            font-weight: 700;
            font-size: 1.4rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .form-section h4 i {
            font-size: 1.3rem;
        }

        /* Survey Questions Styling */
        .btn-group {
            gap: 0.5rem;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        
        .btn-group .btn {
            border-radius: 12px;
            margin: 0;
            transition: all 0.3s ease;
            font-weight: 600;
            padding: 0.875rem 0.5rem;
            min-height: 75px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            line-height: 1.3;
            border-width: 2px;
            flex: 1;
            min-width: 85px;
            max-width: calc(20% - 0.4rem);
            position: relative;
            background: white;
            font-size: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }
        
        .btn-group .btn small {
            font-size: 0.7rem;
            font-weight: 500;
            margin-top: 4px;
            opacity: 0.85;
            position: relative;
            z-index: 1;
        }
        
        .btn-group .btn strong {
            font-size: 1.4rem;
            position: relative;
            z-index: 1;
            display: block;
            margin-bottom: 2px;
            font-weight: 700;
        }
        
        .btn-group .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
            z-index: 2;
        }
        
        .btn-check:checked + .btn {
            border-color: transparent;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
            z-index: 2;
        }
        
        .btn-check:checked + .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
        }
        
        .btn-check:checked + .btn small {
            opacity: 1;
            font-weight: 600;
        }
        
        .btn-check:checked + .btn strong {
            font-size: 1.5rem;
        }
        
        /* Part 1 Button Styling - Instructor Evaluation */
        .part-section:not(.part2):not(.part3) .btn-outline-success {
            color: #198754;
            border-color: #198754;
            background: rgba(25, 135, 84, 0.05);
        }
        
        .part-section:not(.part2):not(.part3) .btn-outline-success:hover {
            background: #198754;
            border-color: #198754;
            color: white;
        }
        
        .part-section:not(.part2):not(.part3) .btn-check:checked + .btn-outline-success {
            background: #198754;
            border-color: #198754;
            color: white;
        }
        
        .part-section:not(.part2):not(.part3) .btn-outline-info {
            color: #0dcaf0;
            border-color: #0dcaf0;
            background: rgba(13, 202, 240, 0.05);
        }
        
        .part-section:not(.part2):not(.part3) .btn-outline-info:hover {
            background: #0dcaf0;
            border-color: #0dcaf0;
            color: white;
        }
        
        .part-section:not(.part2):not(.part3) .btn-check:checked + .btn-outline-info {
            background: #0dcaf0;
            border-color: #0dcaf0;
            color: white;
        }
        
        .part-section:not(.part2):not(.part3) .btn-outline-secondary {
            color: #6c757d;
            border-color: #6c757d;
            background: rgba(108, 117, 125, 0.05);
        }
        
        .part-section:not(.part2):not(.part3) .btn-outline-secondary:hover {
            background: #6c757d;
            border-color: #6c757d;
            color: white;
        }
        
        .part-section:not(.part2):not(.part3) .btn-check:checked + .btn-outline-secondary {
            background: #6c757d;
            border-color: #6c757d;
            color: white;
        }
        
        .part-section:not(.part2):not(.part3) .btn-outline-warning {
            color: var(--golden-orange);
            border-color: var(--golden-orange);
            background: rgba(245, 180, 69, 0.05);
        }
        
        .part-section:not(.part2):not(.part3) .btn-outline-warning:hover {
            background: var(--golden-orange);
            border-color: var(--golden-orange);
            color: white;
        }
        
        .part-section:not(.part2):not(.part3) .btn-check:checked + .btn-outline-warning {
            background: var(--golden-orange);
            border-color: var(--golden-orange);
            color: white;
        }
        
        .part-section:not(.part2):not(.part3) .btn-outline-danger {
            color: var(--coral-pink);
            border-color: var(--coral-pink);
            background: rgba(241, 110, 112, 0.05);
        }
        
        .part-section:not(.part2):not(.part3) .btn-outline-danger:hover {
            background: var(--coral-pink);
            border-color: var(--coral-pink);
            color: white;
        }
        
        .part-section:not(.part2):not(.part3) .btn-check:checked + .btn-outline-danger {
            background: var(--coral-pink);
            border-color: var(--coral-pink);
            color: white;
        }
        
        /* Part 2 Button Styling - Difficulty Level */
        .part2 .btn-outline-success {
            color: #198754;
            border-color: #198754;
            background: rgba(25, 135, 84, 0.05);
        }
        
        .part2 .btn-outline-success:hover {
            background: #198754;
            border-color: #198754;
            color: white;
        }
        
        .part2 .btn-check:checked + .btn-outline-success {
            background: #198754;
            border-color: #198754;
            color: white;
        }
        
        .part2 .btn-outline-info {
            color: #0dcaf0;
            border-color: #0dcaf0;
            background: rgba(13, 202, 240, 0.05);
        }
        
        .part2 .btn-outline-info:hover {
            background: #0dcaf0;
            border-color: #0dcaf0;
            color: white;
        }
        
        .part2 .btn-check:checked + .btn-outline-info {
            background: #0dcaf0;
            border-color: #0dcaf0;
            color: white;
        }
        
        .part2 .btn-outline-secondary {
            color: #6c757d;
            border-color: #6c757d;
            background: rgba(108, 117, 125, 0.05);
        }
        
        .part2 .btn-outline-secondary:hover {
            background: #6c757d;
            border-color: #6c757d;
            color: white;
        }
        
        .part2 .btn-check:checked + .btn-outline-secondary {
            background: #6c757d;
            border-color: #6c757d;
            color: white;
        }
        
        .part2 .btn-outline-warning {
            color: var(--golden-orange);
            border-color: var(--golden-orange);
            background: rgba(245, 180, 69, 0.05);
        }
        
        .part2 .btn-outline-warning:hover {
            background: var(--golden-orange);
            border-color: var(--golden-orange);
            color: white;
        }
        
        .part2 .btn-check:checked + .btn-outline-warning {
            background: var(--golden-orange);
            border-color: var(--golden-orange);
            color: white;
        }
        
        .part2 .btn-outline-danger {
            color: var(--coral-pink);
            border-color: var(--coral-pink);
            background: rgba(241, 110, 112, 0.05);
        }
        
        .part2 .btn-outline-danger:hover {
            background: var(--coral-pink);
            border-color: var(--coral-pink);
            color: white;
        }
        
        .part2 .btn-check:checked + .btn-outline-danger {
            background: var(--coral-pink);
            border-color: var(--coral-pink);
            color: white;
        }
        
        /* Part-specific styling */
        .part-section {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 18px;
            padding: 2rem;
            margin-bottom: 2.5rem;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        
        .part-section::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 5px;
            background: var(--info-gradient);
        }
        
        .part-section:hover {
            transform: translateX(5px);
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.12);
        }
        
        .part-section.part2::before {
            background: var(--warning-gradient);
        }
        
        .part-section.part3::before {
            background: var(--info-gradient);
        }
        
        .part-section h5 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .section-subtitle {
            font-size: 0.95rem;
            color: #495057;
            font-weight: 600;
            margin-bottom: 1.25rem;
            padding: 0.75rem 1rem;
            background: linear-gradient(135deg, rgba(152, 170, 231, 0.1) 0%, rgba(122, 140, 214, 0.1) 100%);
            border-radius: 12px;
            border-left: 3px solid var(--light-blue);
            letter-spacing: 0.3px;
        }
        
        .question-label {
            font-weight: 600;
            color: var(--dark-gray);
            margin-bottom: 1rem;
            line-height: 1.5;
            font-size: 1rem;
        }
        
        .question-number {
            color: var(--light-blue);
            font-weight: 800;
            font-size: 1.1em;
            margin-right: 0.5rem;
        }
        
        /* Mobile responsive for survey questions */
        @media (max-width: 768px) {
            .btn-group {
                flex-wrap: wrap;
                gap: 0.5rem;
            }
            
            .btn-group .btn {
                flex: 1;
                min-width: calc(50% - 0.25rem);
                max-width: calc(50% - 0.25rem);
                margin: 0;
                padding: 0.75rem 0.5rem;
                min-height: 70px;
                font-size: 0.95rem;
            }
            
            .btn-group .btn strong {
                font-size: 1.3rem;
            }
            
            .btn-group .btn small {
                font-size: 0.65rem;
                margin-top: 3px;
            }
            
            .col-md-6 {
                margin-bottom: 2rem;
            }
            
            .part-section {
                padding: 1rem;
            }
        }
        
        @media (max-width: 480px) {
            .btn-group .btn {
                min-width: 100%;
                max-width: 100%;
                min-height: 65px;
            }
        }

        /* Tab Navigation Styling */
        .survey-tab {
            display: none;
        }
        
        .survey-tab.active {
            display: block;
            }
            
            .nav-buttons {
            display: none; /* Hidden by default */
        }
        
        .tab-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 2.5rem 0;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08);
        }
        
        .tab-indicator {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .tab-indicator span {
            font-weight: 600;
            color: var(--dark-gray);
            font-size: 0.95rem;
        }
        
        .tab-dot {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #dee2e6;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .tab-dot::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(152, 170, 231, 0.2);
            transition: all 0.4s ease;
        }
        
        .tab-dot:hover {
            transform: scale(1.3);
            background: #adb5bd;
        }
        
        .tab-dot:hover::after {
            width: 30px;
            height: 30px;
        }
        
        .tab-dot.active {
            background: var(--info-gradient);
            transform: scale(1.4);
            box-shadow: 0 4px 15px rgba(152, 170, 231, 0.4);
        }
        
        .tab-dot.active::after {
            width: 35px;
            height: 35px;
        }
        
        .tab-dot.completed {
            background: var(--success-gradient);
            box-shadow: 0 4px 15px rgba(143, 207, 168, 0.4);
        }
        
        .tab-dot.completed:hover {
            transform: scale(1.3);
        }
        
        .nav-buttons {
            display: flex;
            gap: 1rem;
            justify-content: space-between;
            padding: 2rem 0 0 0;
            margin-top: 2.5rem;
            border-top: 2px solid rgba(102, 126, 234, 0.1);
        }
        
        .btn-nav {
            padding: 1rem 2rem;
            border-radius: 14px;
            font-weight: 700;
            font-size: 1rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
            min-width: 140px;
        }
        
        .btn-nav::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.5s, height 0.5s;
        }
        
        .btn-nav:hover::before {
            width: 300px;
            height: 300px;
        }
        
        .btn-nav span {
            position: relative;
            z-index: 1;
        }
        
        .btn-prev {
            background: rgba(255, 255, 255, 0.9);
            color: var(--dark-gray);
            border-color: rgba(152, 170, 231, 0.2);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }
        
        .btn-prev:hover {
            background: white;
            color: var(--dark-gray);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
            border-color: rgba(152, 170, 231, 0.4);
        }
        
        .btn-next {
            background: var(--info-gradient);
            color: white;
            border-color: transparent;
            box-shadow: 0 6px 20px rgba(152, 170, 231, 0.4);
        }
        
        .btn-next:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(152, 170, 231, 0.5);
            color: white;
        }
        
        .btn-submit-final {
            background: var(--success-gradient);
            color: white;
            border-color: transparent;
            box-shadow: 0 6px 20px rgba(143, 207, 168, 0.4);
        }
        
        .btn-submit-final:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(143, 207, 168, 0.5);
            color: white;
        }
        
        .btn-nav:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05) !important;
        }
        
        /* Mobile responsive for tabs */
        @media (max-width: 768px) {
            .tab-navigation {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .nav-buttons {
                width: 100%;
                justify-content: space-between;
            }
            
            .btn-nav {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="survey-container">
            <div class="survey-header">
                <div class="logo-section">
                    <img src="{{ asset('images/logo.png') }}" alt="PRMSU ENGINEERING" class="logo">
                </div>
            <h1>PRMSU ENGINEERING</h1>
                <p>Student Feedback Survey</p>
                 
                <!-- Login Link Section -->
                <div class="mt-4" style="position: relative; z-index: 10;">
                    <p class="mb-3" style="color: rgba(255, 255, 255, 0.95); font-size: 0.95rem; font-weight: 500;">
                        <i class="fas fa-user-lock me-2" style="color: rgba(255, 255, 255, 0.9);"></i>
                        Faculty or Staff Member?
                    </p>
                    <a href="{{ route('login') }}" class="btn btn-outline-light" style="border-radius: 12px; padding: 0.75rem 2rem; font-weight: 600; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); border: 2px solid rgba(255, 255, 255, 0.4); position: relative; z-index: 10; backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.1); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
                        <i class="fas fa-sign-in-alt me-2"></i>Login to Dashboard
                    </a>
            </div>
                <!-- Multi-Step Wizard Indicator -->
                <div class="wizard-steps">
                    <div class="wizard-step active" data-step="1">
                        <div class="step-number">1</div>
                        <div class="step-label">Student Info</div>
                    </div>
                    <div class="wizard-step" data-step="2">
                        <div class="step-number">2</div>
                        <div class="step-label">Teacher & Subject</div>
                    </div>
                    <div class="wizard-step" data-step="3">
                        <div class="step-number">3</div>
                        <div class="step-label">Part 1</div>
                    </div>
                    @if(isset($questionsByPart['part2']) && $questionsByPart['part2']->count() > 0)
                    <div class="wizard-step" data-step="4">
                        <div class="step-number">4</div>
                        <div class="step-label">Part 2</div>
                    </div>
                    @endif
                    @if(isset($questionsByPart['part3']) && $questionsByPart['part3']->count() > 0)
                    <div class="wizard-step" data-step="5">
                        <div class="step-number">5</div>
                        <div class="step-label">Part 3</div>
                    </div>
                    @endif
                    <div class="wizard-step" data-step="6">
                        <div class="step-number">6</div>
                        <div class="step-label">Comments</div>
                    </div>
                </div>
               
        </div>
        
            <div class="survey-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
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

            <form method="POST" action="{{ route('survey.store') }}" id="surveyForm">
                @csrf
                
                <!-- Step 1: Student Information -->
                <div class="wizard-content active" data-step="1">
                    <div class="form-section">
                        <h4 class="mb-3" style="color: var(--dark-gray);">
                            <i class="fas fa-user me-2" style="color: var(--light-blue);"></i>
                            Student Information
                        </h4>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="student_name" class="form-label">Full Name (Optional)</label>
                                    <input type="text" class="form-control @error('student_name') is-invalid @enderror" 
                                           id="student_name" name="student_name" value="{{ old('student_name') }}" 
                                           placeholder="Enter your full name (optional)">
                                    @error('student_name')
                                        <div class="error-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="student_email" class="form-label">Email Address (Optional)</label>
                                    <input type="email" class="form-control @error('student_email') is-invalid @enderror" 
                                           id="student_email" name="student_email" value="{{ old('student_email') }}" 
                                           placeholder="Enter your email (optional)">
                                    @error('student_email')
                                        <div class="error-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="nav-buttons">
                        <button type="button" class="btn btn-nav btn-prev" disabled>
                            <i class="fas fa-arrow-left me-2"></i>Previous
                        </button>
                        <button type="button" class="btn btn-nav btn-next" id="step1Next">
                            Next<i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Step 2: Teacher & Subject Selection -->
                <div class="wizard-content" data-step="2">
                    <div class="form-section">
                        <h4 class="mb-3" style="color: var(--dark-gray);">
                            <i class="fas fa-chalkboard-teacher me-2" style="color: var(--light-blue);"></i>
                            Teacher & Subject Selection
                        </h4>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="teacher_id" class="form-label">Select Teacher</label>
                                <select class="form-select @error('teacher_id') is-invalid @enderror" 
                                        id="teacher_id" name="teacher_id" required>
                                    <option value="">Choose a teacher...</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->name }} - {{ $teacher->department }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('teacher_id')
                                    <div class="error-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="subject_id" class="form-label">Select Subject</label>
                                <select class="form-select @error('subject_id') is-invalid @enderror" 
                                        id="subject_id" name="subject_id" required disabled>
                                    <option value="">Choose a subject...</option>
                                </select>
                                @error('subject_id')
                                    <div class="error-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    </div>
                    
                    <div class="nav-buttons">
                        <button type="button" class="btn btn-nav btn-prev" id="step2Prev">
                            <i class="fas fa-arrow-left me-2"></i>Previous
                        </button>
                        <button type="button" class="btn btn-nav btn-next" id="step2Next">
                            Next<i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Step 3: Part 1 - Instructor Evaluation -->
                <div class="wizard-content" data-step="3">
                    <div class="form-section">
                        <h4 class="mb-3" style="color: var(--dark-gray);">
                            <i class="fas fa-star me-2" style="color: var(--light-blue);"></i>
                            Part 1: Instructor Evaluation
                        </h4>
                        
                        <div class="alert alert-info mb-3">
                            <strong>Rating Scale:</strong> 5 (Outstanding) | 4 (Satisfactory) | 3 (Neutral) | 2 (Unsatisfactory) | 1 (Poor)
                        </div>
                        
                        @if(isset($questionsByPart['part1']))
                        <div class="part-section">
                            @php
                                $part1Questions = $questionsByPart['part1'];
                                $sections = [
                                    'A. Commitment' => $part1Questions->where('order_number', '<=', 5),
                                    'B. Knowledge of Subject' => $part1Questions->where('order_number', '>', 5)->where('order_number', '<=', 10),
                                    'C. Teaching for Independent Learning' => $part1Questions->where('order_number', '>', 10)->where('order_number', '<=', 15),
                                    'D. Management of Learning' => $part1Questions->where('order_number', '>', 15)->where('order_number', '<=', 20)
                                ];
                            @endphp
                            
                            @foreach($sections as $sectionName => $sectionQuestions)
                                <div class="mb-4">
                                    <div class="section-subtitle">{{ $sectionName }}</div>
                                    @foreach($sectionQuestions as $question)
                                        <div class="form-group mb-3">
                                            <label class="question-label">
                                                <span class="question-number">{{ $question->order_number }}.</span> {{ $question->question_text }}
                                            </label>
                                            <div class="btn-group w-100" role="group">
                                                <input type="radio" class="btn-check" name="question_responses[{{ $question->id }}]" 
                                                       id="q{{ $question->id }}_5" value="5" required>
                                                <label class="btn btn-outline-success" for="q{{ $question->id }}_5">
                                                    <strong>5</strong><small>Outstanding</small>
                                                </label>
                                                
                                                <input type="radio" class="btn-check" name="question_responses[{{ $question->id }}]" 
                                                       id="q{{ $question->id }}_4" value="4" required>
                                                <label class="btn btn-outline-info" for="q{{ $question->id }}_4">
                                                    <strong>4</strong><small>Satisfactory</small>
                                                </label>
                                                
                                                <input type="radio" class="btn-check" name="question_responses[{{ $question->id }}]" 
                                                       id="q{{ $question->id }}_3" value="3" required>
                                                <label class="btn btn-outline-secondary" for="q{{ $question->id }}_3">
                                                    <strong>3</strong><small>Neutral</small>
                                                </label>
                                                
                                                <input type="radio" class="btn-check" name="question_responses[{{ $question->id }}]" 
                                                       id="q{{ $question->id }}_2" value="2" required>
                                                <label class="btn btn-outline-warning" for="q{{ $question->id }}_2">
                                                    <strong>2</strong><small>Unsatisfactory</small>
                                                </label>
                                                
                                                <input type="radio" class="btn-check" name="question_responses[{{ $question->id }}]" 
                                                       id="q{{ $question->id }}_1" value="1" required>
                                                <label class="btn btn-outline-danger" for="q{{ $question->id }}_1">
                                                    <strong>1</strong><small>Poor</small>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    
                    <div class="nav-buttons">
                        <button type="button" class="btn btn-nav btn-prev" id="step3Prev">
                            <i class="fas fa-arrow-left me-2"></i>Previous
                        </button>
                        <button type="button" class="btn btn-nav btn-next" id="step3Next">
                            Next<i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>
                
                @if(isset($questionsByPart['part2']) && $questionsByPart['part2']->count() > 0)
                <!-- Step 4: Part 2 - Difficulty Level -->
                <div class="wizard-content" data-step="4">
                    <div class="form-section">
                        <h4 class="mb-3" style="color: var(--dark-gray);">
                            <i class="fas fa-chart-line me-2" style="color: var(--golden-orange);"></i>
                            Part 2: Difficulty Level
                        </h4>
                        
                        <div class="alert alert-warning mb-3">
                            <strong>Rating Scale:</strong> 5 (Outstanding) | 4 (Satisfactory) | 3 (Neutral) | 2 (Unsatisfactory) | 1 (Poor)
                        </div>
                        
                        <div class="part-section part2">
                            @foreach($questionsByPart['part2'] as $question)
                                <div class="form-group mb-3">
                                    <label class="question-label">
                                        <span class="question-number">{{ $question->order_number }}.</span> {{ $question->question_text }}
                                    </label>
                                    <div class="btn-group w-100" role="group">
                                        <input type="radio" class="btn-check" name="question_responses[{{ $question->id }}]" 
                                               id="q{{ $question->id }}_5" value="5" required>
                                        <label class="btn btn-outline-success" for="q{{ $question->id }}_5">
                                            <strong>5</strong><small>Outstanding</small>
                                        </label>
                                        
                                        <input type="radio" class="btn-check" name="question_responses[{{ $question->id }}]" 
                                               id="q{{ $question->id }}_4" value="4" required>
                                        <label class="btn btn-outline-info" for="q{{ $question->id }}_4">
                                            <strong>4</strong><small>Satisfactory</small>
                                        </label>
                                        
                                        <input type="radio" class="btn-check" name="question_responses[{{ $question->id }}]" 
                                               id="q{{ $question->id }}_3" value="3" required>
                                        <label class="btn btn-outline-secondary" for="q{{ $question->id }}_3">
                                            <strong>3</strong><small>Neutral</small>
                                        </label>
                                        
                                        <input type="radio" class="btn-check" name="question_responses[{{ $question->id }}]" 
                                               id="q{{ $question->id }}_2" value="2" required>
                                        <label class="btn btn-outline-warning" for="q{{ $question->id }}_2">
                                            <strong>2</strong><small>Unsatisfactory</small>
                                        </label>
                                        
                                        <input type="radio" class="btn-check" name="question_responses[{{ $question->id }}]" 
                                               id="q{{ $question->id }}_1" value="1" required>
                                        <label class="btn btn-outline-danger" for="q{{ $question->id }}_1">
                                            <strong>1</strong><small>Poor</small>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="nav-buttons">
                        <button type="button" class="btn btn-nav btn-prev" id="step4Prev">
                            <i class="fas fa-arrow-left me-2"></i>Previous
                        </button>
                        <button type="button" class="btn btn-nav btn-next" id="step4Next">
                            Next<i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>
                @endif
                
                @if(isset($questionsByPart['part3']) && $questionsByPart['part3']->count() > 0)
                <!-- Step 5: Part 3 - Open Comments -->
                <div class="wizard-content" data-step="5">
                    <div class="form-section">
                        <h4 class="mb-3" style="color: var(--dark-gray);">
                            <i class="fas fa-comments me-2" style="color: var(--light-blue);"></i>
                            Part 3: Open Comments
                        </h4>
                        
                        <div class="alert alert-info mb-3">
                            <strong>Instructions:</strong> Please provide detailed responses to the following questions.
                        </div>
                        
                        <div class="part-section part3">
                            @foreach($questionsByPart['part3'] as $question)
                                <div class="form-group mb-3">
                                    <label for="comment_{{ $question->id }}" class="question-label">
                                        <span class="question-number">{{ $question->order_number }}.</span> {{ $question->question_text }}
                                    </label>
                                    <textarea class="form-control" 
                                              id="comment_{{ $question->id }}" 
                                              name="question_responses[{{ $question->id }}]" 
                                              rows="3" 
                                              placeholder="Please provide your response..."></textarea>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="nav-buttons">
                        <button type="button" class="btn btn-nav btn-prev" id="step5Prev">
                            <i class="fas fa-arrow-left me-2"></i>Previous
                        </button>
                        <button type="button" class="btn btn-nav btn-next" id="step5Next">
                            Next<i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>
                @endif
                
                <!-- Step 6: Additional Comments -->
                <div class="wizard-content" data-step="6">
                    <div class="form-section">
                        <h4 class="mb-3" style="color: var(--dark-gray);">
                            <i class="fas fa-comments me-2" style="color: var(--light-blue);"></i>
                            Additional Comments
                        </h4>
                        
                        <div class="form-group">
                            <label for="feedback_text" class="form-label">Any additional feedback or suggestions</label>
                            <textarea class="form-control @error('feedback_text') is-invalid @enderror" 
                                      id="feedback_text" name="feedback_text" rows="4" 
                                      placeholder="Share any additional thoughts or suggestions...">{{ old('feedback_text') }}</textarea>
                            @error('feedback_text')
                                <div class="error-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="nav-buttons">
                        <button type="button" class="btn btn-nav btn-prev" id="step6Prev">
                            <i class="fas fa-arrow-left me-2"></i>Previous
                        </button>
                        <button type="button" class="btn btn-nav btn-submit-final" id="btnSubmit">
                            <i class="fas fa-paper-plane me-2"></i>Submit Survey
                        </button>
                    </div>
                </div>

                </form>
            </div>
        </div>
        

        
        <div class="footer">
                            <p>&copy; {{ date('Y') }} PRMSU ENGINEERING. All rights reserved.</p>
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
            let currentStep = 1;
            const totalSteps = $('.wizard-step').length;
            
            // Multi-Step Wizard Navigation Functions
            function showStep(stepNumber) {
                // Hide all wizard content
                $('.wizard-content').removeClass('active');
                // Show current step
                $(`.wizard-content[data-step="${stepNumber}"]`).addClass('active');
                
                // Update wizard steps indicator
                $('.wizard-step').removeClass('active');
                $(`.wizard-step[data-step="${stepNumber}"]`).addClass('active');
                
                // Mark previous steps as completed
                $('.wizard-step').each(function() {
                    const stepNum = parseInt($(this).data('step'));
                    if (stepNum < stepNumber) {
                        $(this).addClass('completed');
                    } else if (stepNum > stepNumber) {
                        $(this).removeClass('completed');
                    }
                });
                
                // Scroll to top
                $('html, body').animate({
                    scrollTop: $('.survey-container').offset().top - 20
                }, 500);
            }
            
            function validateCurrentStep() {
                const currentStepElement = $(`.wizard-content[data-step="${currentStep}"]`);
                let isValid = true;
                
                // Check required fields in current step
                const requiredFields = currentStepElement.find('input[required], select[required], textarea[required]');
                
                requiredFields.each(function() {
                    const $field = $(this);
                    if ($field.attr('type') === 'radio') {
                        const name = $field.attr('name');
                        if (!$(`input[name="${name}"]:checked`).length) {
                            isValid = false;
                            return false;
                        }
                    } else if ($field.is('select')) {
                        if (!$field.val()) {
                            isValid = false;
                            return false;
                        }
                    } else {
                        if (!$field.val().trim()) {
                            isValid = false;
                            return false;
                        }
                    }
                });
                
                return isValid;
            }
            
            function goToNextStep() {
                if (validateCurrentStep()) {
                    if (currentStep < totalSteps) {
                        currentStep++;
                        showStep(currentStep);
                    }
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Please Complete All Required Fields',
                        text: 'Please fill in all required fields in this step before proceeding.',
                        confirmButtonColor: '#F5B445'
                    });
                }
            }
            
            function goToPrevStep() {
                if (currentStep > 1) {
                    currentStep--;
                    showStep(currentStep);
                }
            }
            
            // Navigation button handlers
            $('.btn-next').click(function() {
                goToNextStep();
            });
            
            $('.btn-prev').click(function() {
                goToPrevStep();
            });
            
            // Wizard step click handlers
            $('.wizard-step').click(function() {
                const stepNumber = parseInt($(this).data('step'));
                if (stepNumber <= currentStep || validateCurrentStep()) {
                    currentStep = stepNumber;
                    showStep(currentStep);
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Please Complete Current Step',
                        text: 'Please complete all required fields in the current step before jumping to another step.',
                        confirmButtonColor: '#F5B445'
                    });
                }
            });
            
            // Submit button handler
            $('#btnSubmit').click(function() {
                if (validateCurrentStep()) {
                    // Submit the form
                    $('#surveyForm').submit();
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Please Complete All Required Fields',
                        text: 'Please fill in all required fields before submitting the survey.',
                        confirmButtonColor: '#F5B445'
                    });
                }
            });
            
            // Initialize
            showStep(1);
            
            // Load subjects when teacher is selected
            $('#teacher_id').change(function() {
                const teacherId = $(this).val();
                const subjectSelect = $('#subject_id');
                
                if (teacherId) {
                    $.ajax({
                        url: '{{ route("survey.subjects-by-teacher") }}',
                        method: 'GET',
                        data: { teacher_id: teacherId },
                        success: function(response) {
                            subjectSelect.empty().append('<option value="">Choose a subject...</option>');
                            response.forEach(function(subject) {
                                subjectSelect.append(`<option value="${subject.id}">${subject.name} (${subject.subject_code})</option>`);
                            });
                            subjectSelect.prop('disabled', false);
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to load subjects. Please try again.',
                                confirmButtonColor: '#F16E70'
                            });
                        }
                    });
                } else {
                    subjectSelect.empty().append('<option value="">Choose a subject...</option>').prop('disabled', true);
                }
            });
            
            // Form submission with AJAX
            $('#surveyForm').submit(function(e) {
                e.preventDefault();
                
                const submitBtn = $('#btnSubmit');
                const originalText = submitBtn.html();
                
                submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Submitting...');
                
                $.ajax({
                    url: '{{ route("survey.store") }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thank You!',
                            text: 'Your feedback has been submitted successfully.',
                            confirmButtonColor: '#98AAE7'
                        }).then(function() {
                            window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred while submitting your feedback.';
                        
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            errorMessage = Object.values(errors).flat().join('\n');
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Submission Failed',
                            text: errorMessage,
                            confirmButtonColor: '#F16E70'
                        });
                        
                        submitBtn.prop('disabled', false).html(originalText);
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