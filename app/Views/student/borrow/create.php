<?php require BASE_PATH . '/app/Views/student/layouts/header.php'; ?>

<?php
$isMulti    = count($items) > 1;
$itemId     = $isMulti ? '' : (int)$items[0]['id'];
$maxQty     = $isMulti ? 1 : (int)$items[0]['available_stock'];
$firstItem  = $items[0];
$borrowDate = htmlspecialchars($old['borrowDate'] ?? date('Y-m-d'));
$dueDate    = htmlspecialchars($old['dueDate']    ?? date('Y-m-d', strtotime('+7 days')));
$actionUrl  = $isMulti ? '/borrow/multi' : '/items/' . $itemId . '/borrow';
?>

<!-- ═══ HERO ═══ -->
<section style="background: linear-gradient(135deg, #0f1e5c 0%, #1e3a8a 60%, #2d4fb8 100%); color:#fff;">
    <div class="container py-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <a href="/items" class="text-decoration-none small d-inline-block mb-3"
                   style="color: rgba(255,255,255,.6);">
                    <i class="bi bi-arrow-left"></i> Back to items
                </a>

                <div class="d-flex align-items-center gap-3">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-3"
                          style="width: 48px; height: 48px; background: rgba(251,191,36,.2); color: #fbbf24;">
                        <i class="bi bi-cart-plus fs-4"></i>
                    </span>
                    <div>
                        <h1 class="display-6 fw-bold lh-1 mb-0 text-white" style="font-size: 26px;">
                            Borrow Request
                        </h1>
                        <div class="text-white-50 small">
                            <?php if ($isMulti): ?>
                                Requesting <strong class="text-white"><?= count($items) ?> items</strong>
                            <?php else: ?>
                                You're requesting: <strong class="text-white"><?= htmlspecialchars($firstItem['name']) ?></strong>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="/items" class="btn btn-outline-light rounded-3">
                        <i class="bi bi-x-lg"></i> Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container py-5">

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger rounded-4 border-0 shadow-sm mb-4">
            <div class="d-flex align-items-start gap-2">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <div>
                    <strong>Please fix the following:</strong>
                    <ul class="mb-0 mt-1 ps-3">
                        <?php foreach ($errors as $e): ?>
                            <li><?= htmlspecialchars($e) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= $actionUrl ?>">
        <div class="row g-4">

            <!-- ═══ LEFT: FORM ═══ -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-lg-5">

                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-box-seam text-pcu-blue me-1"></i>
                            Items to Borrow
                            <span class="badge-pcu-dark ms-1"><?= count($items) ?></span>
                        </h5>

                        <div class="d-flex flex-column gap-3 mb-4">
                            <?php foreach ($items as $idx => $item): ?>
                                <?php $iUrl = item_image_url($item['image']); ?>
                                <div class="d-flex align-items-center gap-3 border rounded-4 p-3">
                                    <?php if ($iUrl): ?>
                                        <img src="<?= htmlspecialchars($iUrl) ?>" alt=""
                                             style="width: 64px; height: 64px; object-fit: cover; border-radius: .5rem;">
                                    <?php else: ?>
                                        <div class="d-flex align-items-center justify-content-center"
                                             style="width: 64px; height: 64px; border-radius: .5rem;
                                                    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);">
                                            <i class="bi bi-box-seam fs-4 text-muted"></i>
                                        </div>
                                    <?php endif; ?>

                                    <div class="flex-grow-1">
                                        <div class="fw-semibold"><?= htmlspecialchars($item['name']) ?></div>
                                        <div class="small text-muted mt-1">
                                            <span class="badge-pcu-dark" style="font-size: 10px; padding: 2px 10px;">
                                                <?= htmlspecialchars($item['category']) ?>
                                            </span>
                                            <span class="ms-2"><?= (int)$item['available_stock'] ?> available</span>
                                        </div>
                                    </div>

                                    <?php if ($isMulti): ?>
                                        <div class="text-end">
                                            <div class="small text-muted">Qty</div>
                                            <div class="fw-bold"><?= (int)$item['quantity'] ?></div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php if (!$isMulti): ?>
                            <div class="mb-4">
                                <label for="quantity" class="form-label small fw-semibold text-muted">
                                    Quantity
                                    <span class="fw-normal">(max <?= $maxQty ?>)</span>
                                </label>
                                <div class="input-group">
                                    <button type="button" class="btn btn-outline-secondary rounded-start-3"
                                            onclick="stepQty(-1)">
                                        <i class="bi bi-dash-lg"></i>
                                    </button>
                                    <input type="number" name="quantity" id="quantity"
                                           class="form-control text-center border-start-0 border-end-0"
                                           min="1" max="<?= $maxQty ?>"
                                           value="<?= (int)($old['quantity'] ?? 1) ?>"
                                           oninput="syncTotal()" required>
                                    <button type="button" class="btn btn-outline-secondary rounded-end-3"
                                            onclick="stepQty(1)">
                                        <i class="bi bi-plus-lg"></i>
                                    </button>
                                </div>
                                <div class="form-text">
                                    <i class="bi bi-info-circle"></i>
                                    <?= (int)$firstItem['available_stock'] ?> unit(s) available in inventory.
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Dates -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="borrow_date" class="form-label small fw-semibold text-muted">
                                    Borrow date
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                        <i class="bi bi-calendar-plus text-muted"></i>
                                    </span>
                                    <input type="date" name="borrow_date" id="borrow_date"
                                           class="form-control border-start-0 rounded-end-3"
                                           value="<?= $borrowDate ?>"
                                           min="<?= date('Y-m-d') ?>"
                                           onchange="syncTotal()" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="due_date" class="form-label small fw-semibold text-muted">
                                    Due date
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                        <i class="bi bi-calendar-x text-muted"></i>
                                    </span>
                                    <input type="date" name="due_date" id="due_date"
                                           class="form-control border-start-0 rounded-end-3"
                                           value="<?= $dueDate ?>"
                                           onchange="syncTotal()" required>
                                </div>
                            </div>
                        </div>

                        <!-- Quick durations -->
                        <div class="mb-4">
                            <label class="form-label small fw-semibold text-muted">Quick duration</label>
                            <div class="d-flex flex-wrap gap-2">
                                <?php foreach ([3 => '3 days', 7 => '1 week', 14 => '2 weeks', 30 => '1 month'] as $days => $label): ?>
                                    <button type="button"
                                            class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                            onclick="setDuration(<?= $days ?>)">
                                        <?= $label ?>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="alert alert-light border rounded-4 mb-0">
                            <div class="d-flex gap-2 small text-muted">
                                <i class="bi bi-info-circle mt-1 text-pcu-blue"></i>
                                <div>
                                    Your request will be reviewed by an admin. Once approved, a single contract
                                    <?= $isMulti ? 'covering all items ' : '' ?>will be generated.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- ═══ RIGHT: SUMMARY ═══ -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-receipt text-pcu-blue me-1"></i> Summary
                        </h5>

                        <dl class="row mb-0 small">
                            <dt class="col-6 text-muted fw-normal">Items</dt>
                            <dd class="col-6 text-end fw-semibold"><?= count($items) ?></dd>

                            <dt class="col-6 text-muted fw-normal">Total qty</dt>
                            <dd class="col-6 text-end fw-semibold" id="sumQty">
                                <?= array_sum(array_column($items, 'quantity')) ?>
                            </dd>

                            <dt class="col-6 text-muted fw-normal">Duration</dt>
                            <dd class="col-6 text-end fw-semibold" id="sumDuration">—</dd>

                            <dt class="col-6 text-muted fw-normal">Due</dt>
                            <dd class="col-6 text-end fw-semibold" id="sumDue">—</dd>
                        </dl>

                        <hr class="my-4">

                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-semibold">
                            <i class="bi bi-send-check"></i> Submit Request
                        </button>

                        <div class="text-muted small text-center mt-3">
                            <i class="bi bi-shield-check text-pcu-blue"></i> One contract for the whole request.
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>

