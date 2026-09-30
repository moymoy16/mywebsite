<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'PCU Borrow System') ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="/assets/css/style.css" rel="stylesheet">

    <style>
        .navbar-pcu {
            background: linear-gradient(135deg, #0f1e5c 0%, #1e3a8a 100%);
            box-shadow: 0 4px 20px rgba(15, 30, 92, .15);
        }
        .navbar-pcu .navbar-brand {
            color: #fff;
            font-weight: 700;
            letter-spacing: .3px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        .navbar-pcu .navbar-brand i {
            color: #fbbf24;
            font-size: 26px;
            transition: transform .3s ease;
        }
        .navbar-pcu .navbar-brand:hover i {
            transform: rotate(-8deg) scale(1.05);
        }
        .navbar-pcu .nav-link {
            color: rgba(255, 255, 255, .75) !important;
            font-weight: 500;
            padding: 8px 16px !important;
            border-radius: 8px;
            transition: color .15s ease, background .15s ease;
            position: relative;
        }
        .navbar-pcu .nav-link:hover {
            color: #fff !important;
            background: rgba(255, 255, 255, .08);
        }
        .navbar-pcu .nav-link.active {
            color: #fff !important;
            font-weight: 600;
        }
        .navbar-pcu .nav-link.active::after {
            content: '';
            position: absolute;
            left: 16px;
            right: 16px;
            bottom: 2px;
            height: 2px;
            background: #fbbf24;
            border-radius: 1px;
        }
        .navbar-pcu .btn-nav-cta {
            background: #fbbf24;
            border: none;
            color: #1e3a8a;
            font-weight: 600;
            padding: 7px 18px;
            border-radius: 8px;
            transition: transform .15s ease, background .15s ease;
        }
        .navbar-pcu .btn-nav-cta:hover {
            background: #f59e0b;
            color: #fff;
            transform: translateY(-1px);
        }
        .navbar-pcu .btn-nav-outline {
            border: 1px solid rgba(255, 255, 255, .3);
            color: #fff;
            font-weight: 500;
            padding: 7px 18px;
            border-radius: 8px;
            transition: background .15s ease, border-color .15s ease;
        }
        .navbar-pcu .btn-nav-outline:hover {
            background: rgba(255, 255, 255, .12);
            border-color: rgba(255, 255, 255, .5);
            color: #fff;
        }
    </style>
</head>
<body>

<?php
    $currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $isActive = fn(string $p) => ($currentPath === $p || ($p !== '/' && str_starts_with($currentPath, $p))) ? 'active' : '';
?>

<nav class="navbar navbar-expand-lg navbar-pcu sticky-top py-3">
    <div class="container">

        <!-- Brand -->
        <a class="navbar-brand" href="/">
            <i class="bi bi-mortarboard-fill"></i>
            <span>PCU Borrow System</span>
        </a>

        <!-- Mobile toggle -->
        <button class="navbar-toggler border-0 shadow-none" type="button"
                data-bs-toggle="collapse" data-bs-target="#pcuNav"
                aria-controls="pcuNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list text-white fs-3"></i>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="pcuNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-1">

                <li class="nav-item">
                    <a class="nav-link <?= $isActive('/') ?>" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $isActive('/about') ?>" href="/about">About</a>
                </li>

                <?php if (!empty($_SESSION['user_id'])): ?>

                    <li class="nav-item">
                        <a class="nav-link <?= $isActive('/items') ?>" href="/items">
                            <i class="bi bi-grid me-1"></i> Browse Items
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $isActive('/dashboard') ?>" href="/dashboard">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn-nav-outline" href="/logout">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </a>
                    </li>

                <?php else: ?>

                    <li class="nav-item">
                        <a class="nav-link <?= $isActive('/login') ?>" href="/login">Login</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn-nav-cta" href="/signup">
                            Get Started <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </li>

                <?php endif; ?>

            </ul>
        </div>

    </div>
</nav>

<main>