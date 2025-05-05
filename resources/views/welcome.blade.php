<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Selamat Datang</title>
    <!-- Minimal CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
        }

        .welcome-container {
            text-align: center;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .welcome-container h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .welcome-container p {
            font-size: 1rem;
            color: #6c757d;
        }

        .btn-logout {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="welcome-container">
        <h1>Selamat Datang,
            <p>Anda berhasil login ke sistem.</p>
            <a href="{{ route('logout') }}" class="btn btn-danger btn-logout">Logout</a>
    </div>
</body>

</html>