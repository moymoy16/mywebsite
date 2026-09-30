<?php require BASE_PATH . '/app/Views/admin/layouts/header.php'; ?>

<?php
$borrowingModel = new \App\Models\Borrowing();
$itemModel      = new \App\Models\Item();

$pending   = $borrowingModel->countByStatus('pending');
$approved  = $borrowingModel->countByStatus('approved');
$overdue   = $borrowingModel->countByStatus('overdue');
$returned  = $borrowingModel->countByStatus('returned');

$totalItems = 0;
try { $totalItems = count($itemModel->allActive()); } catch (\Throwable $e) {}

$firstName = explode(' ', trim($name))[0] ?? $name;
?>

<!-- ═══ HERO ═══ -->
<section style="background: linear-gradient(135deg, #0f1e5c 0%, #1e3a8a 60%, #2d4fb8 100%); color:#fff;">
    <div class="container-fluid px-4 py-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="badge-pcu mb-3 d-inline-block">
                    <i class="bi bi-shield-lock"></i> Admin Overview
                </span>
                <h1 class="display-6 fw-bold lh-1 mb-2 text-white">
                    Welcome back, <span class="text-pcu-gold"><?= htmlspecialchars($firstName) ?></span>.
                </h1>
                <p class="text-white-50 mb-0" style="max-width: 520px;">
                    Here's what's happening with your inventory and borrowings today.
                </p>
            </div>
            <div class="col-lg-5">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="/admin/items/create" class="btn btn-gold rounded-3">
                        <i class="bi bi-plus-lg"></i> Add Item
                    </a>
                    <a href="/admin/borrowings?status=pending" class="btn btn-outline-light rounded-3">
                        <i class="bi bi-inbox"></i> Review Requests
                    </a>
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
                    <div class="fs-2 fw-bold lh-1 mb-1"><?= $pending ?></div>
                    <div class="text-muted small mb-3">Awaiting approval</div>
                    <a href="/admin/borrowings?status=pending"
                       class="btn btn-sm btn-outline-primary rounded-3 w-100">
                        Review <i class="bi bi-arrow-right"></i>
                    </a>
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
                    <div class="fs-2 fw-bold lh-1 mb-1"><?= $approved ?></div>
                    <div class="text-muted small mb-3">Currently borrowed</div>
                    <a href="/admin/borrowings?status=approved"
                       class="btn btn-sm btn-outline-primary rounded-3 w-100">
                        View <i class="bi bi-arrow-right"></i>
                    </a>
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
                    <div class="fs-2 fw-bold lh-1 mb-1 <?= $overdue > 0 ? 'text-danger' : '' ?>">
                        <?= $overdue ?>
                    </div>
                    <div class="text-muted small mb-3">Past due date</div>
                    <a href="/admin/borrowings?status=overdue"
                       class="btn btn-sm btn-outline-danger rounded-3 w-100">
                        View <i class="bi bi-arrow-right"></i>
                    </a>
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
                    <div class="text-muted small mb-3">Completed loans</div>
                    <a href="/admin/borrowings?status=returned"
                       class="btn btn-sm btn-outline-success rounded-3 w-100">
                        View <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- ═══ QUICK ACTIONS ═══ -->
    <div class="row g-4">

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-3 p-3" style="background: rgba(30,58,138,.1);">
                            <i class="bi bi-box-seam fs-3" style="color: var(--pcu-blue);"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Inventory</h5>
                            <div class="text-muted small"><?= $totalItems ?> active item<?= $totalItems === 1 ? '' : 's' ?></div>
                        </div>
                    </div>
                    <p class="text-muted small mb-3">
                        Add new items, update stock, or archive old ones.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="/admin/items" class="btn btn-sm btn-primary rounded-3 flex-grow-1">Manage</a>
                        <a href="/admin/items/create" class="btn btn-sm btn-outline-primary rounded-3">
                            <i class="bi bi-plus-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-3 p-3" style="background: rgba(251,191,36,.15);">
                            <i class="bi bi-arrow-left-right fs-3" style="color: #b45309;"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Borrowings</h5>
                            <div class="text-muted small"><?= $pending + $approved + $overdue ?> in progress</div>
                        </div>
                    </div>
                    <p class="text-muted small mb-3">
                        Approve requests, mark returns, and track overdue items.
                    </p>
                    <a href="/admin/borrowings" class="btn btn-sm btn-primary rounded-3 w-100">
                        View All Requests
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-3 p-3 bg-success bg-opacity-10">
                            <i class="bi bi-file-earmark-text fs-3 text-success"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Contracts</h5>
                            <div class="text-muted small">View &amp; sign agreements</div>
                        </div>
                    </div>
                    <p class="text-muted small mb-3">
                        Browse all generated contracts and print or sign them.
                    </p>
                    <a href="/admin/contracts" class="btn btn-sm btn-primary rounded-3 w-100">
                        Open Contracts
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- ═══ ATTENTION BANNER ═══ -->
    <?php if ($pending > 0 || $overdue > 0): ?>
        <div class="card border-0 shadow-sm rounded-4 mt-4"
             style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);">
            <div class="card-body p-4 d-flex align-items-center gap-3">
                <i class="bi bi-bell-fill fs-2 text-warning"></i>
                <div class="flex-grow-1">
                    <div class="fw-bold">Needs your attention</div>
                    <div class="small text-muted">
                        <?php if ($pending > 0): ?>
                            <strong><?= $pending ?></strong> pending request<?= $pending === 1 ? '' : 's' ?> waiting for review.
                        <?php endif; ?>
                        <?php if ($pending > 0 && $overdue > 0): ?> · <?php endif; ?>
                        <?php if ($overdue > 0): ?>
                            <strong class="text-danger"><?= $overdue ?></strong> overdue item<?= $overdue === 1 ? '' : 's' ?> need follow-up.
                        <?php endif; ?>
                    </div>
                </div>
                <a href="/admin/borrowings?status=pending" class="btn btn-warning rounded-3 fw-semibold">
                    <i class="bi bi-arrow-right"></i> Go
                </a>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php require BASE_PATH . '/app/Views/admin/layouts/footer.php'; ?>