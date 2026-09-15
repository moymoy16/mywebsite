<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'Browse') ?> — Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/items">
            <i class="bi bi-box-seam"></i> Borrow System
        </a>
        <ul class="navbar-nav ms-auto align-items-center gap-2">
            <!-- ═══ UPDATED: add dashboard link ═══ -->
            <li class="nav-item"><a class="nav-link" href="/dashboard" lass="navbar-brand fw-bold">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="/items">Browse Items</a></li>
            <li class="nav-item"><a class="nav-link" href="/my-borrowings">My Borrowings</a></li>
            <!-- ═══ END UPDATED ═══ -->
           <li class="nav-item">
                <span class="navbar-text text-white small me-2">
                    Hi, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Student') ?>
                </span>
            </li>
            <li class="nav-item">
                <a class="btn btn-outline-light btn-sm rounded-3" href="/logout">Logout</a>
            </li>
        </ul>
    </div>
</nav>

<main class="container my-4">