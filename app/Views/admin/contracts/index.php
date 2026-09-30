<?php require BASE_PATH . '/app/Views/admin/layouts/header.php'; ?>

<?php
$total    = count($contracts);
$signed   = 0;
$unsigned = 0;
foreach ($contracts as $c) {
    if (!empty($c['signed_at'])) $signed++;
    else                         $unsigned++;
}
?>

<!-- ═══ HERO ═══ -->
<section style="background: linear-gradient(135deg, #0f1e5c 0%, #1e3a8a 60%, #2d4fb8 100%); color:#fff;">
    <div class="container-fluid px-4 py-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="badge-pcu mb-3 d-inline-block">
                    <i class="bi bi-file-earmark-text"></i> Contracts
                </span>
                <h1 class="display-6 fw-bold lh-1 mb-2 text-white">Borrowing Agreements</h1>
                <p class="text-white-50 mb-0" style="max-width: 520px;">
                    Every approved borrowing generates a signed contract. Review, print, or sign them here.
                </p>
            </div>
            <div class="col-lg-5">
                <div class="d-flex gap-3 justify-content-lg-end">
                    <?php if ($unsigned > 0): ?>
                        <div class="text-white-50 small text-lg-end">
                            <i class="bi bi-pen text-pcu-gold"></i>
                            <strong class="text-white"><?= $unsigned ?></strong>
                            unsigned contract<?= $unsigned === 1 ? '' : 's' ?> need<?= $unsigned === 1 ? 's' : '' ?> attention
                        </div>
                    <?php else: ?>
                        <div class="text-white-50 small text-lg-end">
                            <i class="bi bi-check2-circle text-success"></i>
                            All contracts are signed
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container-fluid px-4 py-5">

    <!-- ═══ STAT CARDS ═══ -->
    <div class="row g-3 mb-4">

        <div class="col-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="rounded-3 p-2" style="background: rgba(30,58,138,.1);">
                            <i class="bi bi-file-earmark-text fs-4" style="color: var(--pcu-blue);"></i>
                        </div>
                        <span class="badge-pcu-dark small">Total</span>
                    </div>
                    <div class="fs-2 fw-bold lh-1 mb-1"><?= $total ?></div>
                    <div class="text-muted small">Contracts generated</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="rounded-3 p-2 bg-success bg-opacity-10">
                            <i class="bi bi-patch-check fs-4 text-success"></i>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill small">Signed</span>
                    </div>
                    <div class="fs-2 fw-bold lh-1 mb-1"><?= $signed ?></div>
                    <div class="text-muted small">Completed</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="rounded-3 p-2" style="background: rgba(251,191,36,.15);">
                            <i class="bi bi-hourglass-split fs-4" style="color: #b45309;"></i>
                        </div>
                        <span class="badge-pcu-dark small">Unsigned</span>
                    </div>
                    <div class="fs-2 fw-bold lh-1 mb-1 <?= $unsigned > 0 ? 'text-warning' : '' ?>">
                        <?= $unsigned ?>
                    </div>
                    <div class="text-muted small">Awaiting signature</div>
                </div>
            </div>
        </div>

    </div>

    <!-- ═══ TABLE ═══ -->
    <?php if (empty($contracts)): ?>
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-5 text-center">
                <i class="bi bi-file-earmark display-1 text-muted"></i>
                <h4 class="fw-bold mt-3">No contracts yet</h4>
                <p class="text-muted mb-4">
                    Contracts are generated automatically when you approve a borrow request.
                </p>
                <a href="/admin/borrowings?status=pending" class="btn btn-primary rounded-3">
                    <i class="bi bi-inbox"></i> Review Pending Requests
                </a>
            </div>
        </div>
    <?php else: ?>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="text-muted small">
                Showing <strong><?= $total ?></strong> contract<?= $total === 1 ? '' : 's' ?>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 220px;">Contract No</th>
                            <th>Student</th>
                            <th>Items</th>
                            <th style="width: 140px;">Due Date</th>
                            <th style="width: 140px;">Signature</th>
                            <th class="text-end pe-4" style="width: 180px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($contracts as $c): ?>
                        <?php
                            $isSigned  = !empty($c['signed_at']);
                            $itemCount = (int)($c['item_count'] ?? 0);
                            $firstName = $c['first_item_name'] ?? null;
                        ?>
                        <tr>
                            <!-- Contract No -->
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="d-inline-flex align-items-center justify-content-center rounded-3"
                                          style="width: 36px; height: 36px; background: rgba(30,58,138,.1); color: var(--pcu-blue);">
                                        <i class="bi bi-file-earmark-text"></i>
                                    </span>
                                    <div>
                                        <div class="fw-semibold font-monospace" style="font-size: 13px;">
                                            <?= htmlspecialchars($c['contract_no']) ?>
                                        </div>
                                        <div class="text-muted small">
                                            <?= date('M d, Y', strtotime($c['created_at'])) ?>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Student -->
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle fw-semibold"
                                          style="width: 36px; height: 36px; font-size: 13px;
                                                 background: rgba(30,58,138,.1); color: var(--pcu-blue);">
                                        <?= strtoupper(substr($c['student_name'] ?? 'U', 0, 1)) ?>
                                    </span>
                                    <div class="fw-semibold"><?= htmlspecialchars($c['student_name'] ?? '—') ?></div>
                                </div>
                            </td>

                            <!-- Items -->
                            <td>
                                <?php if ($itemCount <= 1): ?>
                                    <div class="fw-semibold"><?= htmlspecialchars($firstName ?? '—') ?></div>
                                <?php else: ?>
                                    <div class="fw-semibold"><?= $itemCount ?> items</div>
                                    <div class="small text-muted">
                                        <?= htmlspecialchars($firstName ?? '') ?> + <?= $itemCount - 1 ?> more
                                    </div>
                                <?php endif; ?>
                            </td>

                            <!-- Due date -->
                            <td>
                                <?php if (!empty($c['due_date'])): ?>
                                    <span class="small"><?= htmlspecialchars($c['due_date']) ?></span>
                                <?php else: ?>
                                    <span class="text-muted small">—</span>
                                <?php endif; ?>
                            </td>

                            <!-- Signature -->
                            <td>
                                <?php if ($isSigned): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">
                                        <i class="bi bi-check-circle"></i> Signed
                                    </span>
                                    <div class="text-muted small mt-1" style="font-size: 11px;">
                                        <?= date('M d, Y', strtotime($c['signed_at'])) ?>
                                    </div>
                                <?php else: ?>
                                    <span class="badge-pcu-dark small" style="padding: 4px 12px; font-size: 11px;">
                                        <i class="bi bi-clock"></i> Unsigned
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Actions -->
                            <td class="text-end pe-4">
                                <div class="d-inline-flex gap-1">
                                    <a href="/admin/contracts/<?= (int)$c['id'] ?>"
                                       class="btn btn-sm btn-outline-primary rounded-3">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <a href="/admin/contracts/<?= (int)$c['id'] ?>/print" target="_blank"
                                       class="btn btn-sm btn-outline-secondary rounded-3">
                                        <i class="bi bi-printer"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    <?php endif; ?>

</div>

<?php require BASE_PATH . '/app/Views/admin/layouts/footer.php'; ?>