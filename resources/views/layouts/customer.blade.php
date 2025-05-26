<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Customer Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('customer.dashboard') }}">Booking Studio</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-1" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle" style ="font-size: 25px;"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
            </ul>
        </div>
    </div>
</nav>
<style>
    .quick-action {
        background-color: #fff;
        transition: all 0.3s ease;
        transform-origin: center;
        font-size: 1.1rem;
        padding: 0.8rem 1.5rem;
    }

    .quick-action:hover {
        transform: scale(1.05);
        color: #fff !important;
    }

    .quick-action[data-bg="primary"]:hover {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .quick-action[data-bg="success"]:hover {
        background-color: #198754;
        border-color: #198754;
    }

    .quick-action[data-bg="warning"]:hover {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #000 !important;
    }
</style>


    <main class="container">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
