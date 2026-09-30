<?php require BASE_PATH . '/app/Views/student/layouts/header.php'; ?>

<!-- ═══ HERO ═══ -->
<section style="background: linear-gradient(135deg, #0f1e5c 0%, #1e3a8a 60%, #2d4fb8 100%); color:#fff;">
    <div class="container py-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="badge-pcu mb-3 d-inline-block">
                    <i class="bi bi-grid-3x3-gap"></i> Inventory
                </span>
                <h1 class="display-6 fw-bold lh-1 mb-2 text-white">Browse Items</h1>
                <p class="text-white-50 mb-0" style="max-width: 520px;">
                    Find what you need from the catalog. Filter by category or search by name.
                </p>
            </div>
            <div class="col-lg-5">
                <div class="d-flex gap-3 justify-content-lg-end">
                    <div class="p-3 rounded-4 text-center" style="background: rgba(255,255,255,.06); min-width: 120px;">
                        <div class="text-white-50 small">Available</div>
                        <div class="fs-3 fw-bold text-white"><?= count($items) ?></div>
                    </div>
                    <div class="p-3 rounded-4 text-center" style="background: rgba(255,255,255,.06); min-width: 120px;">
                        <div class="text-white-50 small">Categories</div>
                        <div class="fs-3 fw-bold text-white"><?= count($categories) ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container py-5">

    <!-- ═══ SEARCH + FILTER ═══ -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form method="GET" action="/items">
                <div class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Search</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" name="search"
                                   class="form-control border-start-0 rounded-end-3"
                                   placeholder="Search by item name..."
                                   value="<?= htmlspecialchars($search ?? '') ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-semibold text-muted">Category</label>
                        <select name="category" class="form-select rounded-3">
                            <option value="">All categories</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= htmlspecialchars($cat) ?>"
                                    <?= ($category ?? '') === $cat ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-2 d-grid">
                        <button class="btn btn-primary rounded-3">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                    </div>
                </div>

                <?php if (!empty($search) || !empty($category)): ?>
                    <div class="mt-3 d-flex align-items-center gap-2 flex-wrap">
                        <span class="text-muted small">Active filters:</span>
                        <?php if (!empty($search)): ?>
                            <span class="badge-pcu-dark small">Search: "<?= htmlspecialchars($search) ?>"</span>
                        <?php endif; ?>
                        <?php if (!empty($category)): ?>
                            <span class="badge-pcu-dark small">Category: <?= htmlspecialchars($category) ?></span>
                        <?php endif; ?>
                        <a href="/items" class="small text-decoration-none ms-2" style="color: var(--pcu-blue);">
                            <i class="bi bi-x-circle"></i> Clear
                        </a>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- ═══ RESULTS ═══ -->
    <?php if (empty($items)): ?>
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-5 text-center">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <h4 class="fw-bold mt-3">No items found</h4>
                <p class="text-muted mb-4">
                    <?php if (!empty($search) || !empty($category)): ?>
                        Nothing matches your filters. Try a different search or category.
                    <?php else: ?>
                        Inventory is empty. Check back later.
                    <?php endif; ?>
                </p>
                <?php if (!empty($search) || !empty($category)): ?>
                    <a href="/items" class="btn btn-primary rounded-3">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset Filters
                    </a>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="text-muted small">
                Showing <strong><?= count($items) ?></strong> item<?= count($items) === 1 ? '' : 's' ?>
            </div>
        </div>

        <div class="row g-4">
            <?php foreach ($items as $item): ?>
                <?php $url = item_image_url($item['image']); ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">

                        <!-- Image -->
                        <div class="position-relative">
                            <?php if ($url): ?>
                                <img src="<?= htmlspecialchars($url) ?>" alt="<?= htmlspecialchars($item['name']) ?>"
                                     style="width: 100%; height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="d-flex align-items-center justify-content-center"
                                     style="height: 200px; background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);">
                                    <i class="bi bi-box-seam display-3 text-muted"></i>
                                </div>
                            <?php endif; ?>

                            <!-- Stock pill -->
                            <div class="position-absolute top-0 end-0 m-3">
                                <?php if ((int)$item['available_stock'] > 0): ?>
                                    <span class="badge bg-success shadow-sm rounded-pill px-3 py-2">
                                        <i class="bi bi-check-circle"></i> <?= (int)$item['available_stock'] ?> in stock
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger shadow-sm rounded-pill px-3 py-2">
                                        <i class="bi bi-x-circle"></i> Out of stock
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Body -->
                        <div class="card-body p-4 d-flex flex-column">
                            <span class="badge-pcu-dark align-self-start mb-2">
                                <?= htmlspecialchars($item['category']) ?>
                            </span>

                            <h5 class="fw-bold mb-2"><?= htmlspecialchars($item['name']) ?></h5>

                            <p class="text-muted small flex-grow-1 mb-3">
                                <?= htmlspecialchars(mb_strimwidth($item['description'] ?? 'No description.', 0, 110, '...')) ?>
                            </p>

                            <div class="d-flex gap-2 mt-auto">
                                <a href="/items/<?= (int)$item['id'] ?>"
                                   class="btn btn-outline-primary rounded-3 flex-grow-1">
                                    View
                                </a>
                                <?php if ((int)$item['available_stock'] > 0): ?>
                                    <form method="POST" action="/items/<?= (int)$item['id'] ?>/cart" class="flex-grow-1">
                                        <input type="hidden" name="quantity" value="1">
                                        <button class="btn btn-primary rounded-3 w-100">
                                            <i class="bi bi-cart-plus"></i> Add
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <button class="btn btn-secondary rounded-3 flex-grow-1" disabled>Out</button>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</div>

<?php require BASE_PATH . '/app/Views/student/layouts/footer.php'; ?>