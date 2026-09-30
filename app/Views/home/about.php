<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<!-- ═══ HERO ═══ -->
<section class="pcu-hero py-5">
    <div class="container py-5 text-center">
        <span class="badge-pcu mb-3 d-inline-block">
            <i class="bi bi-info-circle"></i> About Us
        </span>
        <h1 class="display-4 fw-bold mb-3 text-white">
            Built for Borrowers.<br>
            <span class="text-pcu-gold">Trusted by Institutions.</span>
        </h1>
        <p class="lead text-white-50 mx-auto" style="max-width: 720px;">
            PCU Borrow System is the official item borrowing platform of Philippine Christian University.
            From lab equipment to classroom tools — we bring transparency, accountability,
            and simplicity to institutional lending.
        </p>
    </div>
</section>

<!-- ═══ MISSION / VISION / VALUES ═══ -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">

            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="rounded-3 d-inline-flex p-3 mb-3"
                             style="background: rgba(30, 58, 138, .1);">
                            <i class="bi bi-bullseye fs-3" style="color: var(--pcu-blue);"></i>
                        </div>
                        <h5 class="fw-bold">Our Mission</h5>
                        <p class="text-muted mb-0">
                            To simplify how the university lends and tracks physical assets —
                            replacing paperwork and guesswork with a fast, transparent,
                            and accountable digital process.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="rounded-3 d-inline-flex p-3 mb-3"
                             style="background: rgba(251, 191, 36, .15);">
                            <i class="bi bi-eye fs-3" style="color: #b45309;"></i>
                        </div>
                        <h5 class="fw-bold">Our Vision</h5>
                        <p class="text-muted mb-0">
                            A community where borrowing is as easy as browsing — where every
                            transaction is documented, every return is on time, and every
                            borrower is trusted.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="rounded-3 d-inline-flex p-3 mb-3"
                             style="background: rgba(30, 58, 138, .1);">
                            <i class="bi bi-heart fs-3" style="color: var(--pcu-blue);"></i>
                        </div>
                        <h5 class="fw-bold">Our Values</h5>
                        <p class="text-muted mb-0">
                            Transparency in every transaction, respect for shared resources,
                            and a commitment to our core values — <strong>Faith, Character,
                            and Service</strong>.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══ WHAT WE OFFER ═══ -->
<section class="py-5" style="background: #f1f5f9;">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge-pcu-dark mb-2">Capabilities</span>
            <h2 class="fw-bold">What We Offer</h2>
            <p class="text-muted">Everything you need to run a fair and efficient borrowing system.</p>
        </div>

        <div class="row g-4">
            <?php
            $offerings = [
                ['bi-grid-3x3-gap',       'Inventory Management', 'Organize items by category with live stock counts and images.'],
                ['bi-file-earmark-check', 'Digital Contracts',    'Every approval auto-generates a printable signed agreement.'],
                ['bi-clock-history',      'Due Date Tracking',    'Automatic overdue detection keeps everyone on schedule.'],
                ['bi-shield-check',       'Role-Based Access',    'Students browse and borrow — admins manage and approve.'],
            ];
            foreach ($offerings as [$icon, $title, $desc]):
            ?>
                <div class="col-md-6 col-lg-3">
                    <div class="text-center p-4 h-100">
                        <i class="bi <?= $icon ?> fs-1" style="color: var(--pcu-blue);"></i>
                        <h6 class="fw-bold mt-3"><?= $title ?></h6>
                        <p class="text-muted small mb-0"><?= $desc ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══ HOW IT WORKS ═══ -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge-pcu-dark mb-2">Workflow</span>
            <h2 class="fw-bold">How It Works</h2>
            <p class="text-muted">Four simple steps from browsing to returning.</p>
        </div>

        <div class="row g-4">
            <?php
            $steps = [
                ['1', 'Browse',  'Explore the inventory and filter by category to find what you need.'],
                ['2', 'Request', 'Submit a borrow request with your preferred dates and quantity.'],
                ['3', 'Approve', 'Admins review the request and generate a contract upon approval.'],
                ['4', 'Return',  'Return items on time. Stock is restored and your history stays clean.'],
            ];
            foreach ($steps as [$n, $title, $desc]):
            ?>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <span class="badge rounded-circle d-inline-flex align-items-center justify-content-center fw-bold text-white"
                                      style="width: 32px; height: 32px; background: var(--pcu-blue);">
                                    <?= $n ?>
                                </span>
                                <h6 class="fw-bold mb-0"><?= $title ?></h6>
                            </div>
                            <p class="text-muted small mb-0"><?= $desc ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══ STATS ═══ -->
<section class="py-5" style="background: #0f1e5c; color: #fff;">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-3">
                <div class="display-5 fw-bold text-pcu-gold">100%</div>
                <div class="text-white-50 small text-uppercase">Digital Process</div>
            </div>
            <div class="col-md-3">
                <div class="display-5 fw-bold text-pcu-gold">24/7</div>
                <div class="text-white-50 small text-uppercase">Available Online</div>
            </div>
            <div class="col-md-3">
                <div class="display-5 fw-bold text-pcu-gold">0</div>
                <div class="text-white-50 small text-uppercase">Paper Contracts</div>
            </div>
            <div class="col-md-3">
                <div class="display-5 fw-bold text-pcu-gold">∞</div>
                <div class="text-white-50 small text-uppercase">Items Supported</div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ CTA ═══ -->
<section class="pcu-hero py-5">
    <div class="container text-center py-4">
        <h2 class="fw-bold mb-3 text-white">Ready to get started?</h2>
        <p class="text-white-50 mb-4">Create an account and start borrowing in under a minute.</p>

        <?php if (!empty($_SESSION['user_id'])): ?>
            <a href="<?= ($_SESSION['role'] ?? '') === 'admin' ? '/admin/dashboard' : '/dashboard' ?>"
               class="btn btn-gold btn-lg rounded-3 px-4">
                Go to Dashboard <i class="bi bi-arrow-right"></i>
            </a>
        <?php else: ?>
            <a href="/signup" class="btn btn-gold btn-lg rounded-3 px-4 me-2">
                Get Started <i class="bi bi-arrow-right"></i>
            </a>
            <a href="/login" class="btn btn-outline-light btn-lg rounded-3 px-4">
                Sign In
            </a>
        <?php endif; ?>
    </div>
</section>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>