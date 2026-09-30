<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<section class="min-vh-100 d-flex align-items-center pcu-hero">
    <div class="container py-5">
        <div class="row justify-content-center align-items-center g-5">

            <!-- Left: brand pitch -->
            <div class="col-lg-5 d-none d-lg-block text-white">
                <a href="/" class="text-decoration-none d-inline-flex align-items-center gap-2 text-white mb-4">
                    <i class="bi bi-mortarboard-fill fs-3 text-pcu-gold"></i>
                    <span class="fw-bold fs-5">PCU Borrow System</span>
                </a>

                <h1 class="display-5 fw-bold lh-1 mb-3">
                    Welcome back.
                </h1>
                <p class="text-white-50 mb-4" style="max-width: 420px;">
                    Sign in to manage your borrowings, track due dates, and browse the university inventory.
                </p>

                <ul class="list-unstyled text-white-50">
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-pcu-gold me-2"></i> Track active loans at a glance</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-pcu-gold me-2"></i> Get overdue alerts early</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-pcu-gold me-2"></i> View contracts and history</li>
                </ul>

                <div class="mt-5 pt-4 border-top border-secondary border-opacity-25">
                    <div class="text-white-50 small fst-italic">
                        <i class="bi bi-quote text-pcu-gold"></i>
                        Faith · Character · Service
                    </div>
                </div>
            </div>

            <!-- Right: login card -->
            <div class="col-md-7 col-lg-5">
                <div class="card border-0 shadow-lg rounded-4"
                     style="background: rgba(255,255,255,.98); backdrop-filter: blur(10px);">
                    <div class="card-body p-5">

                        <div class="text-center mb-4">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                 style="width: 64px; height: 64px; background: rgba(30,58,138,.1);">
                                <i class="bi bi-person-lock fs-2" style="color: var(--pcu-blue);"></i>
                            </div>
                            <h3 class="fw-bold mb-1">Sign in</h3>
                            <p class="text-muted small mb-0">Welcome back — let's get you in.</p>
                        </div>

                        <?php if (!empty($_SESSION['flash'])): ?>
                            <div class="alert alert-success rounded-3 small">
                                <i class="bi bi-check-circle me-1"></i>
                                <?= htmlspecialchars($_SESSION['flash']) ?>
                            </div>
                            <?php unset($_SESSION['flash']); ?>
                        <?php endif; ?>

                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger rounded-3 small">
                                <?php foreach ($errors as $err): ?>
                                    <div><i class="bi bi-exclamation-circle me-1"></i> <?= htmlspecialchars($err) ?></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="/login" novalidate>

                            <div class="mb-3">
                                <label for="email" class="form-label small fw-semibold text-muted">Email address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                        <i class="bi bi-envelope text-muted"></i>
                                    </span>
                                    <input type="email" name="email" id="email"
                                           class="form-control border-start-0 rounded-end-3"
                                           placeholder="name@pcu.edu.ph"
                                           value="<?= old($old ?? [], 'email') ?>"
                                           autocomplete="email" required autofocus>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label small fw-semibold text-muted">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                        <i class="bi bi-lock text-muted"></i>
                                    </span>
                                    <input type="password" name="password" id="password"
                                           class="form-control border-start-0 border-end-0"
                                           placeholder="Enter your password"
                                           autocomplete="current-password" required>
                                    <button type="button" class="input-group-text bg-light border-start-0 rounded-end-3"
                                            onclick="togglePassword()" tabindex="-1"
                                            style="cursor: pointer;">
                                        <i class="bi bi-eye text-muted" id="toggleIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input type="checkbox" name="remember" id="remember" class="form-check-input">
                                    <label for="remember" class="form-check-label small text-muted">Remember me</label>
                                </div>
                                <a href="/forgot-password" class="small text-decoration-none"
                                   style="color: var(--pcu-blue);">Forgot password?</a>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-semibold">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                            </button>
                        </form>

                        <div class="text-center my-4 position-relative">
                            <hr>
                            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 small text-muted">
                                or
                            </span>
                        </div>

                        <p class="text-center text-muted small mb-0">
                            Don't have an account?
                            <a href="/signup" class="text-decoration-none fw-semibold"
                               style="color: var(--pcu-blue);">Create one</a>
                        </p>

                    </div>
                </div>

                <p class="text-center text-white-50 small mt-3 mb-0">
                    <a href="/" class="text-white-50 text-decoration-none">
                        <i class="bi bi-arrow-left"></i> Back to home
                    </a>
                </p>

            </div>

        </div>
    </div>
</section>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('toggleIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}
</script>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>