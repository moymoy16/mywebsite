<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'Admin') ?> — PCU Admin</title>

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

        /* ═══ Admin navbar ═══ */
        .navbar-admin {
            background: linear-gradient(135deg, #0f1e5c 0%, #1e3a8a 100%);
            box-shadow: 0 4px 20px rgba(15, 30, 92, .15);
        }
        .navbar-admin .navbar-brand {
            color: #fff;
            font-weight: 700;
            letter-spacing: .3px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        .navbar-admin .navbar-brand i {
            color: #fbbf24;
            font-size: 24px;
        }
        .navbar-admin .admin-pill {
            display: inline-block;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .8px;
            text-transform: uppercase;
            padding: 3px 9px;
            border-radius: 999px;
            background: rgba(251, 191, 36, .2);
            color: #fbbf24;
            border: 1px solid rgba(251, 191, 36, .35);
            margin-left: 4px;
        }
        .navbar-admin .nav-link {
            color: rgba(255, 255, 255, .75) !important;
            font-weight: 500;
            padding: 8px 14px !important;
            border-radius: 8px;
            transition: color .15s ease, background .15s ease;
            position: relative;
        }
        .navbar-admin .nav-link:hover {
            color: #fff !important;
            background: rgba(255, 255, 255, .08);
        }
        .navbar-admin .nav-link.active {
            color: #fff !important;
            font-weight: 600;
        }
        .navbar-admin .nav-link.active::after {
            content: '';
            position: absolute;
            left: 14px;
            right: 14px;
            bottom: 2px;
            height: 2px;
            background: #fbbf24;
            border-radius: 1px;
        }

        /* ═══ User chip ═══ */
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

        /* ═══ Logout icon button ═══ */
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

        /* ═══ Card hover ═══ */
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

    // Fetch badges once
    $__pendingBorrowings = 0;
    $__pendingUsers = 0;
    try {
        $__pendingBorrowings = (new \App\Models\Borrowing())->countByStatus('pending');
    } catch (\Throwable $e) {}
    try {
        $__pendingUsers  = (new \App\Models\PasswordReset())->pendingCount();
        $__pendingUsers += (new \App\Models\ProfileChangeRequest())->pendingCount();
    } catch (\Throwable $e) {}
?>

<nav class="navbar navbar-expand-lg navbar-admin sticky-top py-2">
    <div class="container-fluid px-4">

        <!-- Brand -->
        <a class="navbar-brand" href="/admin/dashboard">
            <i class="bi bi-shield-lock-fill"></i>
            <span>PCU Admin</span>
            <span class="admin-pill">Admin</span>
        </a>

        <!-- Mobile toggle -->
        <button class="navbar-toggler border-0 shadow-none" type="button"
                data-bs-toggle="collapse" data-bs-target="#adminNav"
                aria-controls="adminNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list text-white fs-3"></i>
        </button>

        <div class="collapse navbar-collapse" id="adminNav">
            <ul class="navbar-nav mx-auto align-items-lg-center gap-1">

                <li class="nav-item">
                    <a class="nav-link <?= $isActive('/admin/dashboard') ?>" href="/admin/dashboard">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $isActive('/admin/items') ?>" href="/admin/items">
                        <i class="bi bi-box-seam me-1"></i> Inventory
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $isActive('/admin/borrowings') ?>" href="/admin/borrowings">
                        <i class="bi bi-arrow-left-right me-1"></i> Borrowings
                        <?php if ($__pendingBorrowings > 0): ?>
                            <span class="badge bg-warning text-dark ms-1"><?= $__pendingBorrowings ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $isActive('/admin/contracts') ?>" href="/admin/contracts">
                        <i class="bi bi-file-earmark-text me-1"></i> Contracts
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $isActive('/admin/users') ?>" href="/admin/users">
                        <i class="bi bi-people me-1"></i> Users
                        <?php if ($__pendingUsers > 0): ?>
                            <span class="badge bg-warning text-dark ms-1"><?= $__pendingUsers ?></span>
                        <?php endif; ?>
                    </a>
                </li>

            </ul>

            <div class="d-flex align-items-lg-center gap-2 mt-3 mt-lg-0">

                <!-- User chip -->
                <div class="user-chip">
                    <span class="avatar"><?= strtoupper(substr($_SESSION['user_name'] ?? 'A', 0, 1)) ?></span>
                    <span class="small d-none d-lg-inline">
                        <?= htmlspecialchars(explode(' ', trim($_SESSION['user_name'] ?? 'Admin'))[0]) ?>
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