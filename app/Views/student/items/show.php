<?php require BASE_PATH . '/app/Views/student/layouts/header.php'; ?>

<a href="/items" class="text-decoration-none small mb-3 d-inline-block">
    <i class="bi bi-arrow-left"></i> Back to items
</a>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-5">
        <div class="row g-4">

            <div class="col-md-4">
                <!-- ═══ REPLACED: real image or fallback ═══ -->
                <?php $url = item_image_url($item['image']); ?>
                <?php if ($url): ?>
                    <img src="<?= htmlspecialchars($url) ?>" alt=""
                        class="img-fluid rounded-4"
                        style="width: 100%; height: 240px; object-fit: cover;">
                <?php else: ?>
                    <div class="bg-light rounded-4 d-flex align-items-center justify-content-center"
                        style="height: 240px;">
                        <i class="bi bi-box-seam display-1 text-muted"></i>
                    </div>
                <?php endif; ?>
                <!-- ═══ END REPLACED ═══ -->
            </div>

            <div class="col-md-8">
                <span class="badge bg-secondary mb-2">
                    <?= htmlspecialchars($item['category']) ?>
                </span>
                <h2 class="fw-bold"><?= htmlspecialchars($item['name']) ?></h2>

                <p class="text-muted"><?= nl2br(htmlspecialchars($item['description'] ?? '')) ?></p>

                <hr>

                <div class="row mt-3">
                    <div class="col-6">
                        <div class="text-muted small">Available stock</div>
                        <div class="fs-4 fw-bold
                            <?= (int)$item['available_stock'] > 0 ? 'text-success' : 'text-danger' ?>">
                            <?= (int)$item['available_stock'] ?>
                            <span class="fs-6 text-muted">/ <?= (int)$item['total_stock'] ?></span>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <?php if ((int)$item['available_stock'] > 0): ?>
                        <a href="/items/<?= (int)$item['id'] ?>/borrow"
                        class="btn btn-primary btn-lg rounded-3">
                            <i class="bi bi-cart-plus"></i> Borrow
                        </a>
                    <?php else: ?>
                        <button class="btn btn-secondary btn-lg rounded-3" disabled>
                            Out of stock
                        </button>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>

<?php require BASE_PATH . '/app/Views/student/layouts/footer.php'; ?>