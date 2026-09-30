<?php require BASE_PATH . '/app/Views/admin/layouts/header.php'; ?>

<?php $pending = (new \App\Models\ProfileChangeRequest())->pendingCount(); ?>

<section class="py-4"
         style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #334155 100%); color: #fff;">
    <div class="container py-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="badge bg-primary bg-opacity-25 text-primary-emphasis mb-3 px-3 py-2 rounded-pill">
                    <i class="bi bi-people"></i> Students
                </span>
                <h1 class="display-5 fw-bold lh-1 mb-2">Student Profiles</h1>
                <p class="text-white-50 mb-0">View and edit any student profile directly.</p>
            </div>
            <div class="col-lg-5">
                <div class="d-flex justify-content-lg-end gap-2">
                    <a href="/admin/profiles/requests" class="btn <?= $pending > 0 ? 'btn-warning' : 'btn-outline-light' ?> btn-lg rounded-3">
                        <i class="bi bi-inbox"></i> Requests <?= $pending > 0 ? '(' . $pending . ')' : '' ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container py-5">

    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="alert alert-success rounded-3 border-0 shadow-sm">
            <i class="bi bi-check-circle me-1"></i>
            <?= htmlspecialchars($_SESSION['flash']) ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 60px;">#</th>
                        <th>Student</th>
                        <th>Student ID</th>
                        <th>Section</th>
                        <th>Year</th>
                        <th class="text-end pe-4" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $i => $u): ?>
                    <tr>
                        <td class="ps-4 text-muted small"><?= $i + 1 ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-primary fw-semibold"
                                      style="width: 36px; height: 36px; font-size: 13px;">
                                    <?= strtoupper(substr($u['name'], 0, 1)) ?>
                                </span>
                                <div>
                                    <div class="fw-semibold"><?= htmlspecialchars($u['name']) ?></div>
                                    <div class="small text-muted"><?= htmlspecialchars($u['email']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="small"><?= htmlspecialchars($u['student_id'] ?? '—') ?></td>
                        <td class="small"><?= htmlspecialchars($u['section'] ?? '—') ?></td>
                        <td class="small"><?= htmlspecialchars($u['year_level'] ?? '—') ?></td>
                        <td class="text-end pe-4">
                            <a href="/admin/profiles/<?= (int)$u['id'] ?>/edit"
                               class="btn btn-sm btn-outline-primary rounded-3">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require BASE_PATH . '/app/Views/admin/layouts/footer.php'; ?>