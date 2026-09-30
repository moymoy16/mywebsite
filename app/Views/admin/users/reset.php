<?php require BASE_PATH . '/app/Views/admin/layouts/header.php'; ?>

<div class="container-fluid px-4 py-5">

    <a href="/admin/users?tab=password" class="text-decoration-none small mb-3 d-inline-block text-muted">
        <i class="bi bi-arrow-left"></i> Back to requests
    </a>

    <div class="row justify-content-center">
        <div class="col-lg-6">

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger rounded-4 border-0 shadow-sm">
                    <?php foreach ($errors as $e): ?>
                        <div><i class="bi bi-exclamation-circle me-1"></i> <?= htmlspecialchars($e) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-5">

                    <div class="text-center mb-4">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 64px; height: 64px; background: rgba(30,58,138,.1);">
                            <i class="bi bi-key fs-2" style="color: var(--pcu-blue);"></i>
                        </div>
                        <h4 class="fw-bold mb-1">Reset Password</h4>
                        <p class="text-muted small mb-0">
                            Assign a temporary password. Share it with the user securely.
                        </p>
                    </div>

                    <div class="alert alert-light border rounded-4 mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle fw-bold"
                                  style="width: 44px; height: 44px;
                                         background: rgba(30,58,138,.1); color: var(--pcu-blue);">
                                <?= strtoupper(substr($request['user_name'], 0, 1)) ?>
                            </span>
                            <div>
                                <div class="fw-semibold"><?= htmlspecialchars($request['user_name']) ?></div>
                                <div class="small text-muted"><?= htmlspecialchars($request['user_email']) ?></div>
                            </div>
                        </div>

                        <?php if (!empty($request['note'])): ?>
                            <hr>
                            <div class="small text-muted">
                                <strong>Message from user:</strong><br>
                                <?= nl2br(htmlspecialchars($request['note'])) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <form method="POST" action="/admin/users/reset/<?= (int)$request['id'] ?>">
                        <div class="mb-3">
                            <label for="password" class="form-label small fw-semibold text-muted">
                                Temporary password
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                    <i class="bi bi-lock text-muted"></i>
                                </span>
                                <input type="text" name="password" id="password"
                                       class="form-control border-start-0 border-end-0"
                                       placeholder="At least 6 characters"
                                       value="<?= htmlspecialchars($_POST['password'] ?? 'Temp@' . rand(1000, 9999)) ?>"
                                       required>
                                <button type="button" class="input-group-text bg-light border-start-0 rounded-end-3"
                                        onclick="generatePassword()" tabindex="-1"
                                        style="cursor:pointer;">
                                    <i class="bi bi-arrow-clockwise text-muted"></i>
                                </button>
                            </div>
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> Share this with the user. They'll be forced to change it on next login.
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirm" class="form-label small fw-semibold text-muted">
                                Confirm password
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                    <i class="bi bi-lock-fill text-muted"></i>
                                </span>
                                <input type="text" name="password_confirm" id="password_confirm"
                                       class="form-control border-start-0 rounded-end-3"
                                       value="<?= htmlspecialchars($_POST['password'] ?? 'Temp@' . rand(1000, 9999)) ?>"
                                       required>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary rounded-3 flex-grow-1">
                                <i class="bi bi-check-lg"></i> Set Password
                            </button>
                            <a href="/admin/users?tab=password" class="btn btn-outline-secondary rounded-3">
                                Cancel
                            </a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
function generatePassword() {
    const chars = 'ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789@#';
    let pwd = '';
    for (let i = 0; i < 10; i++) pwd += chars[Math.floor(Math.random() * chars.length)];
    document.getElementById('password').value = pwd;
    document.getElementById('password_confirm').value = pwd;
}
</script>

<?php require BASE_PATH . '/app/Views/admin/layouts/footer.php'; ?>