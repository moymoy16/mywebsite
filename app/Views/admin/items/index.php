<?php require BASE_PATH . '/app/Views/admin/layouts/header.php'; ?>

<?php
// Stats
$totalAvailable = 0;
$totalStock     = 0;
$lowStockCount  = 0;
foreach ($items as $it) {
    $totalAvailable += (int)$it['available_stock'];
    $totalStock     += (int)$it['total_stock'];
    if ((int)$it['available_stock'] <= 2) {
        $lowStockCount++;
    }
}
?>

<!-- ═══ HERO ═══ -->
<section style="background: linear-gradient(135deg, #0f1e5c 0%, #1e3a8a 60%, #2d4fb8 100%); color:#fff;">
    <div class="container-fluid px-4 py-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="badge-pcu mb-3 d-inline-block">
                    <i class="bi bi-box-seam"></i> Inventory
                </span>
                <h1 class="display-6 fw-bold lh-1 mb-2 text-white">Manage Items</h1>
                <p class="text-white-50 mb-0" style="max-width: 520px;">
                    Add, edit, or archive items. Track available stock in real time.
                </p>
            </div>
            <div class="col-lg-5">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="/admin/items/create" class="btn btn-gold rounded-3">
                        <i class="bi bi-plus-lg"></i> Add Item
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
                        <div class="rounded-3 p-2" style="background: rgba(30,58,138,.1);">
                            <i class="bi bi-box-seam fs-4" style="color: var(--pcu-blue);"></i>
                        </div>
                        <span class="badge-pcu-dark small">Items</span>
                    </div>
                    <div class="fs-2 fw-bold lh-1 mb-1"><?= count($items) ?></div>
                    <div class="text-muted small">Total in catalog</div>
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
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill small">In stock</span>
                    </div>
                    <div class="fs-2 fw-bold lh-1 mb-1"><?= $totalAvailable ?></div>
                    <div class="text-muted small">Units available</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="rounded-3 p-2 bg-secondary bg-opacity-10">
                            <i class="bi bi-stack fs-4 text-secondary"></i>
                        </div>
                        <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill small">Total</span>
                    </div>
                    <div class="fs-2 fw-bold lh-1 mb-1"><?= $totalStock ?></div>
                    <div class="text-muted small">All units</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="rounded-3 p-2" style="background: rgba(251,191,36,.15);">
                            <i class="bi bi-exclamation-triangle fs-4" style="color: #b45309;"></i>
                        </div>
                        <span class="badge-pcu-dark small">Low</span>
                    </div>
                    <div class="fs-2 fw-bold lh-1 mb-1 <?= $lowStockCount > 0 ? 'text-warning' : '' ?>">
                        <?= $lowStockCount ?>
                    </div>
                    <div class="text-muted small">Low stock items</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ═══ ITEM LIST ═══ -->
    <?php if (empty($items)): ?>
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-5 text-center">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <h4 class="fw-bold mt-3">No items yet</h4>
                <p class="text-muted mb-4">Add your first item to start tracking inventory.</p>
                <a href="/admin/items/create" class="btn btn-primary rounded-3">
                    <i class="bi bi-plus-lg"></i> Add First Item
                </a>
            </div>
        </div>
    <?php else: ?>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="text-muted small">
                Showing <strong><?= count($items) ?></strong> item<?= count($items) === 1 ? '' : 's' ?>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 60px;">#</th>
                            <th style="width: 80px;">Image</th>
                            <th>Item</th>
                            <th>Category</th>
                            <th class="text-center" style="width: 110px;">Available</th>
                            <th class="text-center" style="width: 90px;">Total</th>
                            <th class="text-end pe-4" style="width: 220px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $i => $item): ?>
                        <?php
                            $available = (int)$item['available_stock'];
                            $total     = (int)$item['total_stock'];

                            if ($available === 0) {
                                $stockBadge = 'bg-danger';
                                $stockLabel = 'Out';
                            } elseif ($available <= 2) {
                                $stockBadge = 'bg-warning text-dark';
                                $stockLabel = 'Low';
                            } else {
                                $stockBadge = 'bg-success';
                                $stockLabel = 'OK';
                            }
                        ?>
                        <tr>
                            <td class="ps-4 text-muted small"><?= $i + 1 ?></td>

                            <!-- Thumbnail -->
                            <td>
                                <?php $url = item_image_url($item['image']); ?>
                                <?php if ($url): ?>
                                    <img src="<?= htmlspecialchars($url) ?>" alt=""
                                         style="width: 52px; height: 52px; object-fit: cover; border-radius: .5rem;">
                                <?php else: ?>
                                    <div class="d-flex align-items-center justify-content-center"
                                         style="width: 52px; height: 52px; border-radius: .5rem;
                                                background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </td>

                            <!-- Item name -->
                            <td>
                                <div class="fw-semibold"><?= htmlspecialchars($item['name']) ?></div>
                                <div class="text-muted small">
                                    <?= htmlspecialchars(mb_strimwidth($item['description'] ?? 'No description', 0, 60, '...')) ?>
                                </div>
                            </td>

                            <!-- Category -->
                            <td>
                                <span class="badge-pcu-dark rounded-pill px-3">
                                    <?= htmlspecialchars($item['category']) ?>
                                </span>
                            </td>

                            <!-- Available -->
                            <td class="text-center">
                                <span class="badge <?= $stockBadge ?> rounded-pill px-3">
                                    <?= $available ?>
                                </span>
                                <div class="text-muted small mt-1" style="font-size: 11px;">
                                    <?= $stockLabel ?>
                                </div>
                            </td>

                            <!-- Total -->
                            <td class="text-center text-muted"><?= $total ?></td>

                            <!-- Actions -->
                            <td class="text-end pe-4">
                                <div class="d-inline-flex gap-1">
                                    <a href="/admin/items/<?= (int)$item['id'] ?>/edit"
                                       class="btn btn-sm btn-outline-primary rounded-3">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form method="POST" action="/admin/items/<?= (int)$item['id'] ?>/archive"
                                          class="d-inline"
                                          onsubmit="return confirm('Archive this item? It will no longer be borrowable.')">
                                        <button class="btn btn-sm btn-outline-danger rounded-3">
                                            <i class="bi bi-archive"></i>
                                        </button>
                                    </form>
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