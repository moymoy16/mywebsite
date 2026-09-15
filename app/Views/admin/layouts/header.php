<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'Admin') ?> — Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/admin/dashboard">Admin Panel</a>
        <ul class="navbar-nav ms-auto align-items-center gap-2">
            <li class="nav-item"><a class="nav-link" href="/admin/dashboard">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="/admin/items">Inventory</a></li>
            <?php
                $__navPending = 0;
                try {
                    $__navPending = (new \App\Models\Borrowing())->countByStatus('pending');
                } catch (\Throwable $e) {}
            ?>
            <li class="nav-item">
                <a class="nav-link" href="/admin/borrowings">
                    Borrowings
                    <?php if ($__navPending > 0): ?>
                        <span class="badge bg-warning text-dark ms-1"><?= $__navPending ?></span>
                    <?php endif; ?>
                </a>
            </li>
            <li class="nav-item"><a class="nav-link" href="/admin/contracts">Contracts</a></li>
            <li class="nav-item">
                <a class="btn btn-outline-light btn-sm rounded-3" href="/logout">Logout</a>
            </li>
        </ul>
    </div>
</nav>

<main class="container my-4">