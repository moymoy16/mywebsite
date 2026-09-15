<?php require BASE_PATH . '/app/Views/student/layouts/header.php'; ?>

<h2 class="fw-bold mb-4">My Borrowings</h2>
<?php
$overdueCount = 0;
foreach ($borrowings as $b) {
    if ($b['status'] === 'overdue') $overdueCount++;
}
?>
<?php if ($overdueCount > 0): ?>
    <div class="alert alert-danger rounded-3 d-flex align-items-center">
        <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
        <div>
            <strong>You have <?= $overdueCount ?> overdue item(s).</strong>
            Please return them as soon as possible. You cannot borrow new items until all overdue items are returned.
        </div>
    </div>
<?php endif; ?>

<?php
$badge = [
    'pending'  => 'bg-warning text-dark',
    'approved' => 'bg-primary',
    'rejected' => 'bg-danger',
    'returned' => 'bg-success',
    'overdue'  => 'bg-dark text-danger fw-bold',
];
?>

<?php if (empty($borrowings)): ?>
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-5 text-center text-muted">
            <i class="bi bi-inbox display-4"></i>
            <p class="mt-3 mb-0">You haven't borrowed anything yet.</p>
            <a href="/items" class="btn btn-primary rounded-3 mt-3">Browse Items</a>
        </div>
    </div>
<?php else: ?>
    <div class="card border-0 shadow-sm rounded-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th class="text-center">Qty</th>
                        <th>Borrow</th>
                        <th>Due</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($borrowings as $i => $b): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <div class="fw-semibold"><?= htmlspecialchars($b['item_name']) ?></div>
                            <div class="small text-muted"><?= htmlspecialchars($b['category']) ?></div>
                        </td>
                        <td class="text-center"><?= (int)$b['quantity'] ?></td>
                        <td><?= htmlspecialchars($b['borrow_date'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($b['due_date'] ?? '-') ?></td>
                        <td>
                            <span class="badge <?= $badge[$b['status']] ?? 'bg-secondary' ?>">
                                <?= htmlspecialchars(ucfirst($b['status'])) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php require BASE_PATH . '/app/Views/student/layouts/footer.php'; ?>