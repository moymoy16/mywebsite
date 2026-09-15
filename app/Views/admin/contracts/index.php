<?php require BASE_PATH . '/app/Views/admin/layouts/header.php'; ?>

<h2 class="fw-bold mb-4">Contracts</h2>

<?php if (empty($contracts)): ?>
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-5 text-center text-muted">
            <i class="bi bi-file-earmark-text display-4"></i>
            <p class="mt-3 mb-0">No contracts yet. Approve a borrow request to generate one.</p>
        </div>
    </div>
<?php else: ?>
    <div class="card border-0 shadow-sm rounded-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Contract No</th>
                        <th>Student</th>
                        <th>Item</th>
                        <th>Due</th>
                        <th>Signed</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($contracts as $c): ?>
                    <tr>
                        <td class="fw-semibold"><?= htmlspecialchars($c['contract_no']) ?></td>
                        <td><?= htmlspecialchars($c['student_name']) ?></td>
                        <td><?= htmlspecialchars($c['item_name']) ?></td>
                        <td><?= htmlspecialchars($c['due_date'] ?? '-') ?></td>
                        <td>
                            <?php if ($c['signed_at']): ?>
                                <span class="badge bg-success">Signed</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Unsigned</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <a href="/admin/contracts/<?= (int)$c['id'] ?>"
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