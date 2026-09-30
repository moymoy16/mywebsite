<?php require BASE_PATH . '/app/Views/admin/layouts/header.php'; ?>

<?php
$isSigned   = !empty($contract['signed_at']);
$borrowStat = $contract['borrowing_status'] ?? '';

$borrowBadge = [
    'pending'  => 'bg-warning text-dark',
    'approved' => 'bg-primary',
    'rejected' => 'bg-danger',
    'returned' => 'bg-success',
    'overdue'  => 'bg-dark text-danger fw-bold',
];
?>

<!-- ═══ HERO ═══ -->
<section style="background: linear-gradient(135deg, #0f1e5c 0%, #1e3a8a 60%, #2d4fb8 100%); color:#fff;">
    <div class="container-fluid px-4 py-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <a href="/admin/contracts" class="text-decoration-none small d-inline-block mb-3"
                   style="color: rgba(255,255,255,.6);">
                    <i class="bi bi-arrow-left"></i> Back to contracts
                </a>

                <div class="d-flex align-items-center gap-3">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-3"
                          style="width: 48px; height: 48px; background: rgba(251,191,36,.2); color: #fbbf24;">
                        <i class="bi bi-file-earmark-text fs-4"></i>
                    </span>
                    <div>
                        <h1 class="display-6 fw-bold lh-1 mb-0 text-white font-monospace" style="font-size: 24px;">
                            <?= htmlspecialchars($contract['contract_no']) ?>
                        </h1>
                        <div class="text-white-50 small">
                            Created <?= htmlspecialchars(date('M d, Y', strtotime($contract['created_at']))) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end align-items-center">

                    <a href="/admin/contracts/<?= (int)$contract['id'] ?>/print" target="_blank"
                       class="btn btn-outline-light rounded-3">
                        <i class="bi bi-printer"></i> Print
                    </a>

                    <?php if (!$isSigned): ?>
                        <form method="POST" action="/admin/contracts/<?= (int)$contract['id'] ?>/sign"
                              onsubmit="return confirm('Mark this contract as signed?')">
                            <button class="btn btn-gold rounded-3 fw-semibold">
                                <i class="bi bi-pen"></i> Mark as Signed
                            </button>
                        </form>
                    <?php else: ?>
                        <div class="text-white-50 small text-lg-end">
                            <i class="bi bi-patch-check-fill text-success fs-5"></i>
                            <div class="mt-1">
                                Signed<br>
                                <strong class="text-white">
                                    <?= htmlspecialchars(date('M d, Y', strtotime($contract['signed_at']))) ?>
                                </strong>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</section>

