<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'MySite — Borrow System') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="/assets/css/style.css" rel="stylesheet">
    <style>
        /* Landing-page only polish */
        .navbar-landing {
            background: rgba(15, 23, 42, .85);
            backdrop-filter: blur(10px);
            transition: background .3s ease;
        }
        .navbar-landing .navbar-brand {
            font-weight: 700;
            letter-spacing: .5px;
            color: #fff;
        }
        .navbar-landing .nav-link {
            color: rgba(255, 255, 255, .8);
            font-weight: 500;
            transition: color .2s ease;
        }
        .navbar-landing .nav-link:hover {
            color: #fff;
        }
        body {
            background: #f8fafc;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-landing sticky-top py-3 shadow-sm">
    <div class="container">

        <a class="navbar-brand d-flex align-items-center gap-2" href="/">
            <i class="bi bi-box-seam fs-4"></i>
            <span>Borrow System</span>
        </a>

        <button class="navbar-toggler border-0" type="button"
                data-bs-toggle="collapse" data-bs-target="#landingNav"
                aria-controls="landingNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="landingNav">
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="/about">About</a></li>

                <?php if (!empty($_SESSION['user_id'])): ?>
                    <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/dashboard">
                                <i class="bi bi-speedometer2"></i> Admin
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/dashboard">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm rounded-3 px-3" href="/logout">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm rounded-3 px-3 fw-semibold" href="/signup">
                            Get Started <i class="bi bi-arrow-right"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

    </div>
</nav>

<main>