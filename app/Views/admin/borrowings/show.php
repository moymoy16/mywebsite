<?php require BASE_PATH . '/app/Views/admin/layouts/header.php'; ?>

<?php
$status = $borrowing['status'];

$statusBadge = [
    'pending'  => 'bg-warning text-dark',
    'approved' => 'bg-primary',
    'rejected' => 'bg-danger',
    'returned' => 'bg-success',
    'overdue'  => 'bg-dark text-danger fw-bold',
];

$statusIcon = [
    'pending'  => 'bi-hourglass-split',
    'approved' => 'bi-book',
    'rejected' => 'bi-x-circle',
    'returned' => 'bi-check-circle',
    'overdue'  => 'bi-exclamation-triangle',
];

$statusMessage = [
    'pending'  => 'This request is awaiting your review.',
    'approved' => 'The item(s) are currently borrowed by the student.',
    'rejected' => 'This request was rejected.',
    'returned' => 'The items have been returned to inventory.',
    'overdue'  => 'This borrowing is past its due date and has not been returned yet.',
];

$isOverdue = $status === 'overdue';
$daysLate  = $isOverdue && !empty($borrowing['due_date'])
           ? (int)((time() - strtotime($borrowing['due_date'])) / 86400)
           : 0;

$totalQty = 0;
foreach (($borrowing['items'] ?? []) as $bi) {
    $totalQty += (int)($bi['quantity'] ?? 0);
}
?>

