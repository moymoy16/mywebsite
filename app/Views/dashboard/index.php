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

<!-- ═══ HERO ═══ -->
<section style="background: linear-gradient(135deg, #0f1e5c 0%, #1e3a8a 60%, #2d4fb8 100%); color:#fff;">
    <div class="container py-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="badge-pcu mb-3 d-inline-block">
                    <i class="bi bi-speedometer2"></i> My Overview
                </span>
                <h1 class="display-6 fw-bold lh-1 mb-2 text-white">
                    Hi, <span class="text-pcu-gold"><?= htmlspecialchars($firstName) ?></span> 👋
                </h1>
                <p class="text-white-50 mb-0" style="max-width: 520px;">
                    Track your active loans, upcoming due dates, and borrowing history.
                </p>
            </div>
            <div class="col-lg-5">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="/items" class="btn btn-gold rounded-3">
                        <i class="bi bi-plus-lg"></i> Borrow Something
                    </a>
                    <a href="/my-borrowings" class="btn btn-outline-light rounded-3">
                        <i class="bi bi-list-ul"></i> History
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container py-5">

    <!-- ═══ OVERDUE ALERT ═══ -->
    <?php if ($overdueCount > 0): ?>
        <div class="card border-0 shadow-sm rounded-4 mb-4"
             style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);">
            <div class="card-body p-4 d-flex align-items-center gap-3">
                <i class="bi bi-exclamation-triangle-fill fs-2 text-danger"></i>
                <div class="flex-grow-1">
                    <div class="fw-bold text-danger">
                        You have <?= $overdueCount ?> overdue borrowing<?= $overdueCount > 1 ? 's' : '' ?>
                    </div>
                    <div class="small text-muted">
                        Return them as soon as possible to keep borrowing new items.
                    </div>
                </div>
                <a href="/my-borrowings" class="btn btn-danger rounded-3 fw-semibold">
                    View <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    <?php endif; ?>

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
                            <i class="bi bi-book fs-4" style="color: var(--pcu-blue);"></i>
                        </div>
                        <span class="badge-pcu-dark small">Active</span>
                    </div>
                    <div class="fs-2 fw-bold lh-1 mb-1"><?= $activeCount ?></div>
                    <div class="text-muted small">Active borrowings</div>
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
                    <div class="fs-2 fw-bold lh-1 mb-1"><?= $returned ?></div>
                    <div class="text-muted small">Completed loans</div>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-4">

        <!-- ═══ CURRENTLY BORROWED ═══ -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-book text-pcu-blue me-1"></i> Currently Borrowed
                        </h5>
                        <a href="/my-borrowings" class="small text-decoration-none" style="color: var(--pcu-blue);">
                            View all <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <?php if (empty($active)): ?>
                        <div class="text-center py-4">
                            <i class="bi bi-inbox display-1 text-muted"></i>
                            <h5 class="fw-bold mt-3 mb-2">No active loans</h5>
                            <p class="text-muted mb-4">You're not holding any items right now.</p>
                            <a href="/items" class="btn btn-primary rounded-3">
                                <i class="bi bi-grid"></i> Browse Items
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="d-flex flex-column gap-3">
                            <?php foreach ($active as $a): ?>
                                <?php
                                    $isOverdue = $a['status'] === 'overdue';
                                    $dueTs     = !empty($a['due_date']) ? strtotime($a['due_date']) : null;
                                    $daysLeft  = $dueTs ? (int)(($dueTs - time()) / 86400) : 0;
                                    $isSoon    = !$isOverdue && $dueTs && $daysLeft <= 3 && $daysLeft >= 0;

                                    $itemCount = (int)($a['item_count'] ?? 0);
                                    $firstName = $a['first_item_name'] ?? null;
                                    $totalQty  = (int)($a['total_quantity'] ?? 0);
                                    $imgUrl    = item_image_url($a['first_item_image'] ?? null);
                                ?>
                                <div class="border rounded-4 p-3 d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <?php if ($imgUrl): ?>
                                            <img src="<?= htmlspecialchars($imgUrl) ?>" alt=""
                                                 style="width: 52px; height: 52px; object-fit: cover; border-radius: .5rem;">
                                        <?php else: ?>
                                            <div class="d-flex align-items-center justify-content-center"
                                                 style="width: 52px; height: 52px; border-radius: .5rem;
                                                        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);">
                                                <i class="bi bi-box-seam text-muted"></i>
                                            </div>
                                        <?php endif; ?>

                                        <div>
                                            <div class="fw-semibold">
                                                <?php if ($itemCount <= 1): ?>
                                                    <?= htmlspecialchars($firstName ?? '—') ?>
                                                <?php else: ?>
                                                    <?= $itemCount ?> items
                                                <?php endif; ?>
                                            </div>
                                            <div class="small text-muted">
                                                Qty <?= $totalQty ?> ·
                                                Due <strong><?= htmlspecialchars($a['due_date'] ?? '—') ?></strong>
                                                <?php if ($itemCount > 1): ?>
                                                    <div><?= htmlspecialchars($firstName ?? '') ?> + <?= $itemCount - 1 ?> more</div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <span class="badge <?= $badge[$a['status']] ?? 'bg-secondary' ?> rounded-pill px-3 mb-1">
                                            <?= htmlspecialchars(ucfirst($a['status'])) ?>
                                        </span>
                                        <?php if ($isOverdue): ?>
                                            <div class="small text-danger fw-semibold">
                                                <i class="bi bi-exclamation-circle"></i>
                                                <?= abs($daysLeft) ?> day<?= abs($daysLeft) === 1 ? '' : 's' ?> late
                                            </div>
                                        <?php elseif ($isSoon): ?>
                                            <div class="small text-warning fw-semibold">
                                                <i class="bi bi-clock"></i>
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

        <!-- ═══ DUE SOON ═══ -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-clock-history text-warning me-1"></i> Due Soon
                    </h5>

                    <?php if (empty($upcoming)): ?>
                        <div class="text-center py-4">
                            <i class="bi bi-check2-circle display-1 text-success"></i>
                            <h6 class="fw-bold mt-3 mb-1">All caught up</h6>
                            <p class="text-muted small mb-0">Nothing due in the next 7 days.</p>
                        </div>
                    <?php else: ?>
                        <ul class="list-unstyled mb-0">
                            <?php foreach ($upcoming as $u): ?>
                                <?php
                                    $uTs    = !empty($u['due_date']) ? strtotime($u['due_date']) : null;
                                    $d      = $uTs ? (int)(($uTs - time()) / 86400) : 0;
                                    $uCount = (int)($u['item_count'] ?? 0);
                                    $uFirst = $u['first_item_name'] ?? null;
                                ?>
                                <li class="d-flex justify-content-between align-items-center py-3 border-bottom">
                                    <div>
                                        <div class="fw-semibold">
                                            <?php if ($uCount <= 1): ?>
                                                <?= htmlspecialchars($uFirst ?? '—') ?>
                                            <?php else: ?>
                                                <?= $uCount ?> items
                                            <?php endif; ?>
                                        </div>
                                        <div class="small text-muted">
                                            Due <?= htmlspecialchars($u['due_date'] ?? '—') ?>
                                            <?php if ($uCount > 1): ?>
                                                · <?= htmlspecialchars($uFirst ?? '') ?> + <?= $uCount - 1 ?> more
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <span class="badge <?= $d <= 2 ? 'bg-danger' : 'bg-warning text-dark' ?> rounded-pill px-3">
                                        <?= $d <= 0 ? 'Today' : $d . 'd' ?>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- ═══ RECENT ACTIVITY ═══ -->
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-clock text-muted me-1"></i> Recent Activity
                        </h5>
                        <a href="/my-borrowings" class="small text-decoration-none" style="color: var(--pcu-blue);">
                            View all <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <?php if (empty($recent)): ?>
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-clock-history display-1"></i>
                            <h6 class="fw-bold mt-3 mb-1">No history yet</h6>
                            <p class="small mb-0">Your completed loans will appear here.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Items</th>
                                        <th class="text-center" style="width: 100px;">Total Qty</th>
                                        <th style="width: 130px;">Borrowed</th>
                                        <th style="width: 130px;">Returned</th>
                                        <th class="text-end pe-4" style="width: 130px;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent as $r): ?>
                                        <?php
                                            $rCount = (int)($r['item_count'] ?? 0);
                                            $rFirst = $r['first_item_name'] ?? null;
                                            $rQty   = (int)($r['total_quantity'] ?? 0);
                                        ?>
                                        <tr>
                                            <td class="ps-4">
                                                <?php if ($rCount <= 1): ?>
                                                    <div class="fw-semibold"><?= htmlspecialchars($rFirst ?? '—') ?></div>
                                                <?php else: ?>
                                                    <div class="fw-semibold"><?= $rCount ?> items</div>
                                                    <div class="small text-muted">
                                                        <?= htmlspecialchars($rFirst ?? '') ?> + <?= $rCount - 1 ?> more
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-light text-dark border rounded-pill px-3">
                                                    <?= $rQty ?>
                                                </span>
                                            </td>
                                            <td class="small"><?= htmlspecialchars($r['borrow_date'] ?? '—') ?></td>
                                            <td class="small"><?= htmlspecialchars($r['returned_at'] ?? '—') ?></td>
                                            <td class="text-end pe-4">
                                                <span class="badge <?= $badge[$r['status']] ?? 'bg-secondary' ?> rounded-pill px-3">
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

</div>

<?php require BASE_PATH . '/app/Views/student/layouts/footer.php'; ?>