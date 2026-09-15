<?php require BASE_PATH . '/app/Views/student/layouts/header.php'; ?>

<h2 class="fw-bold mb-4">Browse Items</h2>

<!-- Search + filter bar -->
<form method="GET" action="/items" class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3">
        <div class="row g-2">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control rounded-3"
                       placeholder="Search items..."
                       value="<?= htmlspecialchars($search ?? '') ?>">
            </div>
            <div class="col-md-4">
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
                    <i class="bi bi-search"></i> Filter
                </button>
            </div>
        </div>
        <?php if (!empty($search) || !empty($category)): ?>
            <div class="mt-2">
                <a href="/items" class="small text-decoration-none">
                    <i class="bi bi-x-circle"></i> Clear filters
                </a>
            </div>
        <?php endif; ?>
    </div>
</form>

<!-- Results -->
<?php if (empty($items)): ?>
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-5 text-center text-muted">
            <i class="bi bi-inbox display-4"></i>
            <p class="mt-3 mb-0">No items match your search.</p>
        </div>
    </div>
<?php else: ?>
    <div class="row g-4">
        <?php foreach ($items as $item): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 d-flex flex-column">
                        <span class="badge bg-secondary align-self-start mb-2">
                            <?= htmlspecialchars($item['category']) ?>
                        </span>
                        <h5 class="fw-bold mb-2"><?= htmlspecialchars($item['name']) ?></h5>
                        <p class="text-muted small flex-grow-1">
                            <?= htmlspecialchars(mb_strimwidth($item['description'] ?? '', 0, 100, '...')) ?>
                        </p>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <?php if ((int)$item['available_stock'] > 0): ?>
                                <span class="badge bg-success">
                                    <?= (int)$item['available_stock'] ?> available
                                </span>
                            <?php else: ?>
                                <span class="badge bg-danger">Out of stock</span>
                            <?php endif; ?>

                            <a href="/items/<?= (int)$item['id'] ?>"
                               class="btn btn-sm btn-outline-primary rounded-3">
                                View <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require BASE_PATH . '/app/Views/student/layouts/footer.php'; ?>