<?php require BASE_PATH . '/app/Views/student/layouts/header.php'; ?>

<a href="/items/<?= (int)$item['id'] ?>" class="text-decoration-none small mb-3 d-inline-block">
    <i class="bi bi-arrow-left"></i> Back to item
</a>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-5">
                <h3 class="fw-bold mb-4">Borrow Request</h3>

                <div class="alert alert-light border rounded-3">
                    <div class="fw-semibold"><?= htmlspecialchars($item['name']) ?></div>
                    <div class="small text-muted">
                        <?= (int)$item['available_stock'] ?> unit(s) available
                    </div>
                </div>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger rounded-3">
                        <?php foreach ($errors as $e): ?>
                            <div><?= htmlspecialchars($e) ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/items/<?= (int)$item['id'] ?>/borrow">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="quantity" min="1"
                                   max="<?= (int)$item['available_stock'] ?>"
                                   value="<?= (int)($old['quantity'] ?? 1) ?>"
                                   class="form-control rounded-3" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Borrow date</label>
                            <input type="date" name="borrow_date"
                                   value="<?= htmlspecialchars($old['borrowDate'] ?? date('Y-m-d')) ?>"
                                   class="form-control rounded-3" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Due date</label>
                            <input type="date" name="due_date"
                                   value="<?= htmlspecialchars($old['dueDate'] ?? date('Y-m-d', strtotime('+7 days'))) ?>"
                                   class="form-control rounded-3" required>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button class="btn btn-primary rounded-3 px-4">Submit Request</button>
                        <a href="/items/<?= (int)$item['id'] ?>" class="btn btn-outline-secondary rounded-3">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require BASE_PATH . '/app/Views/student/layouts/footer.php'; ?>