<?php require BASE_PATH . '/app/Views/student/layouts/header.php'; ?>

<?php
$url       = item_image_url($item['image']);
$available = (int)$item['available_stock'];
$total     = (int)$item['total_stock'];
$borrowed  = $total - $available;
$inStock   = $available > 0;

if ($available === 0) {
    $stockStatus = ['label' => 'Out of stock', 'color' => 'danger',  'icon' => 'bi-x-circle'];
} elseif ($available <= 2) {
    $stockStatus = ['label' => 'Low stock',   'color' => 'warning', 'icon' => 'bi-exclamation-triangle'];
} else {
    $stockStatus = ['label' => 'In stock',    'color' => 'success', 'icon' => 'bi-check-circle'];
}
?>

<div class="container py-5">

    <a href="/items" class="text-decoration-none small mb-4 d-inline-block text-muted">
        <i class="bi bi-arrow-left"></i> Back to items
    </a>

    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="alert alert-success rounded-4 border-0 shadow-sm">
            <i class="bi bi-check-circle me-1"></i>
            <?= htmlspecialchars($_SESSION['flash']) ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <div class="row g-4">

        <!-- ═══ LEFT: IMAGE ═══ -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="position-relative">
                    <?php if ($url): ?>
                        <img src="<?= htmlspecialchars($url) ?>" alt="<?= htmlspecialchars($item['name']) ?>"
                             style="width: 100%; height: 420px; object-fit: cover;">
                    <?php else: ?>
                        <div class="d-flex align-items-center justify-content-center"
                             style="height: 420px; background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);">
                            <i class="bi bi-box-seam display-1 text-muted"></i>
                        </div>
                    <?php endif; ?>

                    <!-- Category badge -->
                    <div class="position-absolute top-0 start-0 m-3">
                        <span class="badge text-white rounded-pill px-3 py-2 shadow-sm"
                              style="background: var(--pcu-blue);">
                            <i class="bi bi-collection"></i> <?= htmlspecialchars($item['category']) ?>
                        </span>
                    </div>

                    <!-- Stock badge -->
                    <div class="position-absolute top-0 end-0 m-3">
                        <span class="badge bg-<?= $stockStatus['color'] ?> text-white rounded-pill px-3 py-2 shadow-sm">
                            <i class="bi <?= $stockStatus['icon'] ?>"></i>
                            <?= $stockStatus['label'] ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ═══ RIGHT: DETAILS ═══ -->
        <div class="col-lg-6">
            <div class="d-flex flex-column h-100">

                <h1 class="display-6 fw-bold lh-1 mb-3">
                    <?= htmlspecialchars($item['name']) ?>
                </h1>

                <!-- Stock summary pills -->
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <span class="badge bg-<?= $stockStatus['color'] ?> bg-opacity-10 text-<?= $stockStatus['color'] ?> rounded-pill px-3 py-2">
                        <i class="bi <?= $stockStatus['icon'] ?>"></i>
                        <?= $available ?> available
                    </span>
                    <span class="badge bg-light text-dark border rounded-pill px-3 py-2">
                        <i class="bi bi-stack"></i> <?= $total ?> total
                    </span>
                    <?php if ($borrowed > 0): ?>
                        <span class="badge bg-dark bg-opacity-10 text-dark rounded-pill px-3 py-2">
                            <i class="bi bi-book"></i> <?= $borrowed ?> currently out
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Description -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h6 class="text-muted text-uppercase small fw-bold mb-3">
                            <i class="bi bi-file-text"></i> Description
                        </h6>
                        <p class="mb-0 text-muted" style="line-height: 1.7;">
                            <?= nl2br(htmlspecialchars($item['description'] ?? 'No description provided.')) ?>
                        </p>
                    </div>
                </div>

                <!-- Availability bar -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="text-muted text-uppercase small fw-bold mb-0">
                                <i class="bi bi-bar-chart"></i> Availability
                            </h6>
                            <span class="fw-bold small"><?= $available ?> / <?= $total ?></span>
                        </div>
                        <?php
                            $pct = $total > 0 ? round(($available / $total) * 100) : 0;
                            $barColor = $pct > 50 ? 'bg-success' : ($pct > 0 ? 'bg-warning' : 'bg-danger');
                        ?>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar <?= $barColor ?>"
                                 role="progressbar"
                                 style="width: <?= $pct ?>%;"
                                 aria-valuenow="<?= $pct ?>"
                                 aria-valuemin="0"
                                 aria-valuemax="100"></div>
                        </div>
                        <div class="text-muted small mt-2">
                            <?php if ($pct === 0): ?>
                                All units are currently borrowed.
                            <?php elseif ($pct < 40): ?>
                                Most units are currently borrowed — borrow soon.
                            <?php else: ?>
                                Plenty of units available.
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- CTA AREA -->
                <div class="mt-auto">
                    <?php if ($inStock): ?>

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <label class="form-label small fw-semibold text-muted mb-0">
                                Quantity <span class="fw-normal">(max <?= $available ?>)</span>
                            </label>
                            <div class="input-group input-group-sm" style="width: 130px;">
                                <button type="button" class="btn btn-outline-secondary"
                                        onclick="stepQty(-1)">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <input type="number" id="qty"
                                       class="form-control text-center border-start-0 border-end-0"
                                       min="1" max="<?= $available ?>"
                                       value="1"
                                       oninput="updateButtons()">
                                <button type="button" class="btn btn-outline-secondary"
                                        onclick="stepQty(1)">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="/items/<?= (int)$item['id'] ?>/borrow?qty=1"
                               id="borrowLink"
                               class="btn btn-primary btn-lg rounded-3 py-3 fw-semibold flex-fill">
                                <i class="bi bi-lightning-charge"></i> Borrow Now
                            </a>

                            <form method="POST"
                                  action="/items/<?= (int)$item['id'] ?>/cart"
                                  class="flex-fill m-0">
                                <input type="hidden" name="quantity" id="cartQty" value="1">
                                <button type="submit"
                                        class="btn btn-gold btn-lg rounded-3 py-3 fw-semibold w-100">
                                    <i class="bi bi-cart-plus"></i> Add to Cart
                                </button>
                            </form>
                        </div>

                        <div class="text-muted small text-center mt-3">
                            <i class="bi bi-info-circle"></i>
                            <strong>Borrow Now</strong> for one item ·
                            <strong>Add to Cart</strong> to combine items into one contract
                        </div>

                    <?php else: ?>
                        <button class="btn btn-secondary btn-lg rounded-3 w-100 py-3" disabled>
                            <i class="bi bi-x-circle"></i> Out of Stock
                        </button>
                        <div class="text-muted small text-center mt-2">
                            <i class="bi bi-info-circle"></i>
                            This item is not available right now. Check back later.
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>

    </div>

    <!-- ═══ MORE FROM CATEGORY ═══ -->
    <?php if (!empty($related ?? [])): ?>
        <div class="mt-5">
            <h5 class="fw-bold mb-3">
                <i class="bi bi-grid text-pcu-blue me-1"></i>
                More in <?= htmlspecialchars($item['category']) ?>
            </h5>

            <div class="row g-3">
                <?php foreach ($related as $r): ?>
                    <?php $rUrl = item_image_url($r['image']); ?>
                    <div class="col-6 col-md-3">
                        <a href="/items/<?= (int)$r['id'] ?>" class="text-decoration-none">
                            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                                <?php if ($rUrl): ?>
                                    <img src="<?= htmlspecialchars($rUrl) ?>" alt=""
                                         style="width: 100%; height: 120px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="d-flex align-items-center justify-content-center"
                                         style="height: 120px; background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);">
                                        <i class="bi bi-box-seam fs-2 text-muted"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="card-body p-3">
                                    <div class="fw-semibold small text-dark text-truncate">
                                        <?= htmlspecialchars($r['name']) ?>
                                    </div>
                                    <div class="text-muted" style="font-size: 11px;">
                                        <?= (int)$r['available_stock'] ?> available
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<script>
const MAX = <?= $available ?>;

function stepQty(delta) {
    const input = document.getElementById('qty');
    let v = parseInt(input.value) || 1;
    v = Math.max(1, Math.min(MAX, v + delta));
    input.value = v;
    updateButtons();
}

function updateButtons() {
    const input = document.getElementById('qty');
    let v = parseInt(input.value) || 1;
    if (v < 1) v = 1;
    if (v > MAX) v = MAX;
    if (v !== parseInt(input.value)) input.value = v;

    document.getElementById('cartQty').value = v;
    document.getElementById('borrowLink').href =
        '/items/<?= (int)$item['id'] ?>/borrow?qty=' + v;
}

document.addEventListener('DOMContentLoaded', updateButtons);
</script>

<?php require BASE_PATH . '/app/Views/student/layouts/footer.php'; ?>