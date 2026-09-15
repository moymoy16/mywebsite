<?php require BASE_PATH . '/app/Views/admin/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Borrow Requests</h2>
</div>

<?php
$overdueCount = (new \App\Models\Borrowing())->countByStatus('overdue');
$pendingCount = (new \App\Models\Borrowing())->countByStatus('pending');
?>
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <div class="bg-warning bg-opacity-25 rounded-3 p-3">
                    <i class="bi bi-hourglass-split fs-3 text-warning"></i>
                </div>
                <div>
                    <div class="text-muted small">Pending</div>
                    <div class="fs-4 fw-bold"><?= $pendingCount ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <div class="bg-danger bg-opacity-25 rounded-3 p-3">
                    <i class="bi bi-exclamation-triangle fs-3 text-danger"></i>
                </div>
                <div>
                    <div class="text-muted small">Overdue</div>
                    <div class="fs-4 fw-bold"><?= $overdueCount ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status filter -->
<div class="mb-3">
    <?php
    $tabs = ['' => 'All', 'pending' => 'Pending', 'approved' => 'Approved', 'overdue' => 'Overdue',
             'rejected' => 'Rejected', 'returned' => 'Returned'];
    foreach ($tabs as $key => $label):
        $active = ($status ?? '') === $key;
    ?>
        <a href="/admin/borrowings<?= $key ? '?status=' . $key : '' ?>"
           class="btn btn-sm <?= $active ? 'btn-primary' : 'btn-outline-secondary' ?> rounded-3 me-1">
            <?= $label ?>
        </a>
    <?php endforeach; ?>
</div>

<?php
$badge = [
    'pending'  => 'bg-warning text-dark',
    'approved' => 'bg-primary',
    'rejected' => 'bg-danger',
    'returned' => 'bg-success',
    'overdue'  => 'bg-dark text-danger fw-bold',

];
?>

<?php if (empty($rows)): ?>
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-5 text-center text-muted">
            <i class="bi bi-inbox display-4"></i>
            <p class="mt-3 mb-0">No borrow requests.</p>
        </div>
    </div>
<?php else: ?>
    <div class="card border-0 shadow-sm rounded-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Item</th>
                        <th class="text-center">Qty</th>
                        <th>Due</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($rows as $i => $r): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <div class="fw-semibold"><?= htmlspecialchars($r['student_name']) ?></div>
                            <div class="small text-muted"><?= htmlspecialchars($r['student_email']) ?></div>
                        </td>
                        <td><?= htmlspecialchars($r['item_name']) ?></td>
                        <td class="text-center"><?= (int)$r['quantity'] ?></td>
                        <td><?= htmlspecialchars($r['due_date'] ?? '-') ?></td>
                        <td>
                            <span class="badge <?= $badge[$r['status']] ?? 'bg-secondary' ?>">
                                <?= htmlspecialchars(ucfirst($r['status'])) ?>
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="/admin/borrowings/<?= (int)$r['id'] ?>"
                               class="btn btn-sm btn-outline-primary rounded-3">
                                <i class="bi bi-eye"></i> View
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php require BASE_PATH . '/app/Views/admin/layouts/footer.php'; ?>