<?php require BASE_PATH . '/app/Views/admin/layouts/header.php'; ?>

<a href="/admin/borrowings" class="text-decoration-none small mb-3 d-inline-block">
    <i class="bi bi-arrow-left"></i> Back to requests
</a>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-3">Request #<?= (int)$borrowing['id'] ?></h4>

                <dl class="row mb-0">
                    <dt class="col-sm-4 text-muted">Student</dt>
                    <dd class="col-sm-8">
                        <?= htmlspecialchars($borrowing['student_name']) ?>
                        <span class="text-muted small">(<?= htmlspecialchars($borrowing['student_email']) ?>)</span>
                    </dd>

                    <dt class="col-sm-4 text-muted">Item</dt>
                    <dd class="col-sm-8">
                        <?= htmlspecialchars($borrowing['item_name']) ?>
                        <span class="text-muted small">(<?= htmlspecialchars($borrowing['category']) ?>)</span>
                    </dd>

                    <dt class="col-sm-4 text-muted">Quantity</dt>
                    <dd class="col-sm-8"><?= (int)$borrowing['quantity'] ?></dd>

                    <dt class="col-sm-4 text-muted">Borrow date</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($borrowing['borrow_date'] ?? '-') ?></dd>

                    <dt class="col-sm-4 text-muted">Due date</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($borrowing['due_date'] ?? '-') ?></dd>

                    <dt class="col-sm-4 text-muted">Returned at</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($borrowing['returned_at'] ?? '-') ?></dd>

                    <dt class="col-sm-4 text-muted">Status</dt>
                    <dd class="col-sm-8">
                        <span class="badge bg-secondary">
                            <?= htmlspecialchars(ucfirst($borrowing['status'])) ?>
                        </span>
                    </dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Actions</h5>

                <?php if ($borrowing['status'] === 'pending'): ?>
                    <form method="POST" action="/admin/borrowings/<?= (int)$borrowing['id'] ?>/approve" class="mb-2">
                        <button class="btn btn-success w-100 rounded-3">
                            <i class="bi bi-check-lg"></i> Approve & Generate Contract
                        </button>
                    </form>
                    <form method="POST" action="/admin/borrowings/<?= (int)$borrowing['id'] ?>/reject"
                        onsubmit="return confirm('Reject this request?')">
                        <button class="btn btn-outline-danger w-100 rounded-3">
                            <i class="bi bi-x-lg"></i> Reject
                        </button>
                    </form>

                <?php elseif ($borrowing['status'] === 'approved' || $borrowing['status'] === 'overdue'): ?>
                    <!-- ═══ UPDATED: allow return for overdue too ═══ -->
                    <form method="POST" action="/admin/borrowings/<?= (int)$borrowing['id'] ?>/return"
                        onsubmit="return confirm('Mark as returned?')">
                        <button class="btn btn-primary w-100 rounded-3">
                            <i class="bi bi-arrow-return-left"></i> Mark as Returned
                        </button>
                    </form>

                <?php else: ?>
                    <p class="text-muted small mb-0">No actions available for this status.</p>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($contract): ?>
            <div class="card border-0 shadow-sm rounded-4 mt-3">
                <div class="card-body p-4">
                    <h6 class="fw-bold">Contract</h6>
                    <div class="small text-muted mb-2">No: <?= htmlspecialchars($contract['contract_no']) ?></div>
                    <a href="/admin/contracts/<?= (int)$contract['id'] ?>" class="btn btn-sm btn-outline-primary rounded-3">
                        View Contract
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require BASE_PATH . '/app/Views/admin/layouts/footer.php'; ?>