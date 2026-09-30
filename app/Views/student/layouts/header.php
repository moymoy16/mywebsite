<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'Dashboard') ?> — PCU Borrow System</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="/assets/css/style.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f8fafc;
            min-height: 100vh;
        }
        h1, h2, h3, h4, h5 { letter-spacing: -0.02em; }

        .navbar-student {
            background: linear-gradient(135deg, #0f1e5c 0%, #1e3a8a 100%);
            box-shadow: 0 4px 20px rgba(15, 30, 92, .15);
        }
        .navbar-student .navbar-brand {
            color: #fff;
            font-weight: 700;
            letter-spacing: .3px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        .navbar-student .navbar-brand i {
            color: #fbbf24;
            font-size: 24px;
        }
        .navbar-student .nav-link {
            color: rgba(255, 255, 255, .75) !important;
            font-weight: 500;
            padding: 8px 14px !important;
            border-radius: 8px;
            transition: color .15s ease, background .15s ease;
            position: relative;
        }
        .navbar-student .nav-link:hover {
            color: #fff !important;
            background: rgba(255, 255, 255, .08);
        }
        .navbar-student .nav-link.active {
            color: #fff !important;
            font-weight: 600;
        }
        .navbar-student .nav-link.active::after {
            content: '';
            position: absolute;
            left: 14px;
            right: 14px;
            bottom: 2px;
            height: 2px;
            background: #fbbf24;
            border-radius: 1px;
        }

        .user-chip {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, .08);
            padding: 6px 14px 6px 6px;
            border-radius: 999px;
            color: #fff;
        }
        .user-chip .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(251, 191, 36, .25);
            color: #fbbf24;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
        }

        .btn-logout {
            border: 1px solid rgba(255, 255, 255, .25);
            color: #fff;
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: background .15s ease, border-color .15s ease;
        }
        .btn-logout:hover {
            background: rgba(255, 255, 255, .12);
            border-color: rgba(255, 255, 255, .5);
            color: #fff;
        }

        .card {
            transition: transform .15s ease, box-shadow .15s ease;
        }
        .card:hover {
            box-shadow: 0 .75rem 1.5rem rgba(15, 23, 42, .08) !important;
        }
    </style>
</head>
<body>

<?php
    $currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $isActive = fn(string $p) => ($currentPath === $p || str_starts_with($currentPath, $p)) ? 'active' : '';
    $__cartCount = count($_SESSION['borrow_cart'] ?? []);
?>

<nav class="navbar navbar-expand-lg navbar-student sticky-top py-2">
    <div class="container">

        <!-- Brand -->
        <a class="navbar-brand" href="/dashboard">
            <i class="bi bi-mortarboard-fill"></i>
            <span>PCU Borrow System</span>
        </a>

        <!-- Mobile toggle -->
        <button class="navbar-toggler border-0 shadow-none" type="button"
                data-bs-toggle="collapse" data-bs-target="#studentNav"
                aria-controls="studentNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list text-white fs-3"></i>
        </button>

        <div class="collapse navbar-collapse" id="studentNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-1">

                <li class="nav-item">
                    <a class="nav-link <?= $isActive('/dashboard') ?>" href="/dashboard">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $isActive('/items') ?>" href="/items">
                        <i class="bi bi-grid me-1"></i> Browse Items
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $isActive('/my-borrowings') ?>" href="/my-borrowings">
                        <i class="bi bi-book me-1"></i> My Borrowings
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $isActive('/profile') ?>" href="/profile">
                        <i class="bi bi-person me-1"></i> Profile
                    </a>
                </li>

                <!-- Cart -->
                <li class="nav-item">
                    <a class="nav-link <?= $isActive('/borrow/cart') ?>" href="/borrow/cart">
                        <i class="bi bi-cart3 me-1"></i> Cart
                        <?php if ($__cartCount > 0): ?>
                            <span class="badge bg-warning text-dark ms-1"><?= $__cartCount ?></span>
                        <?php endif; ?>
                    </a>
                </li>

            </ul>

            <div class="d-flex align-items-lg-center gap-2 ms-lg-3 mt-3 mt-lg-0">

                <!-- User chip -->
                <div class="user-chip">
                    <span class="avatar"><?= strtoupper(substr($_SESSION['user_name'] ?? 'S', 0, 1)) ?></span>
                    <span class="small d-none d-lg-inline">
                        <?= htmlspecialchars(explode(' ', trim($_SESSION['user_name'] ?? 'Student'))[0]) ?>
                    </span>
                </div>

                <!-- Logout -->
                <a href="/logout" class="btn-logout" title="Logout">
                    <i class="bi bi-box-arrow-right"></i>
                </a>

            </div>
        </div>

    </div>
</nav>

<main>