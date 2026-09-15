<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<!-- ═══ HERO ═══ -->
<section class="py-5 position-relative overflow-hidden"
         style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #334155 100%); color: #fff;">
    <div class="container py-5 position-relative" style="z-index: 2;">
        <div class="row align-items-center g-5">

            <div class="col-lg-6">
                <span class="badge bg-primary bg-opacity-25 text-primary-emphasis mb-3 px-3 py-2 rounded-pill">
                    <i class="bi bi-stars"></i> Modern Borrowing System
                </span>

                <h1 class="display-3 fw-bold lh-1 mb-4">
                    Borrow what you need.<br>
                    <span class="text-primary">Return on time.</span>
                </h1>

                <p class="lead text-white-50 mb-4" style="max-width: 540px;">
                    A modern item borrowing platform for students and staff.
                    Browse inventory, submit requests, and track your loans —
                    all in one clean dashboard.
                </p>

                <div class="d-flex flex-wrap gap-2 mb-4">
                    <?php if (!empty($_SESSION['user_id'])): ?>
                        <a href="<?= ($_SESSION['role'] ?? '') === 'admin' ? '/admin/dashboard' : '/dashboard' ?>"
                           class="btn btn-primary btn-lg rounded-3 px-4">
                            Go to Dashboard <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="/items" class="btn btn-outline-light btn-lg rounded-3 px-4">
                            <i class="bi bi-grid"></i> Browse Items
                        </a>
                    <?php else: ?>
                        <a href="/signup" class="btn btn-primary btn-lg rounded-3 px-4">
                            Get Started Free <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="/login" class="btn btn-outline-light btn-lg rounded-3 px-4">
                            Sign In
                        </a>
                    <?php endif; ?>
                </div>

                <div class="d-flex align-items-center gap-4 text-white-50 small">
                    <div><i class="bi bi-check-circle-fill text-primary me-1"></i> No paperwork</div>
                    <div><i class="bi bi-check-circle-fill text-primary me-1"></i> Auto contracts</div>
                    <div><i class="bi bi-check-circle-fill text-primary me-1"></i> Due-date tracking</div>
                </div>
            </div>

            <!-- Hero visual: mock dashboard card -->
            <div class="col-lg-6 d-none d-lg-block">
                <div class="p-4 rounded-4 shadow-lg"
                     style="background: rgba(255,255,255,.05); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,.1);">

                    <div class="d-flex align-items-center gap-2 mb-4">
                        <span class="d-inline-block rounded-circle" style="width:10px;height:10px;background:#ef4444;"></span>
                        <span class="d-inline-block rounded-circle" style="width:10px;height:10px;background:#f59e0b;"></span>
                        <span class="d-inline-block rounded-circle" style="width:10px;height:10px;background:#22c55e;"></span>
                        <span class="ms-2 text-white-50 small">dashboard</span>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <div class="p-3 rounded-3" style="background: rgba(255,255,255,.06);">
                                <div class="text-white-50 small">Active Loans</div>
                                <div class="fs-3 fw-bold">3</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-3" style="background: rgba(255,255,255,.06);">
                                <div class="text-white-50 small">Due Soon</div>
                                <div class="fs-3 fw-bold text-warning">1</div>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 rounded-3 mb-2" style="background: rgba(255,255,255,.06);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold">Laptop — Dell XPS</div>
                                <div class="text-white-50 small">Due Sep 24, 2026</div>
                            </div>
                            <span class="badge bg-primary">Approved</span>
                        </div>
                    </div>

                    <div class="p-3 rounded-3" style="background: rgba(255,255,255,.06);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold">Projector — Epson</div>
                                <div class="text-white-50 small">Due Sep 21, 2026</div>
                            </div>
                            <span class="badge bg-warning text-dark">Soon</span>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══ TRUST STRIP ═══ -->
<section class="py-3" style="background: #0b1220; color: #fff;">
    <div class="container">
        <div class="row text-center text-white-50 small">
            <div class="col-6 col-md-3 py-2">
                <i class="bi bi-shield-check text-primary me-1"></i> Secure by design
            </div>
            <div class="col-6 col-md-3 py-2">
                <i class="bi bi-lightning-charge text-primary me-1"></i> Fast & lightweight
            </div>
            <div class="col-6 col-md-3 py-2">
                <i class="bi bi-phone text-primary me-1"></i> Mobile-ready
            </div>
            <div class="col-6 col-md-3 py-2">
                <i class="bi bi-people text-primary me-1"></i> Built for institutions
            </div>
        </div>
    </div>
</section>

