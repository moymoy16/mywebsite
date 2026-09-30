<?php require BASE_PATH . '/app/Views/student/layouts/header.php'; ?>

<!-- ═══ HERO ═══ -->
<section style="background: linear-gradient(135deg, #0f1e5c 0%, #1e3a8a 60%, #2d4fb8 100%); color:#fff;">
    <div class="container py-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="badge-pcu mb-3 d-inline-block">
                    <i class="bi bi-person-badge"></i> Profile
                </span>
                <h1 class="display-6 fw-bold lh-1 mb-2 text-white">My Profile</h1>
                <p class="text-white-50 mb-0">
                    View your account details. Request changes below.
                </p>
            </div>
            <div class="col-lg-5">
                <div class="d-flex gap-2 justify-content-lg-end">
                    <a href="/profile/edit" class="btn btn-gold rounded-3">
                        <i class="bi bi-pencil-square"></i> Request Change
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container py-5">

    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="alert alert-success rounded-4 border-0 shadow-sm">
            <i class="bi bi-check-circle me-1"></i>
            <?= htmlspecialchars($_SESSION['flash']) ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <div class="row g-4">

        <!-- Profile card -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-lg-5">
                    <div class="d-flex align-items-center gap-4 mb-4">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle fw-bold"
                              style="width: 80px; height: 80px; font-size: 32px;
                                     background: rgba(30,58,138,.1); color: var(--pcu-blue);">
                            <?= strtoupper(substr($profile['name'], 0, 1)) ?>
                        </span>
                        <div>
                            <h3 class="fw-bold mb-1"><?= htmlspecialchars($profile['name']) ?></h3>
                            <div class="text-muted">
                                <i class="bi bi-envelope"></i> <?= htmlspecialchars($profile['email']) ?>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row g-3">
                        <?php
                        $rows = [
                            ['Student ID', $profile['student_id'] ?? null, 'bi-hash'],
                            ['Section',    $profile['section'] ?? null,    'bi-people'],
                            ['Gender',     $profile['gender'] ?? null,     'bi-gender-ambiguous'],
                            ['Year Level', $profile['year_level'] ?? null, 'bi-mortarboard'],
                            ['Age',        $profile['age'] ?? null,        'bi-calendar'],
                        ];
                        foreach ($rows as [$label, $value, $icon]):
                        ?>
                            <div class="col-md-6">
                                <div class="border rounded-4 p-3 h-100">
                                    <div class="text-muted small mb-1">
                                        <i class="bi <?= $icon ?> text-pcu-blue"></i> <?= $label ?>
                                    </div>
                                    <div class="fw-semibold">
                                        <?php if ($value !== null && $value !== ''): ?>
                                            <?= htmlspecialchars((string)$value) ?>
                                        <?php else: ?>
                                            <span class="text-muted fst-italic">Not set</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Request history -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-clock-history text-pcu-blue me-1"></i> My Requests
                    </h5>

                    <?php if (empty($requests)): ?>
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-inbox display-4"></i>
                            <p class="mt-3 mb-0 small">No change requests yet.</p>
                        </div>
                    <?php else: ?>
                        <div class="d-flex flex-column gap-2" style="max-height: 480px; overflow-y: auto;">
                            <?php
                            $statusBadge = [
                                'pending'  => 'bg-warning text-dark',
                                'approved' => 'bg-success',
                                'rejected' => 'bg-danger',
                            ];
                            foreach ($requests as $r):
                            ?>
                                <div class="border rounded-3 p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <span class="fw-semibold small">
                                            <?= htmlspecialchars(ucwords(str_replace('_', ' ', $r['field_name']))) ?>
                                        </span>
                                        <span class="badge <?= $statusBadge[$r['status']] ?? 'bg-secondary' ?> rounded-pill"
                                              style="font-size: 10px;">
                                            <?= ucfirst($r['status']) ?>
                                        </span>
                                    </div>
                                    <div class="small text-muted">
                                        <?= htmlspecialchars($r['old_value'] ?: '—') ?>
                                        <i class="bi bi-arrow-right"></i>
                                        <strong class="text-dark"><?= htmlspecialchars($r['new_value']) ?></strong>
                                    </div>
                                    <div class="text-muted" style="font-size: 11px;">
                                        <?= htmlspecialchars(date('M d, Y', strtotime($r['created_at']))) ?>
                                    </div>
                                    <?php if ($r['status'] === 'rejected' && !empty($r['admin_note'])): ?>
                                        <div class="alert alert-danger rounded-3 small mt-2 mb-0 py-2">
                                            <i class="bi bi-info-circle"></i> <?= htmlspecialchars($r['admin_note']) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require BASE_PATH . '/app/Views/student/layouts/footer.php'; ?>