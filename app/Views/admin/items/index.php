<?php require BASE_PATH . '/app/Views/admin/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Inventory</h2>
    <a href="/admin/items/create" class="btn btn-primary rounded-3">
        <i class="bi bi-plus-lg"></i> Add Item
    </a>
</div>

<?php if (empty($items)): ?>
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-5 text-center text-muted">
            <i class="bi bi-inbox display-4"></i>
            <p class="mt-3 mb-0">No items in inventory yet.</p>
        </div>
    </div>
<?php else: ?>
    <div class="card border-0 shadow-sm rounded-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Image</th>          
                        <th>Name</th>
                        <th>Category</th>
                        <th class="text-center">Available</th>
                        <th class="text-center">Total</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($items as $i => $item): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <!-- ═══ ADDED: thumbnail ═══ -->
                        <td>
                            <?php $url = item_image_url($item['image']); ?>
                            <?php if ($url): ?>
                                <img src="<?= htmlspecialchars($url) ?>" alt=""
                                    style="width: 48px; height: 48px; object-fit: cover; border-radius: .4rem;">
                            <?php else: ?>
                                <div class="bg-light d-flex align-items-center justify-content-center"
                                    style="width: 48px; height: 48px; border-radius: .4rem;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <!-- ═══ END ADDED ═══ -->
                        <td class="fw-semibold"><?= htmlspecialchars($item['name']) ?></td>
                        <td><span class="badge bg-secondary"><?= htmlspecialchars($item['category']) ?></span></td>
                        <td class="text-center">
                            <span class="badge <?= $item['available_stock'] > 0 ? 'bg-success' : 'bg-danger' ?>">
                                <?= (int)$item['available_stock'] ?>
                            </span>
                        </td>
                        <td class="text-center"><?= (int)$item['total_stock'] ?></td>
                        <td class="text-end">
                            <a href="/admin/items/<?= (int)$item['id'] ?>/edit"
                               class="btn btn-sm btn-outline-primary rounded-3">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form method="POST" action="/admin/items/<?= (int)$item['id'] ?>/archive"
                                  class="d-inline"
                                  onsubmit="return confirm('Archive this item?')">
                                <button class="btn btn-sm btn-outline-danger rounded-3">
                                    <i class="bi bi-archive"></i> Archive
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php require BASE_PATH . '/app/Views/admin/layouts/footer.php'; ?>