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

                <h1 class="display-5 fw-bold lh-1 mb-3">Start borrowing<br>in under a minute.</h1>
                <p class="text-white-50 mb-4" style="max-width: 420px;">
                    Create a free account with your student information to borrow from the university inventory.
                </p>

                <ul class="list-unstyled text-white-50">
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-pcu-gold me-2"></i> Free for enrolled students</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-pcu-gold me-2"></i> No paperwork, no fees</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-pcu-gold me-2"></i> Track due dates automatically</li>
                </ul>

                <div class="mt-5 pt-4" style="border-top: 1px solid rgba(255,255,255,.15);">
                    <div class="text-white-50 small">
                        <i class="bi bi-shield-check text-pcu-gold me-1"></i>
                        Your data is private and only visible to administrators.
                    </div>
                </div>
            </div>

            <!-- Right: signup card -->
            <div class="col-md-9 col-lg-7">
                <div class="card border-0 shadow-lg rounded-4"
                     style="background: rgba(255,255,255,.98); backdrop-filter: blur(10px);">
                    <div class="card-body p-4 p-md-5">

                        <div class="text-center mb-4">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                 style="width: 64px; height: 64px; background: rgba(30, 58, 138, .1);">
                                <i class="bi bi-person-plus fs-2" style="color: var(--pcu-blue);"></i>
                            </div>
                            <h3 class="fw-bold mb-1">Create your student account</h3>
                            <p class="text-muted small mb-0">Fill in your details to get started.</p>
                        </div>

                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger rounded-3 small">
                                <?php foreach ($errors as $err): ?>
                                    <div><i class="bi bi-exclamation-circle me-1"></i> <?= htmlspecialchars($err) ?></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="/signup" novalidate>

                            <!-- ═══ ACCOUNT SECTION ═══ -->
                            <div class="mb-3">
                                <h6 class="text-muted text-uppercase small fw-bold mb-3">
                                    <i class="bi bi-person-circle me-1"></i> Account Information
                                </h6>
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label small fw-semibold text-muted">Full name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                        <i class="bi bi-person text-muted"></i>
                                    </span>
                                    <input type="text" name="name" id="name"
                                           class="form-control border-start-0 rounded-end-3"
                                           placeholder="Juan Dela Cruz"
                                           value="<?= old($old ?? [], 'name') ?>"
                                           autocomplete="name" required autofocus>
                                </div>
                            </div>

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
                                           autocomplete="email" required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="password" class="form-label small fw-semibold text-muted">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                            <i class="bi bi-lock text-muted"></i>
                                        </span>
                                        <input type="password" name="password" id="password"
                                               class="form-control border-start-0 border-end-0"
                                               placeholder="At least 6 characters"
                                               autocomplete="new-password" required
                                               oninput="updateStrength(this.value)">
                                        <button type="button" class="input-group-text bg-light border-start-0 rounded-end-3"
                                                onclick="togglePassword('password', 'toggleIcon1')" tabindex="-1"
                                                style="cursor: pointer;">
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

                                <div class="col-md-6">
                                    <label for="password_confirm" class="form-label small fw-semibold text-muted">Confirm password</label>
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
                                                onclick="togglePassword('password_confirm', 'toggleIcon2')" tabindex="-1"
                                                style="cursor: pointer;">
                                            <i class="bi bi-eye text-muted" id="toggleIcon2"></i>
                                        </button>
                                    </div>
                                    <div id="matchText" class="small mt-1">&nbsp;</div>
                                </div>
                            </div>

                            <!-- ═══ STUDENT SECTION ═══ -->
                            <hr class="my-4">
                            <div class="mb-3">
                                <h6 class="text-muted text-uppercase small fw-bold mb-3">
                                    <i class="bi bi-mortarboard me-1"></i> Student Information
                                </h6>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="student_id" class="form-label small fw-semibold text-muted">
                                        Student ID
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                            <i class="bi bi-hash text-muted"></i>
                                        </span>
                                        <input type="text" name="student_id" id="student_id"
                                               class="form-control border-start-0 rounded-end-3"
                                               placeholder="e.g. 2022-55052"
                                               value="<?= old($old ?? [], 'student_id') ?>"
                                               required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="section" class="form-label small fw-semibold text-muted">
                                        Section
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                            <i class="bi bi-people text-muted"></i>
                                        </span>
                                        <input type="text" name="section" id="section"
                                               class="form-control border-start-0 rounded-end-3"
                                               placeholder="e.g. 21A3"
                                               value="<?= old($old ?? [], 'section') ?>"
                                               required>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label for="gender" class="form-label small fw-semibold text-muted">
                                        Gender
                                    </label>
                                    <select name="gender" id="gender" class="form-select rounded-3" required>
                                        <option value="">— Select —</option>
                                        <?php foreach (['Male','Female','Other'] as $g): ?>
                                            <option value="<?= $g ?>" <?= old($old ?? [], 'gender') === $g ? 'selected' : '' ?>>
                                                <?= $g ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="year_level" class="form-label small fw-semibold text-muted">
                                        Year Level
                                    </label>
                                    <select name="year_level" id="year_level" class="form-select rounded-3" required>
                                        <option value="">— Select —</option>
                                        <?php foreach (['1st Year','2nd Year','3rd Year','4th Year'] as $y): ?>
                                            <option value="<?= $y ?>" <?= old($old ?? [], 'year_level') === $y ? 'selected' : '' ?>>
                                                <?= $y ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="age" class="form-label small fw-semibold text-muted">
                                        Age
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                            <i class="bi bi-calendar text-muted"></i>
                                        </span>
                                        <input type="number" name="age" id="age"
                                               class="form-control border-start-0 rounded-end-3"
                                               min="10" max="100"
                                               placeholder="18"
                                               value="<?= old($old ?? [], 'age') ?>"
                                               required>
                                    </div>
                                </div>
                            </div>

                            <div class="alert rounded-3 small"
                                 style="background: rgba(30,58,138,.08); border: 1px solid rgba(30,58,138,.15);">
                                <i class="bi bi-info-circle me-1 text-pcu-blue"></i>
                                Make sure your details match your official student records.
                                If you need to change them later, you can request an update from your profile.
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-semibold">
                                <i class="bi bi-person-plus me-1"></i> Create Account
                            </button>
                        </form>

                        <div class="text-center my-4 position-relative">
                            <hr>
                            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 small text-muted">
                                or
                            </span>
                        </div>

                        <p class="text-center text-muted small mb-0">
                            Already have an account?
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