<?php require BASE_PATH . '/app/Views/admin/layouts/header.php'; ?>

<?php
$borrowingModel = new \App\Models\Borrowing();
$pending  = $borrowingModel->countByStatus('pending');
$approved = $borrowingModel->countByStatus('approved');
$overdue  = $borrowingModel->countByStatus('overdue');
$returned = $borrowingModel->countByStatus('returned');
?>

<h2 class="fw-bold mb-4">Hi, <?= htmlspecialchars($name) ?> 👋</h2>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="text-muted small">Pending requests</div>
                <div class="fs-2 fw-bold text-warning"><?= $pending ?></div>
                <a href="/admin/borrowings?status=pending" class="btn btn-sm btn-outline-warning mt-2 rounded-3">Review</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="text-muted small">Currently out</div>
                <div class="fs-2 fw-bold text-primary"><?= $approved ?></div>
                <a href="/admin/borrowings?status=approved" class="btn btn-sm btn-outline-primary mt-2 rounded-3">View</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="text-muted small">Overdue</div>
                <div class="fs-2 fw-bold text-danger"><?= $overdue ?></div>
                <a href="/admin/borrowings?status=overdue" class="btn btn-sm btn-outline-danger mt-2 rounded-3">View</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="text-muted small">Returned</div>
                <div class="fs-2 fw-bold text-success"><?= $returned ?></div>
                <a href="/admin/borrowings?status=returned" class="btn btn-sm btn-outline-success mt-2 rounded-3">View</a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="text-muted small">Inventory</div>
                <h3 class="fw-bold mb-0">Manage items</h3>
                <a href="/admin/items" class="btn btn-sm btn-primary mt-3 rounded-3">Open</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="text-muted small">Borrowings</div>
                <h3 class="fw-bold mb-0">All requests</h3>
                <a href="/admin/borrowings" class="btn btn-sm btn-primary mt-3 rounded-3">Open</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="text-muted small">Contracts</div>
                <h3 class="fw-bold mb-0">View agreements</h3>
                <a href="/admin/contracts" class="btn btn-sm btn-primary mt-3 rounded-3">Open</a>
            </div>
        </div>
    </div>
</div>

<?php require BASE_PATH . '/app/Views/admin/layouts/footer.php'; ?>