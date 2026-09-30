<?php require BASE_PATH . '/app/Views/admin/layouts/header.php'; ?>

<!-- ═══ HERO ═══ -->
<section style="background: linear-gradient(135deg, #0f1e5c 0%, #1e3a8a 60%, #2d4fb8 100%); color:#fff;">
    <div class="container-fluid px-4 py-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <a href="/admin/users" class="text-decoration-none small d-inline-block mb-3"
                   style="color: rgba(255,255,255,.6);">
                    <i class="bi bi-arrow-left"></i> Back to users
                </a>

                <div class="d-flex align-items-center gap-3">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-3"
                          style="width: 48px; height: 48px; background: rgba(251,191,36,.2); color: #fbbf24;">
                        <i class="bi bi-person-gear fs-4"></i>
                    </span>
                    <div>
                        <h1 class="display-6 fw-bold lh-1 mb-0 text-white" style="font-size: 26px;">
                            Edit Profile
                        </h1>
                        <div class="text-white-50 small">
                            Updating: <strong class="text-white"><?= htmlspecialchars($target['name']) ?></strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="/admin/users" class="btn btn-outline-light rounded-3">
                        <i class="bi bi-x-lg"></i> Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container-fluid px-4 py-5">

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger rounded-4 border-0 shadow-sm mb-4">
            <div class="d-flex align-items-start gap-2">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <div>
                    <strong>Please fix the following:</strong>
                    <ul class="mb-0 mt-1 ps-3">
                        <?php foreach ($errors as $e): ?>
                            <li><?= htmlspecialchars($e) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-lg-5">

                    <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle fw-bold"
                              style="width: 64px; height: 64px; font-size: 24px;
                                     background: rgba(30,58,138,.1); color: var(--pcu-blue);">
                            <?= strtoupper(substr($target['name'], 0, 1)) ?>
                        </span>
                        <div>
                            <h4 class="fw-bold mb-0"><?= htmlspecialchars($target['name']) ?></h4>
                            <div class="text-muted small"><?= htmlspecialchars($target['email']) ?></div>
                        </div>
                    </div>

                    <form method="POST" action="/admin/users/profile/<?= (int)$target['id'] ?>">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-muted">Full Name</label>
                                <input type="text" name="name" class="form-control rounded-3"
                                       value="<?= htmlspecialchars($target['name']) ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-muted">Email</label>
                                <input type="email" name="email" class="form-control rounded-3"
                                       value="<?= htmlspecialchars($target['email']) ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-muted">Student ID</label>
                                <input type="text" name="student_id" class="form-control rounded-3"
                                       value="<?= htmlspecialchars($target['student_id'] ?? '') ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-muted">Section</label>
                                <input type="text" name="section" class="form-control rounded-3"
                                       placeholder="e.g. 21A3"
                                       value="<?= htmlspecialchars($target['section'] ?? '') ?>">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small fw-semibold text-muted">Gender</label>
                                <select name="gender" class="form-select rounded-3">
                                    <option value="">— Not set —</option>
                                    <?php foreach (['Male','Female','Other'] as $g): ?>
                                        <option value="<?= $g ?>" <?= $target['gender'] === $g ? 'selected' : '' ?>>
                                            <?= $g ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small fw-semibold text-muted">Year Level</label>
                                <select name="year_level" class="form-select rounded-3">
                                    <option value="">— Not set —</option>
                                    <?php foreach (['1st Year','2nd Year','3rd Year','4th Year'] as $y): ?>
                                        <option value="<?= $y ?>" <?= $target['year_level'] === $y ? 'selected' : '' ?>>
                                            <?= $y ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small fw-semibold text-muted">Age</label>
                                <input type="number" name="age" min="10" max="100"
                                       class="form-control rounded-3"
                                       value="<?= htmlspecialchars((string)($target['age'] ?? '')) ?>">
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <a href="/admin/users" class="btn btn-outline-secondary rounded-3">Cancel</a>
                            <button class="btn btn-primary rounded-3">
                                <i class="bi bi-check-lg"></i> Save Changes
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php require BASE_PATH . '/app/Views/admin/layouts/footer.php'; ?>