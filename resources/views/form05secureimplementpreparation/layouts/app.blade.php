<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Secure Implement Preparation')</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f9;
            color: #333;
        }

        .navbar {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-title {
            font-size: 18px;
            font-weight: bold;
            color: #1f2937;
        }

        .navbar-subtitle {
            font-size: 12px;
            color: #6b7280;
            margin-top: 4px;
        }

        .page-container {
            width: 95%;
            max-width: 1200px;
            margin: 30px auto;
        }

        .card {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 25px;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-warning {
            background: #f59e0b;
            color: white;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
        }

        .btn-info {
            background: #0891b2;
            color: white;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            padding: 12px 16px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f3f4f6;
            text-align: left;
            padding: 12px;
            border-bottom: 2px solid #e5e7eb;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        input,
        textarea,
        select {
            font-family: inherit;
        }
    </style>

    @stack('styles')
</head>

<body>

    <div class="navbar">
        <div>
            <div class="navbar-title">
                Sistem Informasi
            </div>

            <div class="navbar-subtitle">
                Formulir Secure Implement Preparation
            </div>
        </div>

    </div>

    <main class="page-container">
        @yield('content')
    </main>

    @stack('scripts')

</body>
</html>