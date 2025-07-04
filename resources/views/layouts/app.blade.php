<!-- App Layout (layouts/app.blade.php) -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - {{ $title ?? '' }}</title>

    <!-- Favicon -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>📅</text></svg>">

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #0d6efd;
            --hover-color: #0b5ed7;
            --light-gray: #f8f9fa;
            --dark-gray: #495057;
            --border-color: #dee2e6;
            --success-color: #198754;
            --warning-color: #fd7e14;
            --danger-color: #dc3545;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--light-gray);
        }
        
        .navbar-custom {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 1rem;
        }
        
        .nav-link {
            color: var(--dark-gray);
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            margin: 0 0.25rem;
            position: relative;
        }
        
        .nav-link:hover, .nav-link.active {
            background-color: var(--primary-color);
            color: white !important;
        }
        
        .nav-link i {
            margin-right: 0.5rem;
        }
        
        .navbar-brand {
            font-weight: 600;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .navbar-brand:hover {
            color: var(--hover-color);
        }
        
        .navbar-brand i {
            margin-right: 0.5rem;
        }
        
        /* Profile Avatar */
        .profile-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--hover-color));
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin-right: 0.5rem;
            font-size: 0.9rem;
        }
        
        /* Enhanced Dropdown Styles */
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-radius: 12px;
            padding: 0.5rem 0;
            margin-top: 0.5rem;
            min-width: 200px;
        }
        
        .dropdown-item {
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            display: flex;
            align-items: center;
        }
        
        .dropdown-item:hover, .dropdown-item:focus {
            background-color: var(--primary-color);
            color: white !important;
        }
        
        .dropdown-item i {
            width: 20px;
            text-align: center;
        }
        
        /* Custom Page Content Styles */
        .main-content {
            padding: 2rem 0;
            min-height: calc(100vh - 160px);
        }
        
        .page-header {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .page-header h1 {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .page-header p {
            color: var(--dark-gray);
            margin-bottom: 0;
        }
        
        /* Card Styles */
        .custom-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border: none;
            transition: all 0.3s ease;
        }
        
        .custom-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }
        
        .custom-card .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--hover-color));
            color: white;
            border-radius: 12px 12px 0 0;
            padding: 1.5rem;
            border: none;
        }
        
        .custom-card .card-body {
            padding: 2rem;
        }
        
        /* Form Styles */
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--dark-gray);
            margin-bottom: 0.5rem;
        }
        
        .form-control {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }
        
        /* Button Styles */
        .btn-custom-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--hover-color));
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white !important;
        }
        
        .btn-custom-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.3);
        }
        
        .btn-custom-secondary {
            background: white;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white !important;
        }
        
        .btn-custom-secondary:hover {
            background: var(--primary-color);
            color: white;
        }
        
        .btn-custom-danger {
            background: linear-gradient(135deg, var(--danger-color), #b02a37);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white !important;
        }
        
        .btn-custom-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
        }
        
        /* Alert Styles */
        .alert-custom {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .alert-success {
            background: linear-gradient(135deg, rgba(25, 135, 84, 0.1), rgba(25, 135, 84, 0.05));
            color: var(--success-color);
            border-left: 4px solid var(--success-color);
        }
        
        /* Footer */
        .footer-custom {
            background: white;
            border-top: 1px solid #e9ecef;
            padding: 2rem 0;
            margin-top: 3rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .navbar-collapse {
                padding: 1rem 0;
                margin-top: 1rem;
                border-top: 1px solid var(--border-color);
            }
            
            .nav-link {
                margin: 0.25rem 0;
                text-align: center;
            }
            
            .page-header {
                padding: 1.5rem;
            }
            
            .custom-card .card-body {
                padding: 1.5rem;
            }
        }
    </style>
    
    @stack('styles')
</head>

<body>
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <div class="container mt-4">
                <div class="page-header">
                    {{ $header }}
                </div>
            </div>
        @endif

        <!-- Page Content -->
        <main class="main-content">
            <div class="container">
                {{ $slot }}
            </div>
        </main>
        
        <!-- Footer -->
        <footer class="footer-custom">
            <div class="container text-center text-muted">
                <p class="mb-0">© {{ date('Y') }} Appointments Calendar. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>