<?php
$isAdmin  = !empty($_SESSION['user_id']) && ($_SESSION['role'] ?? '') === 'admin';
$isLogged = !empty($_SESSION['user_id']);

if ($isAdmin) {
    require BASE_PATH . '/app/Views/admin/layouts/header.php';
} elseif ($isLogged) {
    require BASE_PATH . '/app/Views/student/layouts/header.php';
} else {
    require BASE_PATH . '/app/Views/layouts/header.php';
}
?>

<section class="py-5 d-flex align-items-center"
         style="min-height: 70vh; background: linear-gradient(135deg, #0f1e5c 0%, #1e3a8a 60%, #2d4fb8 100%); color: #fff;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">

                <!-- Big 404 -->
                <div class="display-1 fw-bold lh-1 mb-3"
                     style="font-size: clamp(80px, 14vw, 160px);
                            background: linear-gradient(135deg, #fbbf24 0%, #fcd34d 100%);
                            -webkit-background-clip: text;
                            -webkit-text-fill-color: transparent;
                            background-clip: text;">
                    404
                </div>

                <!-- Icon -->
                <div class="mb-4">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle"
                          style="width: 80px; height: 80px; background: rgba(251,191,36,.2);">
                        <i class="bi bi-compass fs-1" style="color: #fbbf24;"></i>
                    </span>
                </div>

                <h1 class="display-6 fw-bold mb-3 text-white">Page not found</h1>
                <p class="text-white-50 mb-5 mx-auto" style="max-width: 520px;">
                    The page you're looking for doesn't exist, was moved, or the link you followed is broken.
                    Let's get you back on track.
                </p>

                <!-- Action buttons -->
                <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">

                    <?php if ($isAdmin): ?>
                        <a href="/admin/dashboard" class="btn btn-gold btn-lg rounded-3 px-4">
                            <i class="bi bi-speedometer2"></i> Admin Dashboard
                        </a>
                        <a href="/admin/items" class="btn btn-outline-light btn-lg rounded-3 px-4">
                            <i class="bi bi-box-seam"></i> Inventory
                        </a>

                    <?php elseif ($isLogged): ?>
                        <a href="/dashboard" class="btn btn-gold btn-lg rounded-3 px-4">
                            <i class="bi bi-speedometer2"></i> My Dashboard
                        </a>
                        <a href="/items" class="btn btn-outline-light btn-lg rounded-3 px-4">
                            <i class="bi bi-grid"></i> Browse Items
                        </a>

                    <?php else: ?>
                        <a href="/" class="btn btn-gold btn-lg rounded-3 px-4">
                            <i class="bi bi-house"></i> Go Home
                        </a>
                        <a href="/login" class="btn btn-outline-light btn-lg rounded-3 px-4">
                            <i class="bi bi-box-arrow-in-right"></i> Sign In
                        </a>
                    <?php endif; ?>

                </div>

                <!-- Helpful links -->
                <div class="pt-4" style="border-top: 1px solid rgba(255,255,255,.15);">
                    <div class="text-white-50 small mb-3">Or try one of these:</div>
                    <div class="d-flex flex-wrap justify-content-center gap-3 small">
                        <?php if ($isAdmin): ?>
                            <a href="/admin/borrowings" class="text-decoration-none text-white-50">
                                <i class="bi bi-arrow-left-right"></i> Borrowings
                            </a>
                            <a href="/admin/contracts" class="text-decoration-none text-white-50">
                                <i class="bi bi-file-earmark-text"></i> Contracts
                            </a>
                            <a href="/admin/users" class="text-decoration-none text-white-50">
                                <i class="bi bi-people"></i> Users
                            </a>
                        <?php elseif ($isLogged): ?>
                            <a href="/my-borrowings" class="text-decoration-none text-white-50">
                                <i class="bi bi-book"></i> My Borrowings
                            </a>
                            <a href="/profile" class="text-decoration-none text-white-50">
                                <i class="bi bi-person"></i> Profile
                            </a>
                        <?php else: ?>
                            <a href="/about" class="text-decoration-none text-white-50">
                                <i class="bi bi-info-circle"></i> About
                            </a>
                            <a href="/signup" class="text-decoration-none text-white-50">
                                <i class="bi bi-person-plus"></i> Sign Up
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?php
if ($isAdmin) {
    require BASE_PATH . '/app/Views/admin/layouts/footer.php';
} elseif ($isLogged) {
    require BASE_PATH . '/app/Views/student/layouts/footer.php';
} else {
    require BASE_PATH . '/app/Views/layouts/footer.php';
}
?>