<div class="container-fluid px-4 py-5">

    <!-- ═══ STATUS STRIP ═══ -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 p-2 <?= $isSigned ? 'bg-success bg-opacity-10' : '' ?>"
                             <?= !$isSigned ? 'style="background: rgba(251,191,36,.15);"' : '' ?>>
                            <i class="bi <?= $isSigned ? 'bi-patch-check text-success' : 'bi-hourglass-split' ?> fs-4"
                               <?= !$isSigned ? 'style="color: #b45309;"' : '' ?>></i>
                        </div>
                        <div>
                            <div class="text-muted small">Signature</div>
                            <div class="fw-bold"><?= $isSigned ? 'Signed' : 'Unsigned' ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 p-2" style="background: rgba(30,58,138,.1);">
                            <i class="bi bi-arrow-left-right fs-4" style="color: var(--pcu-blue);"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Borrowing</div>
                            <span class="badge <?= $borrowBadge[$borrowStat] ?? 'bg-secondary' ?> rounded-pill">
                                <?= htmlspecialchars(ucfirst($borrowStat)) ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 p-2 bg-secondary bg-opacity-10">
                            <i class="bi bi-hash fs-4 text-secondary"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Contract ID</div>
                            <div class="fw-bold font-monospace">#<?= (int)$contract['id'] ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ═══ BORROWER + ITEMS ═══ -->
    <div class="row g-4 mb-4">

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-person-circle text-pcu-blue"></i>
                        <h6 class="text-muted text-uppercase small fw-bold mb-0">Borrower</h6>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle fw-bold"
                              style="width: 56px; height: 56px; font-size: 20px;
                                     background: rgba(30,58,138,.1); color: var(--pcu-blue);">
                            <?= strtoupper(substr($contract['student_name'], 0, 1)) ?>
                        </span>
                        <div>
                            <div class="fw-bold fs-5"><?= htmlspecialchars($contract['student_name']) ?></div>
                            <div class="text-muted small">
                                <i class="bi bi-envelope"></i>
                                <?= htmlspecialchars($contract['student_email']) ?>
                            </div>
                            <?php if (!empty($contract['student_id'])): ?>
                                <div class="text-muted small">
                                    <i class="bi bi-hash"></i> ID: <?= htmlspecialchars($contract['student_id']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-box-seam text-pcu-blue"></i>
                            <h6 class="text-muted text-uppercase small fw-bold mb-0">
                                Items (<?= count($contract['items'] ?? []) ?>)
                            </h6>
                        </div>
                        <span class="badge-pcu-dark small">
                            Total qty: <?= array_sum(array_column($contract['items'] ?? [], 'quantity')) ?>
                        </span>
                    </div>

                    <?php if (empty($contract['items'])): ?>
                        <p class="text-muted small mb-0">No items attached to this contract.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-sm align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Item</th>
                                        <th>Category</th>
                                        <th class="text-end">Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($contract['items'] as $bi): ?>
                                        <tr>
                                            <td class="fw-semibold"><?= htmlspecialchars($bi['item_name'] ?? '—') ?></td>
                                            <td class="text-muted small"><?= htmlspecialchars($bi['category'] ?? '—') ?></td>
                                            <td class="text-end"><?= (int)($bi['quantity'] ?? 0) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

    <!-- ═══ SCHEDULE ═══ -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-2 mb-4">
                <i class="bi bi-calendar-event text-pcu-blue"></i>
                <h6 class="text-muted text-uppercase small fw-bold mb-0">Schedule</h6>
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <div class="border rounded-4 p-3">
                        <div class="text-muted small mb-1">
                            <i class="bi bi-calendar-plus"></i> Borrow date
                        </div>
                        <div class="fw-bold"><?= htmlspecialchars($contract['borrow_date'] ?? '—') ?></div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="border rounded-4 p-3">
                        <div class="text-muted small mb-1">
                            <i class="bi bi-calendar-x"></i> Due date
                        </div>
                        <div class="fw-bold"><?= htmlspecialchars($contract['due_date'] ?? '—') ?></div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="border rounded-4 p-3">
                        <div class="text-muted small mb-1">
                            <i class="bi bi-activity"></i> Status
                        </div>
                        <span class="badge <?= $borrowBadge[$borrowStat] ?? 'bg-secondary' ?> rounded-pill px-3">
                            <?= htmlspecialchars(ucfirst($borrowStat)) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ═══ TERMS ═══ -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-shield-check text-pcu-blue"></i>
                <h6 class="text-muted text-uppercase small fw-bold mb-0">Terms & Conditions</h6>
            </div>

            <div class="rounded-4 p-4" style="background: #f8fafc; border-left: 3px solid var(--pcu-blue);">
                <p class="mb-0 text-muted" style="line-height: 1.7;">
                    <?= nl2br(htmlspecialchars($contract['terms'] ?? 'No terms were specified.')) ?>
                </p>
            </div>
        </div>
    </div>

    <!-- ═══ SIGNATURE BLOCK ═══ -->
    <?php if ($isSigned): ?>
        <div class="card border-0 shadow-sm rounded-4"
             style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);">
            <div class="card-body p-4 d-flex align-items-center gap-3">
                <i class="bi bi-patch-check-fill fs-2 text-success"></i>
                <div class="flex-grow-1">
                    <div class="fw-bold text-success">Contract signed</div>
                    <div class="small text-muted">
                        Signed on
                        <strong><?= htmlspecialchars(date('F d, Y \a\t g:i A', strtotime($contract['signed_at']))) ?></strong>.
                        This agreement is now officially on record.
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="card border-0 shadow-sm rounded-4"
             style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);">
            <div class="card-body p-4 d-flex align-items-center gap-3">
                <i class="bi bi-hourglass-split fs-2 text-warning"></i>
                <div class="flex-grow-1">
                    <div class="fw-bold text-warning-emphasis">Awaiting signature</div>
                    <div class="small text-muted">
                        Print the contract and have both parties sign, then click <strong>Mark as Signed</strong>.
                    </div>
                </div>
                <form method="POST" action="/admin/contracts/<?= (int)$contract['id'] ?>/sign"
                      onsubmit="return confirm('Mark this contract as signed?')">
                    <button class="btn btn-warning rounded-3 fw-semibold">
                        <i class="bi bi-pen"></i> Mark as Signed
                    </button>
                </form>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php require BASE_PATH . '/app/Views/admin/layouts/footer.php'; ?>