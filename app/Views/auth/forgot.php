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
                    Forgot your<br>password?
                </h1>
                <p class="text-white-50 mb-4" style="max-width: 420px;">
                    Enter your email and an administrator will review your request.
                    You'll be given a temporary password to sign in.
                </p>

                <ul class="list-unstyled text-white-50">
                    <li class="mb-2"><i class="bi bi-person-check-fill text-pcu-gold me-2"></i> Handled by an admin</li>
                    <li class="mb-2"><i class="bi bi-clock-history text-pcu-gold me-2"></i> Requests stay pending until resolved</li>
                    <li class="mb-2"><i class="bi bi-shield-check text-pcu-gold me-2"></i> Temporary passwords only</li>
                </ul>
            </div>

            <!-- Right: form card -->
            <div class="col-md-8 col-lg-5">
                <div class="card border-0 shadow-lg rounded-4"
                     style="background: rgba(255,255,255,.98); backdrop-filter: blur(10px);">
                    <div class="card-body p-5">

                        <div class="text-center mb-4">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                 style="width: 64px; height: 64px; background: rgba(30, 58, 138, .1);">
                                <i class="bi bi-key fs-2" style="color: var(--pcu-blue);"></i>
                            </div>
                            <h3 class="fw-bold mb-1">Reset Password</h3>
                            <p class="text-muted small mb-0">
                                Submit a request to your administrator.
                            </p>
                        </div>

                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger rounded-3 small">
                                <?php foreach ($errors as $err): ?>
                                    <div><i class="bi bi-exclamation-circle me-1"></i> <?= htmlspecialchars($err) ?></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($sent)): ?>

                            <div class="alert alert-success rounded-3 small mb-4">
                                <i class="bi bi-check-circle me-1"></i>
                                If an account exists for <strong><?= htmlspecialchars($email) ?></strong>,
                                your request has been submitted.
                            </div>

                            <div class="alert alert-light border rounded-3 small mb-4">
                                <div class="fw-semibold mb-2">
                                    <i class="bi bi-info-circle"></i> What happens next?
                                </div>
                                <ol class="mb-0 ps-3">
                                    <li>An administrator will review your request.</li>
                                    <li>They'll assign you a temporary password.</li>
                                    <li>Sign in with it and set your own password.</li>
                                </ol>
                            </div>

                            <a href="/login" class="btn btn-primary w-100 py-2 rounded-3 fw-semibold">
                                <i class="bi bi-box-arrow-in-right"></i> Back to Sign In
                            </a>

                        <?php else: ?>

                            <form method="POST" action="/forgot-password" novalidate>

                                <div class="mb-3">
                                    <label for="email" class="form-label small fw-semibold text-muted">
                                        Email address
                                    </label>
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

                                <div class="mb-4">
                                    <label for="note" class="form-label small fw-semibold text-muted">
                                        Message to admin <span class="fw-normal">(optional)</span>
                                    </label>
                                    <textarea name="note" id="note" rows="2"
                                              class="form-control rounded-3"
                                              placeholder="e.g. I'm in section 21A3, student ID 2022-55052"></textarea>
                                    <div class="form-text">
                                        <i class="bi bi-info-circle"></i> Helps the admin verify you faster.
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-semibold">
                                    <i class="bi bi-send"></i> Submit Reset Request
                                </button>
                            </form>

                        <?php endif; ?>

                        <div class="text-center my-4 position-relative">
                            <hr>
                            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 small text-muted">
                                or
                            </span>
                        </div>

                        <p class="text-center text-muted small mb-0">
                            Remember your password?
                            <a href="/login" class="text-decoration-none fw-semibold"
                               style="color: var(--pcu-blue);">Sign in</a>
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

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>