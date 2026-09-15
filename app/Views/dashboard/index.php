<?php require BASE_PATH . '/app/Views/student/layouts/header.php'; ?>

<?php
$badge = [
    'pending'  => 'bg-warning text-dark',
    'approved' => 'bg-primary',
    'rejected' => 'bg-danger',
    'returned' => 'bg-success',
    'overdue'  => 'bg-dark text-danger fw-bold',
];

$overdueCount = (int)($summary['overdue'] ?? 0);
$activeCount  = (int)($summary['approved'] ?? 0);
$pendingCount = (int)($summary['pending'] ?? 0);
$returned     = (int)($summary['returned'] ?? 0);
$firstName    = explode(' ', trim($name))[0] ?? $name;
?>

<!-- Greeting bar -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Hi, <?= htmlspecialchars($firstName) ?> 👋</h2>
        <p class="text-muted mb-0">Here's a quick overview of your borrowing activity.</p>
    </div>
    <a href="/items" class="btn btn-primary rounded-3">
        <i class="bi bi-plus-lg"></i> Borrow Something
    </a>
</div>

<!-- Overdue alert -->
<?php if ($overdueCount > 0): ?>
    <div class="alert alert-danger rounded-4 d-flex align-items-center shadow-sm border-0 mb-4">
        <i class="bi bi-exclamation-triangle-fill me-3 fs-3"></i>
        <div class="flex-grow-1">
            <strong>You have <?= $overdueCount ?> overdue item<?= $overdueCount > 1 ? 's' : '' ?>.</strong>
            <div class="small">Return them as soon as possible to keep borrowing new items.</div>
        </div>
        <a href="/my-borrowings" class="btn btn-sm btn-danger rounded-3">View</a>
    </div>
<?php endif; ?>

<!-- Stat cards -->
<div class="row g-3 mb-4">

    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="bg-warning bg-opacity-10 rounded-3 p-2">
                        <i class="bi bi-hourglass-split fs-4 text-warning"></i>
                    </div>
                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill small">Pending</span>
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
                    <div class="bg-primary bg-opacity-10 rounded-3 p-2">
                        <i class="bi bi-book fs-4 text-primary"></i>
                    </div>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill small">Active</span>
                </div>
                <div class="fs-2 fw-bold lh-1 mb-1"><?= $activeCount ?></div>
                <div class="text-muted small">Items you're holding</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="bg-danger bg-opacity-10 rounded-3 p-2">
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
                    <div class="bg-success bg-opacity-10 rounded-3 p-2">
                        <i class="bi bi-check-circle fs-4 text-success"></i>
                    </div>
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill small">Returned</span>
                </div>
                <div class="fs-2 fw-bold lh-1 mb-1"><?= $returned ?></div>
                <div class="text-muted small">Completed loans</div>
            </div>
        </div>
    </div>

</div>

<div class="row g-4">

    <!-- Currently Borrowed -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-book text-primary me-1"></i> Currently Borrowed
                    </h5>
                    <a href="/my-borrowings" class="small text-decoration-none">View all <i class="bi bi-arrow-right"></i></a>
                </div>

                <?php if (empty($active)): ?>
                    <div class="text-center py-4">
                        <i class="bi bi-inbox display-4 text-muted"></i>
                        <p class="text-muted mt-3 mb-3">You have no active loans right now.</p>
                        <a href="/items" class="btn btn-primary rounded-3">
                            <i class="bi bi-grid"></i> Browse Items
                        </a>
                    </div>
                <?php else: ?>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($active as $a): ?>
                            <?php
                                $isOverdue = $a['status'] === 'overdue';
                                $daysLeft  = (int)((strtotime($a['due_date']) - time()) / 86400);
                                $isSoon    = !$isOverdue && $daysLeft <= 3 && $daysLeft >= 0;
                            ?>
                            <div class="border rounded-4 p-3 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-3">
                                    <?php if (!empty($a['image']) && item_image_url($a['image'])): ?>
                                        <img src="<?= htmlspecialchars(item_image_url($a['image'])) ?>"
                                             style="width: 48px; height: 48px; object-fit: cover; border-radius: .5rem;">
                                    <?php else: ?>
                                        <div class="bg-light d-flex align-items-center justify-content-center"
                                             style="width: 48px; height: 48px; border-radius: .5rem;">
                                            <i class="bi bi-box-seam text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <div class="fw-semibold"><?= htmlspecialchars($a['item_name']) ?></div>
                                        <div class="small text-muted">
                                            Qty <?= (int)$a['quantity'] ?> ·
                                            Due <strong><?= htmlspecialchars($a['due_date']) ?></strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge <?= $badge[$a['status']] ?? 'bg-secondary' ?> mb-1">
                                        <?= htmlspecialchars(ucfirst($a['status'])) ?>
                                    </span>
                                    <?php if ($isOverdue): ?>
                                        <div class="small text-danger fw-semibold">
                                            <?= abs($daysLeft) ?> day<?= abs($daysLeft) === 1 ? '' : 's' ?> late
                                        </div>
                                    <?php elseif ($isSoon): ?>
                                        <div class="small text-warning fw-semibold">
                                            <?= $daysLeft ?> day<?= $daysLeft === 1 ? '' : 's' ?> left
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Due in next 7 days -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-clock-history text-warning me-1"></i> Due Soon
                </h5>

                <?php if (empty($upcoming)): ?>
                    <div class="text-center py-4">
                        <i class="bi bi-check2-circle display-4 text-success"></i>
                        <p class="text-muted mt-3 mb-0">Nothing due in the next 7 days.</p>
                    </div>
                <?php else: ?>
                    <ul class="list-unstyled mb-0">
                        <?php foreach ($upcoming as $u): ?>
                            <?php $d = (int)((strtotime($u['due_date']) - time()) / 86400); ?>
                            <li class="d-flex justify-content-between align-items-center py-3 border-bottom">
                                <div>
                                    <div class="fw-semibold"><?= htmlspecialchars($u['item_name']) ?></div>
                                    <div class="small text-muted">Due <?= htmlspecialchars($u['due_date']) ?></div>
                                </div>
                                <span class="badge <?= $d <= 2 ? 'bg-danger' : 'bg-warning text-dark' ?> rounded-pill">
                                    <?= $d <= 0 ? 'Today' : $d . 'd' ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recent activity -->
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-clock text-muted me-1"></i> Recent Activity
                    </h5>
                    <a href="/my-borrowings" class="small text-decoration-none">View all <i class="bi bi-arrow-right"></i></a>
                </div>

                <?php if (empty($recent)): ?>
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-clock-history display-4"></i>
                        <p class="mt-3 mb-0">No history yet. Your completed loans will appear here.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Item</th>
                                    <th>Category</th>
                                    <th>Borrowed</th>
                                    <th>Returned</th>
                                    <th class="text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent as $r): ?>
                                    <tr>
                                        <td class="fw-semibold"><?= htmlspecialchars($r['item_name']) ?></td>
                                        <td class="text-muted small"><?= htmlspecialchars($r['category']) ?></td>
                                        <td class="small"><?= htmlspecialchars($r['borrow_date'] ?? '—') ?></td>
                                        <td class="small"><?= htmlspecialchars($r['returned_at'] ?? '—') ?></td>
                                        <td class="text-end">
                                            <span class="badge <?= $badge[$r['status']] ?? 'bg-secondary' ?>">
                                                <?= htmlspecialchars(ucfirst($r['status'])) ?>
                                            </span>
                                        </td>
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

<?php require BASE_PATH . '/app/Views/student/layouts/footer.php'; ?>