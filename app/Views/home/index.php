<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<!-- ═══ HERO ═══ -->
<section class="pcu-hero py-5 position-relative overflow-hidden">
    <div class="container py-5">
        <div class="row align-items-center g-5">

            <div class="col-lg-6">
                <span class="badge-pcu mb-3 d-inline-block">
                    <i class="bi bi-mortarboard-fill"></i>
                    Philippine Christian University
                </span>

                <h1 class="display-3 fw-bold lh-1 mb-4 text-white">
                    Borrow what you need.<br>
                    <span class="text-pcu-gold">Return on time.</span>
                </h1>

                <p class="lead text-white-50 mb-4" style="max-width: 540px;">
                    The official item borrowing platform of Philippine Christian University —
                    browse equipment, submit requests, and track your loans — all in one place.
                </p>

                <div class="d-flex flex-wrap gap-2 mb-4">
                    <?php if (!empty($_SESSION['user_id'])): ?>
                        <a href="<?= ($_SESSION['role'] ?? '') === 'admin' ? '/admin/dashboard' : '/dashboard' ?>"
                           class="btn btn-gold btn-lg rounded-3 px-4">
                            Go to Dashboard <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="/items" class="btn btn-outline-light btn-lg rounded-3 px-4">
                            <i class="bi bi-grid"></i> Browse Items
                        </a>
                    <?php else: ?>
                        <a href="/signup" class="btn btn-gold btn-lg rounded-3 px-4">
                            Get Started <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="/login" class="btn btn-outline-light btn-lg rounded-3 px-4">
                            Sign In
                        </a>
                    <?php endif; ?>
                </div>

                <div class="d-flex flex-wrap gap-4 text-white-50 small">
                    <div><i class="bi bi-check-circle-fill text-pcu-gold me-1"></i> Faith</div>
                    <div><i class="bi bi-check-circle-fill text-pcu-gold me-1"></i> Character</div>
                    <div><i class="bi bi-check-circle-fill text-pcu-gold me-1"></i> Service</div>
                </div>
            </div>

            <div class="col-lg-6 d-none d-lg-block">
                <div class="p-4 rounded-4 shadow-lg"
                     style="background: rgba(255,255,255,.06); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,.1);">
                    <div class="d-flex align-items-center gap-2 mb-4">
                        <span class="d-inline-block rounded-circle" style="width:10px;height:10px;background:#ef4444;"></span>
                        <span class="d-inline-block rounded-circle" style="width:10px;height:10px;background:#fbbf24;"></span>
                        <span class="d-inline-block rounded-circle" style="width:10px;height:10px;background:#22c55e;"></span>
                        <span class="ms-2 text-white-50 small">pcu-borrow-system</span>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <div class="p-3 rounded-3" style="background: rgba(255,255,255,.06);">
                                <div class="text-white-50 small">Active Loans</div>
                                <div class="fs-3 fw-bold text-white">3</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-3" style="background: rgba(255,255,255,.06);">
                                <div class="text-white-50 small">Due Soon</div>
                                <div class="fs-3 fw-bold text-pcu-gold">1</div>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 rounded-3 mb-2" style="background: rgba(255,255,255,.06);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold text-white">Dell XPS Laptop</div>
                                <div class="text-white-50 small">Due Sep 24, 2026</div>
                            </div>
                            <span class="badge bg-primary">Approved</span>
                        </div>
                    </div>

                    <div class="p-3 rounded-3" style="background: rgba(255,255,255,.06);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold text-white">Epson Projector</div>
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
<section class="py-3" style="background: #0f1e5c; color: #fff;">
    <div class="container">
        <div class="row text-center text-white-50 small">
            <div class="col-6 col-md-3 py-2">
                <i class="bi bi-shield-check text-pcu-gold me-1"></i> Secure by design
            </div>
            <div class="col-6 col-md-3 py-2">
                <i class="bi bi-lightning-charge text-pcu-gold me-1"></i> Fast & lightweight
            </div>
            <div class="col-6 col-md-3 py-2">
                <i class="bi bi-phone text-pcu-gold me-1"></i> Mobile-ready
            </div>
            <div class="col-6 col-md-3 py-2">
                <i class="bi bi-people text-pcu-gold me-1"></i> For students & staff
            </div>
        </div>
    </div>
</section>

<!-- ═══ FEATURES ═══ -->
<section class="py-5">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="badge-pcu-dark mb-2">Features</span>
            <h2 class="fw-bold">Everything you need to borrow with confidence</h2>
            <p class="text-muted mx-auto" style="max-width: 620px;">
                From inventory management to signed contracts — the platform handles the whole lifecycle.
            </p>
        </div>

        <div class="row g-4">
            <?php
            $features = [
                ['bi-grid-3x3-gap',        'Inventory Management', 'Admins add, edit, and organize items with images, categories, and live stock counts.'],
                ['bi-file-earmark-check',  'Automatic Contracts',  'Every approved request generates a printable agreement with signature blocks.'],
                ['bi-clock-history',       'Due-Date Tracking',    'Automatic overdue detection flips late loans and blocks new requests.'],
                ['bi-people',              'Role-Based Access',    'Students browse and request. Admins approve and manage. Clean separation.'],
                ['bi-graph-up',            'Dashboards & Stats',   'Real-time counters for pending, active, overdue, and returned items.'],
                ['bi-lock',                'Safe by Default',      'Bcrypt password hashing, prepared statements, and validated uploads.'],
            ];
            foreach ($features as [$icon, $title, $desc]):
            ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <div class="rounded-3 d-inline-flex p-3 mb-3"
                                 style="background: rgba(30, 58, 138, .1);">
                                <i class="bi <?= $icon ?> fs-3" style="color: var(--pcu-blue);"></i>
                            </div>
                            <h5 class="fw-bold"><?= $title ?></h5>
                            <p class="text-muted mb-0 small"><?= $desc ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══ HOW IT WORKS ═══ -->
<section class="py-5" style="background: #f1f5f9;">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="badge-pcu-dark mb-2">Workflow</span>
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
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center fw-bold mb-3 text-white"
                                 style="width: 40px; height: 40px; background: var(--pcu-blue);">
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

<!-- ═══ CTA ═══ -->
<section class="pcu-hero py-5">
    <div class="container py-4 text-center">
        <h2 class="fw-bold mb-3 text-white">Ready to get started?</h2>
        <p class="text-white-50 mb-4 mx-auto" style="max-width: 540px;">
            Create an account and start borrowing in under a minute.
        </p>

        <?php if (!empty($_SESSION['user_id'])): ?>
            <a href="<?= ($_SESSION['role'] ?? '') === 'admin' ? '/admin/dashboard' : '/dashboard' ?>"
               class="btn btn-gold btn-lg rounded-3 px-4">
                Go to Dashboard <i class="bi bi-arrow-right"></i>
            </a>
        <?php else: ?>
            <a href="/signup" class="btn btn-gold btn-lg rounded-3 px-4 me-2">
                Create Account <i class="bi bi-arrow-right"></i>
            </a>
            <a href="/login" class="btn btn-outline-light btn-lg rounded-3 px-4">
                Sign In
            </a>
        <?php endif; ?>
    </div>
</section>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>