<!-- ═══ HERO ═══ -->
<section style="background: linear-gradient(135deg, #0f1e5c 0%, #1e3a8a 60%, #2d4fb8 100%); color:#fff;">
    <div class="container-fluid px-4 py-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <a href="/admin/borrowings" class="text-decoration-none small d-inline-block mb-3"
                   style="color: rgba(255,255,255,.6);">
                    <i class="bi bi-arrow-left"></i> Back to requests
                </a>

                <div class="d-flex align-items-center gap-3">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-3"
                          style="width: 48px; height: 48px; background: rgba(251,191,36,.2); color: #fbbf24;">
                        <i class="bi bi-arrow-left-right fs-4"></i>
                    </span>
                    <div>
                        <h1 class="display-6 fw-bold lh-1 mb-0 text-white font-monospace" style="font-size: 26px;">
                            Request #<?= str_pad((string)(int)$borrowing['id'], 4, '0', STR_PAD_LEFT) ?>
                        </h1>
                        <div class="text-white-50 small">
                            Created <?= htmlspecialchars(date('M d, Y', strtotime($borrowing['created_at']))) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end align-items-center">
                    <span class="badge <?= $statusBadge[$status] ?? 'bg-secondary' ?> rounded-pill px-4 py-2"
                          style="font-size: 14px;">
                        <i class="bi <?= $statusIcon[$status] ?? 'bi-circle' ?> me-1"></i>
                        <?= htmlspecialchars(ucfirst($status)) ?>
                    </span>

                    <?php if ($isOverdue): ?>
                        <div class="text-white-50 small text-lg-end">
                            <i class="bi bi-exclamation-triangle-fill text-danger"></i>
                            <strong class="text-white"><?= $daysLate ?> day<?= $daysLate === 1 ? '' : 's' ?> late</strong>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container-fluid px-4 py-5">

    <!-- ═══ STATUS MESSAGE ═══ -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4 d-flex align-items-center gap-3">
            <i class="bi <?= $statusIcon[$status] ?? 'bi-info-circle' ?> fs-2
                <?= match($status) {
                    'pending'  => 'text-warning',
                    'approved' => 'text-primary',
                    'rejected' => 'text-danger',
                    'returned' => 'text-success',
                    'overdue'  => 'text-danger',
                } ?>"></i>
            <div class="flex-grow-1">
                <div class="fw-bold">
                    <?= htmlspecialchars(ucfirst($status)) ?>
                </div>
                <div class="small text-muted">
                    <?= htmlspecialchars($statusMessage[$status] ?? '') ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        <!-- ═══ LEFT: DETAILS ═══ -->
        <div class="col-lg-7">

            <!-- Student -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-person-circle text-pcu-blue"></i>
                        <h6 class="text-muted text-uppercase small fw-bold mb-0">Student</h6>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle fw-bold"
                              style="width: 56px; height: 56px; font-size: 20px;
                                     background: rgba(30,58,138,.1); color: var(--pcu-blue);">
                            <?= strtoupper(substr($borrowing['student_name'], 0, 1)) ?>
                        </span>
                        <div>
                            <div class="fw-bold fs-5"><?= htmlspecialchars($borrowing['student_name']) ?></div>
                            <div class="text-muted small">
                                <i class="bi bi-envelope"></i>
                                <?= htmlspecialchars($borrowing['student_email']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-box-seam text-pcu-blue"></i>
                            <h6 class="text-muted text-uppercase small fw-bold mb-0">
                                Items (<?= count($borrowing['items'] ?? []) ?>)
                            </h6>
                        </div>
                        <span class="badge-pcu-dark small">Total qty: <?= $totalQty ?></span>
                    </div>

                    <?php if (empty($borrowing['items'])): ?>
                        <p class="text-muted small mb-0">No items attached to this borrowing.</p>
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
                                    <?php foreach ($borrowing['items'] as $bi): ?>
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

            <!-- Schedule -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-calendar-event text-pcu-blue"></i>
                        <h6 class="text-muted text-uppercase small fw-bold mb-0">Schedule</h6>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="border rounded-4 p-3">
                                <div class="text-muted small mb-1">
                                    <i class="bi bi-calendar-plus"></i> Borrow date
                                </div>
                                <div class="fw-bold">
                                    <?= htmlspecialchars($borrowing['borrow_date'] ?? '—') ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded-4 p-3 <?= $isOverdue ? 'border-danger border-opacity-25' : '' ?>">
                                <div class="text-muted small mb-1">
                                    <i class="bi bi-calendar-x"></i> Due date
                                </div>
                                <div class="fw-bold <?= $isOverdue ? 'text-danger' : '' ?>">
                                    <?= htmlspecialchars($borrowing['due_date'] ?? '—') ?>
                                </div>
                                <?php if ($isOverdue): ?>
                                    <div class="small text-danger fw-semibold mt-1">
                                        <?= $daysLate ?> day<?= $daysLate === 1 ? '' : 's' ?> overdue
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if (!empty($borrowing['returned_at'])): ?>
                            <div class="col-12">
                                <div class="border rounded-4 p-3 border-success border-opacity-25"
                                     style="background: #f0fdf4;">
                                    <div class="text-muted small mb-1">
                                        <i class="bi bi-arrow-return-left text-success"></i> Returned on
                                    </div>
                                    <div class="fw-bold text-success">
                                        <?= htmlspecialchars($borrowing['returned_at']) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>

        <!-- ═══ RIGHT: ACTIONS ═══ -->
        <div class="col-lg-5">

            <!-- Actions -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-lightning-charge text-pcu-blue"></i>
                        <h6 class="text-muted text-uppercase small fw-bold mb-0">Actions</h6>
                    </div>

                    <?php if ($status === 'pending'): ?>
                        <form method="POST" action="/admin/borrowings/<?= (int)$borrowing['id'] ?>/approve" class="mb-2">
                            <button class="btn btn-success w-100 rounded-3 py-2">
                                <i class="bi bi-check-lg"></i> Approve & Generate Contract
                            </button>
                        </form>
                        <form method="POST" action="/admin/borrowings/<?= (int)$borrowing['id'] ?>/reject"
                              onsubmit="return confirm('Reject this request? This cannot be undone.')">
                            <button class="btn btn-outline-danger w-100 rounded-3 py-2">
                                <i class="bi bi-x-lg"></i> Reject Request
                            </button>
                        </form>

                    <?php elseif ($status === 'approved' || $status === 'overdue'): ?>
                        <form method="POST" action="/admin/borrowings/<?= (int)$borrowing['id'] ?>/return"
                              onsubmit="return confirm('Mark this item as returned? Stock will be restored.')">
                            <button class="btn btn-primary w-100 rounded-3 py-2">
                                <i class="bi bi-arrow-return-left"></i> Mark as Returned
                            </button>
                        </form>
                        <div class="text-muted small mt-3 text-center">
                            <i class="bi bi-info-circle"></i>
                            Returning will restore <strong><?= $totalQty ?></strong> unit<?= $totalQty === 1 ? '' : 's' ?>
                            to inventory.
                        </div>

                    <?php else: ?>
                        <div class="text-center py-3">
                            <i class="bi bi-check2-circle fs-1 text-success"></i>
                            <div class="fw-bold mt-2">No actions needed</div>
                            <div class="text-muted small">
                                This request is <strong><?= htmlspecialchars($status) ?></strong> and doesn't require any action.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Contract -->
            <?php if ($contract): ?>
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-file-earmark-text text-pcu-blue"></i>
                            <h6 class="text-muted text-uppercase small fw-bold mb-0">Contract</h6>
                        </div>

                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="d-inline-flex align-items-center justify-content-center rounded-3"
                                  style="width: 44px; height: 44px; background: rgba(30,58,138,.1); color: var(--pcu-blue);">
                                <i class="bi bi-file-earmark-text"></i>
                            </span>
                            <div>
                                <div class="fw-semibold font-monospace" style="font-size: 13px;">
                                    <?= htmlspecialchars($contract['contract_no']) ?>
                                </div>
                                <?php if (!empty($contract['signed_at'])): ?>
                                    <div class="small text-success">
                                        <i class="bi bi-check-circle"></i> Signed
                                    </div>
                                <?php else: ?>
                                    <div class="small text-warning">
                                        <i class="bi bi-clock"></i> Unsigned
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="/admin/contracts/<?= (int)$contract['id'] ?>"
                               class="btn btn-sm btn-primary rounded-3 flex-grow-1">
                                <i class="bi bi-eye"></i> View
                            </a>
                            <a href="/admin/contracts/<?= (int)$contract['id'] ?>/print" target="_blank"
                               class="btn btn-sm btn-outline-secondary rounded-3">
                                <i class="bi bi-printer"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Timeline -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-clock-history text-pcu-blue"></i>
                        <h6 class="text-muted text-uppercase small fw-bold mb-0">Timeline</h6>
                    </div>

                    <ul class="list-unstyled mb-0">
                        <li class="d-flex gap-3 mb-3">
                            <div class="d-flex flex-column align-items-center">
                                <span class="rounded-circle" style="width: 10px; height: 10px; background: var(--pcu-blue);"></span>
                                <span class="flex-grow-1 border-start" style="min-height: 20px;"></span>
                            </div>
                            <div>
                                <div class="fw-semibold small">Request submitted</div>
                                <div class="text-muted small">
                                    <?= htmlspecialchars(date('M d, Y g:i A', strtotime($borrowing['created_at']))) ?>
                                </div>
                            </div>
                        </li>

                        <?php if ($status !== 'pending'): ?>
                            <li class="d-flex gap-3 mb-3">
                                <div class="d-flex flex-column align-items-center">
                                    <span class="rounded-circle <?= $status === 'rejected' ? 'bg-danger' : '' ?>"
                                          style="width: 10px; height: 10px; <?= $status !== 'rejected' ? 'background: var(--pcu-blue);' : '' ?>"></span>
                                    <?php if (!empty($borrowing['returned_at'])): ?>
                                        <span class="flex-grow-1 border-start" style="min-height: 20px;"></span>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <div class="fw-semibold small">
                                        <?= $status === 'rejected' ? 'Rejected' : 'Approved' ?>
                                    </div>
                                    <div class="text-muted small">Contract generated</div>
                                </div>
                            </li>
                        <?php endif; ?>

                        <?php if (!empty($borrowing['returned_at'])): ?>
                            <li class="d-flex gap-3">
                                <div class="d-flex flex-column align-items-center">
                                    <span class="rounded-circle bg-success" style="width: 10px; height: 10px;"></span>
                                </div>
                                <div>
                                    <div class="fw-semibold small">Returned</div>
                                    <div class="text-muted small"><?= htmlspecialchars($borrowing['returned_at']) ?></div>
                                </div>
                            </li>
                        <?php elseif ($isOverdue): ?>
                            <li class="d-flex gap-3">
                                <div class="d-flex flex-column align-items-center">
                                    <span class="rounded-circle bg-danger" style="width: 10px; height: 10px;"></span>
                                </div>
                                <div>
                                    <div class="fw-semibold small text-danger">Overdue</div>
                                    <div class="text-muted small"><?= $daysLate ?> day<?= $daysLate === 1 ? '' : 's' ?> past due</div>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

        </div>

    </div>

</div>

<?php require BASE_PATH . '/app/Views/admin/layouts/footer.php'; ?>