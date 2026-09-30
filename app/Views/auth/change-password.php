<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<section class="min-vh-100 d-flex align-items-center pcu-hero">
    <div class="container py-5">
        <div class="row justify-content-center align-items-center g-5">

            <!-- Left: pitch -->
            <div class="col-lg-5 d-none d-lg-block text-white">
                <a href="/" class="text-decoration-none d-inline-flex align-items-center gap-2 text-white mb-4">
                    <i class="bi bi-mortarboard-fill fs-3 text-pcu-gold"></i>
                    <span class="fw-bold fs-5">PCU Borrow System</span>
                </a>

                <span class="badge mb-3 px-3 py-2 rounded-pill"
                      style="background: rgba(251,191,36,.2); color: #fbbf24;">
                    <i class="bi bi-exclamation-triangle"></i> Action Required
                </span>

                <h1 class="display-5 fw-bold lh-1 mb-3">
                    Set your own<br>password.
                </h1>
                <p class="text-white-50 mb-4" style="max-width: 420px;">
                    Your account was accessed with a temporary password.
                    Choose a private one that only you know.
                </p>

                <ul class="list-unstyled text-white-50">
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-pcu-gold me-2"></i> At least 6 characters</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-pcu-gold me-2"></i> Mix letters, numbers, symbols</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-pcu-gold me-2"></i> Never share it with anyone</li>
                </ul>
            </div>

            <!-- Right: form -->
            <div class="col-md-8 col-lg-5">
                <div class="card border-0 shadow-lg rounded-4"
                     style="background: rgba(255,255,255,.98); backdrop-filter: blur(10px);">
                    <div class="card-body p-5">

                        <div class="text-center mb-4">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                 style="width: 64px; height: 64px; background: rgba(251, 191, 36, .15);">
                                <i class="bi bi-key fs-2" style="color: #b45309;"></i>
                            </div>
                            <h3 class="fw-bold mb-1">Change Password</h3>
                            <p class="text-muted small mb-0">
                                You must set a new password to continue.
                            </p>
                        </div>

                        <div class="alert rounded-3 small"
                             style="background: rgba(251,191,36,.12); border: 1px solid rgba(251,191,36,.35);">
                            <i class="bi bi-info-circle me-1"></i>
                            You're signed in with a <strong>temporary password</strong> assigned by an admin.
                            Set your own password below to activate your account fully.
                        </div>

                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger rounded-3 small">
                                <?php foreach ($errors as $err): ?>
                                    <div><i class="bi bi-exclamation-circle me-1"></i> <?= htmlspecialchars($err) ?></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="/change-password" novalidate>

                            <div class="mb-3">
                                <label for="password" class="form-label small fw-semibold text-muted">
                                    New password
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                        <i class="bi bi-lock text-muted"></i>
                                    </span>
                                    <input type="password" name="password" id="password"
                                           class="form-control border-start-0 border-end-0"
                                           placeholder="At least 6 characters"
                                           autocomplete="new-password" required autofocus
                                           oninput="updateStrength(this.value)">
                                    <button type="button" class="input-group-text bg-light border-start-0 rounded-end-3"
                                            onclick="togglePassword('password', 'toggleIcon1')"
                                            tabindex="-1" style="cursor:pointer;">
                                        <i class="bi bi-eye text-muted" id="toggleIcon1"></i>
                                    </button>
                                </div>
                                <div class="mt-2">
                                    <div class="progress" style="height: 4px;">
                                        <div id="strengthBar" class="progress-bar" style="width: 0%;"></div>
                                    </div>
                                    <div id="strengthText" class="small text-muted mt-1">&nbsp;</div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password_confirm" class="form-label small fw-semibold text-muted">
                                    Confirm new password
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                        <i class="bi bi-lock-fill text-muted"></i>
                                    </span>
                                    <input type="password" name="password_confirm" id="password_confirm"
                                           class="form-control border-start-0 border-end-0"
                                           placeholder="Re-enter your password"
                                           autocomplete="new-password" required
                                           oninput="checkMatch()">
                                    <button type="button" class="input-group-text bg-light border-start-0 rounded-end-3"
                                            onclick="togglePassword('password_confirm', 'toggleIcon2')"
                                            tabindex="-1" style="cursor:pointer;">
                                        <i class="bi bi-eye text-muted" id="toggleIcon2"></i>
                                    </button>
                                </div>
                                <div id="matchText" class="small mt-1">&nbsp;</div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-semibold">
                                <i class="bi bi-shield-check"></i> Set New Password
                            </button>
                        </form>

                        <div class="text-center my-4 position-relative">
                            <hr>
                            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 small text-muted">
                                or
                            </span>
                        </div>

                        <p class="text-center text-muted small mb-0">
                            <a href="/logout" class="text-decoration-none fw-semibold"
                               style="color: var(--pcu-blue);">
                                <i class="bi bi-box-arrow-right"></i> Sign out instead
                            </a>
                        </p>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}

function updateStrength(val) {
    const bar  = document.getElementById('strengthBar');
    const text = document.getElementById('strengthText');
    let score = 0;
    if (val.length >= 6) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const levels = [
        { w: '0%',   c: '',           t: '' },
        { w: '25%',  c: 'bg-danger',  t: 'Weak' },
        { w: '50%',  c: 'bg-warning', t: 'Fair' },
        { w: '75%',  c: 'bg-info',    t: 'Good' },
        { w: '100%', c: 'bg-success', t: 'Strong' },
    ];
    const lvl = levels[score];
    bar.style.width = lvl.w;
    bar.className   = 'progress-bar ' + lvl.c;
    text.textContent = lvl.t;
    text.className   = 'text-' + (lvl.c ? lvl.c.replace('bg-', '') : 'muted') + ' small mt-1';
}

function checkMatch() {
    const p1 = document.getElementById('password').value;
    const p2 = document.getElementById('password_confirm').value;
    const el = document.getElementById('matchText');
    if (p2 === '') { el.textContent = ''; return; }
    if (p1 === p2) {
        el.textContent = '✓ Passwords match';
        el.className   = 'small mt-1 text-success';
    } else {
        el.textContent = '✗ Passwords do not match';
        el.className   = 'small mt-1 text-danger';
    }
}
</script>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>