<?php require BASE_PATH . '/app/Views/admin/layouts/header.php'; ?>

<?php
$borrowingModel = new \App\Models\Borrowing();
$overdueCount   = $borrowingModel->countByStatus('overdue');
$pendingCount   = $borrowingModel->countByStatus('pending');
$approvedCount  = $borrowingModel->countByStatus('approved');
$returnedCount  = $borrowingModel->countByStatus('returned');
$rejectedCount  = $borrowingModel->countByStatus('rejected');

$rowCount = count($rows);

$tabLabels = [
    ''         => 'All',
    'pending'  => 'Pending',
    'approved' => 'Approved',
    'overdue'  => 'Overdue',
    'rejected' => 'Rejected',
    'returned' => 'Returned',
];

$tabCounts = [
    ''         => $pendingCount + $approvedCount + $overdueCount + $returnedCount + $rejectedCount,
    'pending'  => $pendingCount,
    'approved' => $approvedCount,
    'overdue'  => $overdueCount,
    'rejected' => $rejectedCount,
    'returned' => $returnedCount,
];

$badge = [
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
                <span class="badge-pcu mb-3 d-inline-block">
                    <i class="bi bi-arrow-left-right"></i> Borrowings
                </span>
                <h1 class="display-6 fw-bold lh-1 mb-2 text-white">Borrow Requests</h1>
                <p class="text-white-50 mb-0" style="max-width: 520px;">
                    Review, approve, and track every borrowing transaction in one place.
                </p>
            </div>
            <div class="col-lg-5">
                <div class="d-flex gap-2 justify-content-lg-end">
                    <?php if ($pendingCount > 0): ?>
                        <a href="/admin/borrowings?status=pending" class="btn btn-gold rounded-3">
                            <i class="bi bi-inbox"></i> Review <?= $pendingCount ?> Pending
                        </a>
                    <?php else: ?>
                        <div class="text-white-50 small text-lg-end">
                            <i class="bi bi-check2-circle text-success"></i>
                            No pending requests
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

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="rounded-3 p-2" style="background: rgba(251,191,36,.15);">
                            <i class="bi bi-hourglass-split fs-4" style="color: #b45309;"></i>
                        </div>
                        <span class="badge-pcu-dark small">Pending</span>
                    </div>
                    <div class="fs-2 fw-bold lh-1 mb-1"><?= $pendingCount ?></div>
                    <div class="text-muted small">Awaiting approval</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="rounded-3 p-2" style="background: rgba(30,58,138,.1);">
                            <i class="bi bi-arrow-left-right fs-4" style="color: var(--pcu-blue);"></i>
                        </div>
                        <span class="badge-pcu-dark small">Active</span>
                    </div>
                    <div class="fs-2 fw-bold lh-1 mb-1"><?= $approvedCount ?></div>
                    <div class="text-muted small">Currently out</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="rounded-3 p-2 bg-danger bg-opacity-10">
                            <i class="bi bi-exclamation-triangle fs-4 text-danger"></i>
                        </div>
                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill small">Overdue</span>
                    </div>
                    <div class="fs-2 fw-bold lh-1 mb-1 <?= $overdueCount > 0 ? 'text-danger' : '' ?>">
                        <?= $overdueCount ?>
                    </div>
                    <div class="text-muted small">Past due date</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="rounded-3 p-2 bg-success bg-opacity-10">
                            <i class="bi bi-check-circle fs-4 text-success"></i>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill small">Returned</span>
                    </div>
                    <div class="fs-2 fw-bold lh-1 mb-1"><?= $returnedCount ?></div>
                    <div class="text-muted small">Completed</div>
                </div>
            </div>
        </div>

    </div>

    <!-- ═══ FILTER TABS ═══ -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap gap-2">
                <?php foreach ($tabLabels as $key => $label): ?>
                    <?php $active = ($status ?? '') === $key; ?>
                    <a href="/admin/borrowings<?= $key ? '?status=' . $key : '' ?>"
                       class="btn btn-sm <?= $active ? 'btn-primary' : 'btn-outline-secondary' ?> rounded-pill px-3">
                        <?= $label ?>
                        <span class="badge <?= $active ? 'bg-white text-primary' : 'bg-secondary bg-opacity-25 text-secondary' ?> ms-1">
                            <?= $tabCounts[$key] ?>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- ═══ TABLE ═══ -->
    <?php if (empty($rows)): ?>
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-5 text-center">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <h4 class="fw-bold mt-3">No requests found</h4>
                <p class="text-muted mb-4">
                    <?php if (!empty($status)): ?>
                        No borrowings with the "<?= htmlspecialchars($tabLabels[$status] ?? $status) ?>" status.
                    <?php else: ?>
                        There are no borrow requests yet.
                    <?php endif; ?>
                </p>
                <?php if (!empty($status)): ?>
                    <a href="/admin/borrowings" class="btn btn-primary rounded-3">
                        <i class="bi bi-arrow-counterclockwise"></i> Show All
                    </a>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="text-muted small">
                Showing <strong><?= $rowCount ?></strong> request<?= $rowCount === 1 ? '' : 's' ?>
                <?php if (!empty($status)): ?>
                    with status
                    <span class="badge <?= $badge[$status] ?? 'bg-secondary' ?> rounded-pill ms-1">
                        <?= htmlspecialchars(ucfirst($status)) ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 60px;">#</th>
                            <th>Student</th>
                            <th>Items</th>
                            <th class="text-center" style="width: 90px;">Total Qty</th>
                            <th style="width: 140px;">Due</th>
                            <th style="width: 140px;">Status</th>
                            <th class="text-end pe-4" style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($rows as $i => $r): ?>
                        <?php
                            $isOverdue = $r['status'] === 'overdue';
                            $daysLate  = $isOverdue && !empty($r['due_date'])
                                       ? (int)((time() - strtotime($r['due_date'])) / 86400)
                                       : 0;

                            $itemCount = (int)($r['item_count'] ?? 0);
                            $firstName = $r['first_item_name'] ?? null;
                            $totalQty  = (int)($r['total_quantity'] ?? 0);
                        ?>
                        <tr>
                            <td class="ps-4 text-muted small"><?= $i + 1 ?></td>

                            <!-- Student -->
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle fw-semibold"
                                          style="width: 36px; height: 36px; font-size: 13px;
                                                 background: rgba(30,58,138,.1); color: var(--pcu-blue);">
                                        <?= strtoupper(substr($r['student_name'] ?? 'U', 0, 1)) ?>
                                    </span>
                                    <div>
                                        <div class="fw-semibold"><?= htmlspecialchars($r['student_name'] ?? '—') ?></div>
                                        <div class="small text-muted"><?= htmlspecialchars($r['student_email'] ?? '') ?></div>
                                    </div>
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

                            <!-- Total quantity -->
                            <td class="text-center">
                                <span class="badge bg-light text-dark border rounded-pill px-3">
                                    <?= $totalQty ?>
                                </span>
                            </td>

                            <!-- Due date -->
                            <td>
                                <?php if (!empty($r['due_date'])): ?>
                                    <div class="small"><?= htmlspecialchars($r['due_date']) ?></div>
                                    <?php if ($isOverdue): ?>
                                        <div class="small text-danger fw-semibold">
                                            <i class="bi bi-exclamation-circle"></i>
                                            <?= $daysLate ?> day<?= $daysLate === 1 ? '' : 's' ?> late
                                        </div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-muted small">—</span>
                                <?php endif; ?>
                            </td>

                            <!-- Status -->
                            <td>
                                <span class="badge <?= $badge[$r['status']] ?? 'bg-secondary' ?> rounded-pill px-3">
                                    <?= htmlspecialchars(ucfirst($r['status'])) ?>
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="text-end pe-4">
                                <a href="/admin/borrowings/<?= (int)$r['id'] ?>"
                                   class="btn btn-sm btn-outline-primary rounded-3">
                                    <i class="bi bi-eye"></i> View
                                </a>
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