</div>

<script>
function stepQty(delta) {
    const input = document.getElementById('quantity');
    if (!input) return;
    const max = parseInt(input.max) || 1;
    let v = parseInt(input.value) || 1;
    v = Math.max(1, Math.min(max, v + delta));
    input.value = v;
    syncTotal();
}

function setDuration(days) {
    const borrow = document.getElementById('borrow_date');
    const due    = document.getElementById('due_date');
    const base   = borrow.value ? new Date(borrow.value) : new Date();
    const end    = new Date(base);
    end.setDate(end.getDate() + days);
    due.value = end.toISOString().slice(0, 10);
    syncTotal();
}

function syncTotal() {
    const qtyInput = document.getElementById('quantity');
    if (qtyInput) document.getElementById('sumQty').textContent = qtyInput.value;

    const borrow = document.getElementById('borrow_date').value;
    const due    = document.getElementById('due_date').value;

    if (borrow && due) {
        const b = new Date(borrow);
        const d = new Date(due);
        const days = Math.round((d - b) / 86400000);

        document.getElementById('sumDuration').textContent =
            days > 0 ? days + ' day' + (days === 1 ? '' : 's') : '—';

        const opts = { month: 'short', day: 'numeric', year: 'numeric' };
        document.getElementById('sumDue').textContent = d.toLocaleDateString('en-US', opts);
    }
}

document.addEventListener('DOMContentLoaded', syncTotal);
</script>

<?php require BASE_PATH . '/app/Views/student/layouts/footer.php'; ?>