<!-- ═══ FEATURES ═══ -->
<section class="py-5">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="badge bg-primary bg-opacity-10 text-primary mb-2 px-3 py-2 rounded-pill">Features</span>
            <h2 class="fw-bold">Everything you need to lend with confidence</h2>
            <p class="text-muted mx-auto" style="max-width: 620px;">
                From inventory management to digital contracts — the platform handles the whole lifecycle.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="bg-primary bg-opacity-10 rounded-3 d-inline-flex p-3 mb-3">
                            <i class="bi bi-grid-3x3-gap fs-3 text-primary"></i>
                        </div>
                        <h5 class="fw-bold">Inventory Management</h5>
                        <p class="text-muted mb-0 small">
                            Admins add, edit, and organize items with images, categories, and live stock counts.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="bg-success bg-opacity-10 rounded-3 d-inline-flex p-3 mb-3">
                            <i class="bi bi-file-earmark-check fs-3 text-success"></i>
                        </div>
                        <h5 class="fw-bold">Automatic Contracts</h5>
                        <p class="text-muted mb-0 small">
                            Every approved request generates a printable agreement with signature blocks.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="bg-warning bg-opacity-10 rounded-3 d-inline-flex p-3 mb-3">
                            <i class="bi bi-clock-history fs-3 text-warning"></i>
                        </div>
                        <h5 class="fw-bold">Due-Date Tracking</h5>
                        <p class="text-muted mb-0 small">
                            Automatic overdue detection flips late loans and blocks new requests.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="bg-info bg-opacity-10 rounded-3 d-inline-flex p-3 mb-3">
                            <i class="bi bi-people fs-3 text-info"></i>
                        </div>
                        <h5 class="fw-bold">Role-Based Access</h5>
                        <p class="text-muted mb-0 small">
                            Students browse and request. Admins approve and manage. Clean separation.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="bg-danger bg-opacity-10 rounded-3 d-inline-flex p-3 mb-3">
                            <i class="bi bi-graph-up fs-3 text-danger"></i>
                        </div>
                        <h5 class="fw-bold">Dashboards & Stats</h5>
                        <p class="text-muted mb-0 small">
                            Real-time counters for pending, active, overdue, and returned items.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="bg-dark bg-opacity-10 rounded-3 d-inline-flex p-3 mb-3">
                            <i class="bi bi-lock fs-3 text-dark"></i>
                        </div>
                        <h5 class="fw-bold">Safe by Default</h5>
                        <p class="text-muted mb-0 small">
                            Bcrypt password hashing, prepared statements, and validated uploads out of the box.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ HOW IT WORKS ═══ -->
<section class="py-5" style="background: #f1f5f9;">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="badge bg-primary bg-opacity-10 text-primary mb-2 px-3 py-2 rounded-pill">Workflow</span>
            <h2 class="fw-bold">Borrow in four simple steps</h2>
            <p class="text-muted">No paperwork. No confusion. Just a smooth process.</p>
        </div>

        <div class="row g-4">
            <?php
            $steps = [
                ['1', 'Browse',  'Explore the inventory and filter by category to find what you need.'],
                ['2', 'Request', 'Submit a borrow request with preferred dates and quantity.'],
                ['3', 'Approve', 'Admins review, approve, and auto-generate a signed contract.'],
                ['4', 'Return',  'Return on time. Stock is restored and your history stays clean.'],
            ];
            foreach ($steps as [$n, $title, $desc]):
            ?>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center fw-bold mb-3"
                                 style="width: 40px; height: 40px;">
                                <?= $n ?>
                            </div>
                            <h6 class="fw-bold"><?= $title ?></h6>
                            <p class="text-muted small mb-0"><?= $desc ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══ SPLIT FEATURE ═══ -->
<section class="py-5">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="badge bg-primary bg-opacity-10 text-primary mb-2 px-3 py-2 rounded-pill">For Admins</span>
                <h2 class="fw-bold mb-3">Full control over your inventory</h2>
                <p class="text-muted mb-4">
                    Track every unit in real time. Approve or reject requests with a click.
                    Contracts generate themselves the moment you approve.
                </p>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Live stock counters</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Bulk borrow approvals</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Printable PDF contracts</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Overdue tracking & alerts</li>
                </ul>
            </div>
            <div class="col-lg-6">
                <div class="p-4 rounded-4 shadow-sm border">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="fw-bold">Inventory Snapshot</div>
                        <span class="badge bg-success">Live</span>
                    </div>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>Dell XPS Laptop</span>
                            <span class="badge bg-primary">3 / 5</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>Epson Projector</span>
                            <span class="badge bg-primary">1 / 2</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>Lab Microscope</span>
                            <span class="badge bg-danger">0 / 3</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ CTA ═══ -->
<section class="py-5" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #334155 100%); color: #fff;">
    <div class="container py-4 text-center">
        <h2 class="fw-bold mb-3">Ready to get started?</h2>
        <p class="text-white-50 mb-4 mx-auto" style="max-width: 540px;">
            Create an account and start borrowing in under a minute. No credit card, no paperwork.
        </p>

        <?php if (!empty($_SESSION['user_id'])): ?>
            <a href="<?= ($_SESSION['role'] ?? '') === 'admin' ? '/admin/dashboard' : '/dashboard' ?>"
               class="btn btn-primary btn-lg rounded-3 px-4">
                Go to Dashboard <i class="bi bi-arrow-right"></i>
            </a>
        <?php else: ?>
            <a href="/signup" class="btn btn-primary btn-lg rounded-3 px-4 me-2">
                Create Account <i class="bi bi-arrow-right"></i>
            </a>
            <a href="/login" class="btn btn-outline-light btn-lg rounded-3 px-4">
                Sign In
            </a>
        <?php endif; ?>
    </div>
</section>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>