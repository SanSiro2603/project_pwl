<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Selamat Datang</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .container {
            flex: 1 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1.5rem;
            /* ini supaya height sesuai konten, bukan stretch seluruh tinggi */
            min-height: auto; 
        }

        .card {
            background-color: white;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
                        0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border-radius: 1rem;
            border: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            width: auto; /* biarkan sesuai konten */
            max-width: 40rem; /* maksimal 640px */
            overflow: hidden;
        }

        /* di media query tetap fleksibel */
        @media (min-width: 768px) {
            .card {
                flex-direction: row;
                max-width: none; /* hilangkan max-width untuk fleksibel */
                width: auto;
                /* optional: batasi lebar maksimal di desktop kalau mau */
                max-width: 640px;
            }
        }

        .illustration {
            display: none;
            background-color: #eff6ff; /* bg-blue-50 */
            padding: 2.5rem; /* p-10 */
            justify-content: center;
            align-items: center;
            flex: 1;
        }
        @media (min-width: 768px) {
            .illustration {
                display: flex;
            }
        }
        .illustration img {
            max-width: 20rem; /* max-w-xs */
            width: 100%;
            height: auto;
        }
        .content {
            flex: 1;
            padding: 2.5rem; /* p-10 */
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .btn {
            padding-left: 1.5rem; /* px-6 */
            padding-right: 1.5rem;
            padding-top: 0.5rem; /* py-2 */
            padding-bottom: 0.5rem;
            border-radius: 0.5rem; /* rounded-lg */
            font-weight: 600; /* font-semibold */
            transition: background-color 0.3s, color 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary {
            background-color: #2563eb; /* bg-blue-600 */
            color: white;
        }
        .btn-primary:hover {
            background-color: #1d4ed8; 
        }
        .btn-outline {
            border: 1px solid #2563eb;
            color: #2563eb;
        }
        .btn-outline:hover {
            background-color: #2563eb;
            color: white;
        }
        .button-group {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem; /* mb-6 */
        }
        footer {
            flex-shrink: 0;
            text-align: center;
            color: #9ca3af; /* text-gray-400 */
            font-size: 0.875rem; /* text-sm */
            padding: 1rem 0;
        }
    </style>
</head>
<body>
    <main class="container">
        <div class="card">
            <!-- Ilustrasi -->
            <div class="illustration" aria-hidden="true">
               <img src="img/branding.jpg" alt="Login Illustration" />
            </div>

            <!-- Konten -->
            <div class="content">
                <h1 class="text-4xl font-bold text-gray-900 mb-3">Selamat Datang 👋</h1>
                <p class="mb-6 text-gray-600 text-lg">Masuk atau daftar untuk mulai menggunakan aplikasi.</p>

                <div class="button-group">
                   
                        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-outline">Daftar</a>
    
                </div>
            </div>
        </div>
    </main>

    <footer>
        © {{ date('Y') }} Aplikasi Laravel. All rights reserved.
    </footer>
</body>
</html>
