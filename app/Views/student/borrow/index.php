<?php require BASE_PATH . '/app/Views/student/layouts/header.php'; ?>

<?php
$badge = [
    'pending'  => 'bg-warning text-dark',
    'approved' => 'bg-primary',
    'rejected' => 'bg-danger',
    'returned' => 'bg-success',
    'overdue'  => 'bg-dark text-danger fw-bold',
];

$overdueCount  = 0;
$pendingCount  = 0;
$activeCount   = 0;
$returnedCount = 0;

foreach ($borrowings as $b) {
    switch ($b['status']) {
        case 'overdue':  $overdueCount++;  break;
        case 'pending':  $pendingCount++;  break;
        case 'approved': $activeCount++;   break;
        case 'returned': $returnedCount++; break;
    }
}

$currentFilter = $_GET['status'] ?? '';

$tabLabels = [
    ''         => 'All',
    'pending'  => 'Pending',
    'approved' => 'Active',
    'overdue'  => 'Overdue',
    'returned' => 'Returned',
    'rejected' => 'Rejected',
];
$tabCounts = [
    ''         => count($borrowings),
    'pending'  => $pendingCount,
    'approved' => $activeCount,
    'overdue'  => $overdueCount,
    'returned' => $returnedCount,
    'rejected' => count($borrowings) - $pendingCount - $activeCount - $overdueCount - $returnedCount,
];

$filtered = empty($currentFilter)
    ? $borrowings
    : array_filter($borrowings, fn($b) => $b['status'] === $currentFilter);
?>

<!-- ═══ HERO ═══ -->
<section style="background: linear-gradient(135deg, #0f1e5c 0%, #1e3a8a 60%, #2d4fb8 100%); color:#fff;">
    <div class="container py-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="badge-pcu mb-3 d-inline-block">
                    <i class="bi bi-list-ul"></i> My Activity
                </span>
                <h1 class="display-6 fw-bold lh-1 mb-2 text-white">My Borrowings</h1>
                <p class="text-white-50 mb-0" style="max-width: 520px;">
                    Every item you've borrowed — pending, active, or completed.
                </p>
            </div>
            <div class="col-lg-5">
                <div class="d-flex gap-3 justify-content-lg-end">
                    <a href="/items" class="btn btn-gold rounded-3">
                        <i class="bi bi-plus-lg"></i> Borrow Something
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
                        You have <?= $overdueCount ?> overdue item<?= $overdueCount > 1 ? 's' : '' ?>
                    </div>
                    <div class="small text-muted">
                        Return them as soon as possible. You cannot borrow new items until all overdue items are returned.
                    </div>
                </div>
                <a href="/my-borrowings?status=overdue" class="btn btn-danger rounded-3 fw-semibold">
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
                    <div class="text-muted small">Items you're holding</div>
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
                    <div class="text-muted small">Completed loans</div>
                </div>
            </div>
        </div>

    </div>

    <!-- ═══ FILTER TABS ═══ -->
    <?php if (!empty($borrowings)): ?>
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-3">
                <div class="d-flex flex-wrap gap-2">
                    <?php foreach ($tabLabels as $key => $label): ?>
                        <?php $active = $currentFilter === $key; ?>
                        <a href="/my-borrowings<?= $key ? '?status=' . $key : '' ?>"
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
    <?php endif; ?>

    <!-- ═══ LIST ═══ -->
    <?php if (empty($borrowings)): ?>
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-5 text-center">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <h4 class="fw-bold mt-3">No borrowings yet</h4>
                <p class="text-muted mb-4">
                    You haven't borrowed anything. Explore the inventory to get started.
                </p>
                <a href="/items" class="btn btn-primary rounded-3">
                    <i class="bi bi-grid"></i> Browse Items
                </a>
            </div>
        </div>
    <?php elseif (empty($filtered)): ?>
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-5 text-center">
                <i class="bi bi-filter-circle display-1 text-muted"></i>
                <h4 class="fw-bold mt-3">No <?= htmlspecialchars($tabLabels[$currentFilter] ?? '') ?> borrowings</h4>
                <p class="text-muted mb-4">
                    You don't have any borrowings with this status right now.
                </p>
                <a href="/my-borrowings" class="btn btn-primary rounded-3">
                    <i class="bi bi-arrow-counterclockwise"></i> Show All
                </a>
            </div>
        </div>
    <?php else: ?>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="text-muted small">
                Showing <strong><?= count($filtered) ?></strong> borrowing<?= count($filtered) === 1 ? '' : 's' ?>
                <?php if (!empty($currentFilter)): ?>
                    with status
                    <span class="badge <?= $badge[$currentFilter] ?? 'bg-secondary' ?> rounded-pill ms-1">
                        <?= htmlspecialchars(ucfirst($currentFilter)) ?>
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
                            <th>Item</th>
                            <th class="text-center" style="width: 80px;">Qty</th>
                            <th style="width: 130px;">Borrowed</th>
                            <th style="width: 130px;">Due</th>
                            <th style="width: 160px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($filtered as $i => $b): ?>
                        <?php
                            $isOverdue = $b['status'] === 'overdue';
                            $daysLate  = $isOverdue && !empty($b['due_date'])
                                       ? (int)((time() - strtotime($b['due_date'])) / 86400)
                                       : 0;

                            $isSoon = $b['status'] === 'approved'
                                   && !empty($b['due_date'])
                                   && (int)((strtotime($b['due_date']) - time()) / 86400) <= 3;

                            $itemCount = (int)($b['item_count'] ?? 0);
                            $firstName = $b['first_item_name'] ?? null;
                            $totalQty  = (int)($b['total_quantity'] ?? 0);
                        ?>
                        <tr>
                            <td class="ps-4 text-muted small"><?= $i + 1 ?></td>

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

                            <td class="text-center">
                                <span class="badge bg-light text-dark border rounded-pill px-3">
                                    <?= $totalQty ?>
                                </span>
                            </td>

                            <td class="small"><?= htmlspecialchars($b['borrow_date'] ?? '—') ?></td>

                            <td>
                                <?php if (!empty($b['due_date'])): ?>
                                    <div class="small"><?= htmlspecialchars($b['due_date']) ?></div>
                                    <?php if ($isOverdue): ?>
                                        <div class="small text-danger fw-semibold">
                                            <i class="bi bi-exclamation-circle"></i>
                                            <?= $daysLate ?> day<?= $daysLate === 1 ? '' : 's' ?> late
                                        </div>
                                    <?php elseif ($isSoon): ?>
                                        <div class="small text-warning fw-semibold">
                                            <i class="bi bi-clock"></i> Soon
                                        </div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-muted small">—</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <span class="badge <?= $badge[$b['status']] ?? 'bg-secondary' ?> rounded-pill px-3">
                                    <?= htmlspecialchars(ucfirst($b['status'])) ?>
                                </span>
                                <?php if ($b['status'] === 'returned' && !empty($b['returned_at'])): ?>
                                    <div class="text-muted small mt-1" style="font-size: 11px;">
                                        <?= htmlspecialchars($b['returned_at']) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    <?php endif; ?>

</div>

<?php require BASE_PATH . '/app/Views/student/layouts/footer.php'; ?>