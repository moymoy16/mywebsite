<?php require BASE_PATH . '/app/Views/admin/layouts/header.php'; ?>

<a href="/admin/contracts" class="text-decoration-none small mb-3 d-inline-block">
    <i class="bi bi-arrow-left"></i> Back to contracts
</a>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Contract <?= htmlspecialchars($contract['contract_no']) ?></h2>
        <div class="text-muted small">
            Created <?= htmlspecialchars($contract['created_at']) ?>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="/admin/contracts/<?= (int)$contract['id'] ?>/print" target="_blank"
           class="btn btn-outline-primary rounded-3">
            <i class="bi bi-printer"></i> Print
        </a>

        <?php if (!$contract['signed_at']): ?>
            <form method="POST" action="/admin/contracts/<?= (int)$contract['id'] ?>/sign"
                  onsubmit="return confirm('Mark as signed?')">
                <button class="btn btn-success rounded-3">
                    <i class="bi bi-pen"></i> Mark as Signed
                </button>
            </form>
        <?php else: ?>
            <span class="badge bg-success align-self-center px-3 py-2">
                Signed <?= htmlspecialchars($contract['signed_at']) ?>
            </span>
        <?php endif; ?>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <h6 class="text-muted text-uppercase small fw-bold mb-3">Borrower</h6>
                <div class="fw-semibold fs-5"><?= htmlspecialchars($contract['student_name']) ?></div>
                <div class="text-muted small"><?= htmlspecialchars($contract['student_email']) ?></div>
                <?php if (!empty($contract['student_id'])): ?>
                    <div class="text-muted small">ID: <?= htmlspecialchars($contract['student_id']) ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <h6 class="text-muted text-uppercase small fw-bold mb-3">Item</h6>
                <div class="fw-semibold fs-5"><?= htmlspecialchars($contract['item_name']) ?></div>
                <div class="text-muted small"><?= htmlspecialchars($contract['category']) ?></div>
                <div class="text-muted small">Quantity: <?= (int)$contract['quantity'] ?></div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h6 class="text-muted text-uppercase small fw-bold mb-3">Schedule</h6>
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-muted small">Borrow date</div>
                        <div class="fw-semibold"><?= htmlspecialchars($contract['borrow_date']) ?></div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted small">Due date</div>
                        <div class="fw-semibold"><?= htmlspecialchars($contract['due_date']) ?></div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted small">Borrowing status</div>
                        <div class="fw-semibold"><?= htmlspecialchars(ucfirst($contract['borrowing_status'])) ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h6 class="text-muted text-uppercase small fw-bold mb-3">Terms</h6>
                <p class="mb-0"><?= nl2br(htmlspecialchars($contract['terms'])) ?></p>
            </div>
        </div>
    </div>
</div>

<?php require BASE_PATH . '/app/Views/admin/layouts/footer.php'; ?>