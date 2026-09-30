<?php require BASE_PATH . '/app/Views/student/layouts/header.php'; ?>

<!-- ═══ HERO ═══ -->
<section style="background: linear-gradient(135deg, #0f1e5c 0%, #1e3a8a 60%, #2d4fb8 100%); color:#fff;">
    <div class="container py-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="badge-pcu mb-3 d-inline-block">
                    <i class="bi bi-cart3"></i> Borrow Cart
                </span>
                <h1 class="display-6 fw-bold lh-1 mb-2 text-white">Your Items</h1>
                <p class="text-white-50 mb-0">
                    Review your items, then request them all in one contract.
                </p>
            </div>
            <div class="col-lg-5">
                <div class="d-flex gap-3 justify-content-lg-end">
                    <a href="/items" class="btn btn-gold rounded-3">
                        <i class="bi bi-plus-lg"></i> Add More
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container py-5">

    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="alert alert-success rounded-4 border-0 shadow-sm">
            <i class="bi bi-check-circle me-1"></i>
            <?= htmlspecialchars($_SESSION['flash']) ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <?php if (empty($items)): ?>
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-5 text-center">
                <i class="bi bi-cart-x display-1 text-muted"></i>
                <h4 class="fw-bold mt-3">Your cart is empty</h4>
                <p class="text-muted mb-4">Add items to borrow them together in one request.</p>
                <a href="/items" class="btn btn-primary rounded-3">
                    <i class="bi bi-grid"></i> Browse Items
                </a>
            </div>
        </div>
    <?php else: ?>

        <div class="row g-4">

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-box-seam text-pcu-blue me-1"></i>
                            Items in Cart
                            <span class="badge-pcu-dark ms-1"><?= count($items) ?></span>
                        </h5>

                        <div class="d-flex flex-column gap-3">
                            <?php foreach ($items as $idx => $item): ?>
                                <?php $iUrl = item_image_url($item['image']); ?>
                                <div class="d-flex align-items-center gap-3 border rounded-4 p-3">
                                    <?php if ($iUrl): ?>
                                        <img src="<?= htmlspecialchars($iUrl) ?>" alt=""
                                             style="width: 72px; height: 72px; object-fit: cover; border-radius: .5rem;">
                                    <?php else: ?>
                                        <div class="d-flex align-items-center justify-content-center"
                                             style="width: 72px; height: 72px; border-radius: .5rem;
                                                    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);">
                                            <i class="bi bi-box-seam fs-3 text-muted"></i>
                                        </div>
                                    <?php endif; ?>

                                    <div class="flex-grow-1">
                                        <div class="fw-semibold"><?= htmlspecialchars($item['name']) ?></div>
                                        <div class="small text-muted mt-1">
                                            <span class="badge-pcu-dark" style="font-size: 10px; padding: 2px 10px;">
                                                <?= htmlspecialchars($item['category']) ?>
                                            </span>
                                            <span class="ms-2">
                                                <i class="bi bi-check-circle text-success"></i>
                                                <?= (int)$item['available_stock'] ?> available
                                            </span>
                                        </div>
                                    </div>

                                    <div class="text-end me-2">
                                        <div class="small text-muted">Qty</div>
                                        <div class="fw-bold fs-5"><?= (int)$item['quantity'] ?></div>
                                    </div>

                                    <form method="POST" action="/borrow/cart/remove/<?= $idx ?>">
                                        <button class="btn btn-sm btn-outline-danger rounded-3" title="Remove">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-receipt text-pcu-blue me-1"></i> Summary
                        </h5>

                        <dl class="row mb-0 small">
                            <dt class="col-7 text-muted fw-normal">Items</dt>
                            <dd class="col-5 text-end fw-semibold"><?= count($items) ?></dd>

                            <dt class="col-7 text-muted fw-normal">Total quantity</dt>
                            <dd class="col-5 text-end fw-semibold">
                                <?= array_sum(array_column($items, 'quantity')) ?>
                            </dd>
                        </dl>

                        <hr class="my-4">

                        <a href="/borrow/multi" class="btn btn-primary w-100 py-3 rounded-3 fw-semibold">
                            <i class="bi bi-arrow-right"></i> Continue to Request
                        </a>

                        <div class="text-muted small text-center mt-3">
                            <i class="bi bi-shield-check text-pcu-blue"></i> One contract for all items.
                        </div>
                    </div>
                </div>
            </div>

        </div>

    <?php endif; ?>

</div>

<?php require BASE_PATH . '/app/Views/student/layouts/footer.php'; ?>