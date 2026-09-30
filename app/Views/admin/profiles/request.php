<?php require BASE_PATH . '/app/Views/admin/layouts/header.php'; ?>

<section class="py-4"
         style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #334155 100%); color: #fff;">
    <div class="container py-4">
        <a href="/admin/profiles" class="text-decoration-none small d-inline-block mb-3"
           style="color: rgba(255,255,255,.6);">
            <i class="bi bi-arrow-left"></i> Back to profiles
        </a>
        <h1 class="display-5 fw-bold lh-1 mb-2">Profile Change Requests</h1>
        <p class="text-white-50 mb-0">Review requests submitted by students.</p>
    </div>
</section>

<div class="container py-5">

    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="alert alert-success rounded-3 border-0 shadow-sm">
            <i class="bi bi-check-circle me-1"></i>
            <?= htmlspecialchars($_SESSION['flash']) ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <?php if (empty($groups)): ?>
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-5 text-center">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <h4 class="fw-bold mt-3">No pending requests</h4>
                <p class="text-muted mb-0">Students' change requests will appear here.</p>
            </div>
        </div>
    <?php else: ?>

        <div class="d-flex flex-column gap-3">
            <?php foreach ($groups as $g): ?>
                <?php $idParam = implode('-', $g['ids']); ?>
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">

                        <!-- Student header -->
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-primary fw-semibold"
                                      style="width: 44px; height: 44px;">
                                    <?= strtoupper(substr($g['user_name'], 0, 1)) ?>
                                </span>
                                <div>
                                    <div class="fw-bold"><?= htmlspecialchars($g['user_name']) ?></div>
                                    <div class="small text-muted">
                                        <?= htmlspecialchars($g['user_email']) ?>
                                        · <?= htmlspecialchars(date('M d, Y g:i A', strtotime($g['created_at']))) ?>
                                    </div>
                                </div>
                            </div>
                            <span class="badge bg-warning text-dark rounded-pill px-3">
                                <i class="bi bi-clock"></i> Pending Review
                            </span>
                        </div>

                        <!-- Reason -->
                        <div class="rounded-4 p-3 mb-3" style="background: #f8fafc; border-left: 3px solid #0d6efd;">
                            <div class="small text-muted mb-1"><i class="bi bi-chat-left-text"></i> Reason</div>
                            <div class="small"><?= nl2br(htmlspecialchars($g['reason'])) ?></div>
                        </div>

                        <!-- Changes table -->
                        <div class="table-responsive mb-3">
                            <table class="table table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Field</th>
                                        <th>Current</th>
                                        <th></th>
                                        <th>Requested</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($g['changes'] as $c): ?>
                                        <tr>
                                            <td class="fw-semibold small"><?= htmlspecialchars(ucwords(str_replace('_', ' ', $c['field']))) ?></td>
                                            <td class="small text-muted"><?= htmlspecialchars($c['old_value'] ?: '—') ?></td>
                                            <td class="text-muted"><i class="bi bi-arrow-right"></i></td>
                                            <td class="small fw-semibold text-primary"><?= htmlspecialchars($c['new_value']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Proof image -->
                        <?php $pUrl = proof_image_url($g['proof_image']); ?>
                        <?php if ($pUrl): ?>
                            <div class="mb-3">
                                <div class="small text-muted mb-1"><i class="bi bi-image"></i> Proof</div>
                                <a href="<?= htmlspecialchars($pUrl) ?>" target="_blank">
                                    <img src="<?= htmlspecialchars($pUrl) ?>" alt="Proof"
                                         class="rounded-4"
                                         style="max-height: 160px; object-fit: cover;">
                                </a>
                            </div>
                        <?php endif; ?>

                        <!-- Actions -->
                        <div class="d-flex gap-2 mt-3 pt-3 border-top">
                            <form method="POST" action="/admin/profiles/requests/<?= $idParam ?>/approve"
                                  onsubmit="return confirm('Approve and apply these changes?')"
                                  class="flex-grow-1">
                                <button class="btn btn-success rounded-3 w-100">
                                    <i class="bi bi-check-lg"></i> Approve & Apply
                                </button>
                            </form>
                            <button type="button" class="btn btn-outline-danger rounded-3 flex-grow-1"
                                    data-bs-toggle="collapse" data-bs-target="#reject-<?= (int)$g['ids'][0] ?>">
                                <i class="bi bi-x-lg"></i> Reject
                            </button>
                        </div>

                        <!-- Reject form -->
                        <div class="collapse mt-3" id="reject-<?= (int)$g['ids'][0] ?>">
                            <form method="POST" action="/admin/profiles/requests/<?= $idParam ?>/reject">
                                <label class="form-label small fw-semibold text-muted">Reason for rejection</label>
                                <textarea name="admin_note" rows="2" class="form-control rounded-3 mb-2"
                                          placeholder="Explain why this request is being rejected"
                                          required></textarea>
                                <button class="btn btn-danger rounded-3 w-100">
                                    <i class="bi bi-x-lg"></i> Confirm Rejection
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</div>

<?php require BASE_PATH . '/app/Views/admin/layouts/footer.php'; ?>