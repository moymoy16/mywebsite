<?php require BASE_PATH . '/app/Views/admin/layouts/header.php'; ?>

<?php
$isUsers   = $tab === 'users';
$isPass    = $tab === 'password';
$isProfile = $tab === 'profile';
?>

<!-- ═══ HERO ═══ -->
<section style="background: linear-gradient(135deg, #0f1e5c 0%, #1e3a8a 60%, #2d4fb8 100%); color:#fff;">
    <div class="container-fluid px-4 py-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="badge-pcu mb-3 d-inline-block">
                    <i class="bi bi-people"></i> User Management
                </span>
                <h1 class="display-6 fw-bold lh-1 mb-2 text-white">Users & Students</h1>
                <p class="text-white-50 mb-0" style="max-width: 520px;">
                    Manage accounts, profiles, and approval requests.
                </p>
            </div>
            <div class="col-lg-5">
                <div class="d-flex justify-content-lg-end">
                    <?php if ($pendingResets > 0 || $pendingProfiles > 0): ?>
                        <a href="/admin/users?tab=password" class="btn btn-gold rounded-3">
                            <i class="bi bi-bell"></i>
                            <?= $pendingResets + $pendingProfiles ?> Pending
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container-fluid px-4 py-5">

    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="alert alert-success rounded-4 border-0 shadow-sm">
            <i class="bi bi-check-circle me-1"></i>
            <?= htmlspecialchars($_SESSION['flash']) ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <!-- ═══ TABS ═══ -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap gap-2">
                <a href="/admin/users?tab=users"
                   class="btn btn-sm <?= $isUsers ? 'btn-primary' : 'btn-outline-secondary' ?> rounded-pill px-3">
                    <i class="bi bi-people"></i> All Users
                    <span class="badge <?= $isUsers ? 'bg-white text-primary' : 'bg-secondary bg-opacity-25 text-secondary' ?> ms-1">
                        <?= count($users) ?>
                    </span>
                </a>
                <a href="/admin/users?tab=password"
                   class="btn btn-sm <?= $isPass ? 'btn-primary' : 'btn-outline-secondary' ?> rounded-pill px-3">
                    <i class="bi bi-key"></i> Password Requests
                    <?php if ($pendingResets > 0): ?>
                        <span class="badge bg-warning text-dark ms-1"><?= $pendingResets ?></span>
                    <?php else: ?>
                        <span class="badge <?= $isPass ? 'bg-white text-primary' : 'bg-secondary bg-opacity-25 text-secondary' ?> ms-1">0</span>
                    <?php endif; ?>
                </a>
                <a href="/admin/users?tab=profile"
                   class="btn btn-sm <?= $isProfile ? 'btn-primary' : 'btn-outline-secondary' ?> rounded-pill px-3">
                    <i class="bi bi-pencil-square"></i> Profile Requests
                    <?php if ($pendingProfiles > 0): ?>
                        <span class="badge bg-warning text-dark ms-1"><?= $pendingProfiles ?></span>
                    <?php else: ?>
                        <span class="badge <?= $isProfile ? 'bg-white text-primary' : 'bg-secondary bg-opacity-25 text-secondary' ?> ms-1">0</span>
                    <?php endif; ?>
                </a>
            </div>
        </div>
    </div>

    <?php if ($isUsers): ?>

        <!-- ═══ TAB 1: ALL USERS ═══ -->

        <!-- Search + filter -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-3">
                <form method="GET" action="/admin/users">
                    <input type="hidden" name="tab" value="users">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Search</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" name="search"
                                       class="form-control border-start-0 rounded-end-3"
                                       placeholder="Name, email, student ID, section..."
                                       value="<?= htmlspecialchars($search) ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-muted">Role</label>
                            <select name="role" class="form-select rounded-3">
                                <option value="">All roles</option>
                                <option value="student" <?= $role === 'student' ? 'selected' : '' ?>>Students</option>
                                <option value="admin"   <?= $role === 'admin'   ? 'selected' : '' ?>>Admins</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-grid">
                            <button class="btn btn-primary rounded-3">
                                <i class="bi bi-funnel"></i> Filter
                            </button>
                        </div>
                    </div>
                    <?php if ($search !== '' || $role !== ''): ?>
                        <div class="mt-2">
                            <a href="/admin/users?tab=users" class="small text-decoration-none"
                               style="color: var(--pcu-blue);">
                                <i class="bi bi-x-circle"></i> Clear filters
                            </a>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <?php if (empty($users)): ?>
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-5 text-center">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <h4 class="fw-bold mt-3">No users found</h4>
                    <p class="text-muted mb-0">Try adjusting your filters.</p>
                </div>
            </div>
        <?php else: ?>

            <div class="text-muted small mb-3">
                Showing <strong><?= count($users) ?></strong> user<?= count($users) === 1 ? '' : 's' ?>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width: 60px;">#</th>
                                <th>User</th>
                                <th style="width: 120px;">Role</th>
                                <th style="width: 130px;">Student ID</th>
                                <th style="width: 100px;">Section</th>
                                <th style="width: 110px;">Year</th>
                                <th class="text-end pe-4" style="width: 200px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($users as $i => $u): ?>
                            <tr>
                                <td class="ps-4 text-muted small"><?= $i + 1 ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle fw-semibold"
                                              style="width: 36px; height: 36px; font-size: 13px;
                                                     background: rgba(30,58,138,.1); color: var(--pcu-blue);">
                                            <?= strtoupper(substr($u['name'], 0, 1)) ?>
                                        </span>
                                        <div>
                                            <div class="fw-semibold"><?= htmlspecialchars($u['name']) ?></div>
                                            <div class="small text-muted"><?= htmlspecialchars($u['email']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($u['role'] === 'admin'): ?>
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">
                                            <i class="bi bi-shield-lock"></i> Admin
                                        </span>
                                    <?php else: ?>
                                        <span class="badge-pcu-dark small" style="padding: 4px 12px; font-size: 11px;">
                                            <i class="bi bi-person"></i> Student
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="small"><?= htmlspecialchars($u['student_id'] ?? '—') ?></td>
                                <td class="small"><?= htmlspecialchars($u['section'] ?? '—') ?></td>
                                <td class="small"><?= htmlspecialchars($u['year_level'] ?? '—') ?></td>
                                <td class="text-end pe-4">
                                    <div class="d-inline-flex gap-1">
                                        <a href="/admin/users/profile/<?= (int)$u['id'] ?>/edit"
                                           class="btn btn-sm btn-outline-primary rounded-3">
                                            <i class="bi bi-pencil"></i> Profile
                                        </a>
                                        <?php if ($u['role'] === 'student'): ?>
                                            <a href="/admin/users/reset-direct/<?= (int)$u['id'] ?>"
                                               class="btn btn-sm btn-outline-warning rounded-3">
                                                <i class="bi bi-key"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        <?php endif; ?>

    <?php elseif ($isPass): ?>

        <!-- ═══ TAB 2: PASSWORD REQUESTS ═══ -->
        <?php if (empty($passwordRequests)): ?>
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-5 text-center">
                    <i class="bi bi-key display-1 text-muted"></i>
                    <h4 class="fw-bold mt-3">No password requests</h4>
                    <p class="text-muted mb-0">Students' reset requests will appear here.</p>
                </div>
            </div>
        <?php else: ?>
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width: 60px;">#</th>
                                <th>Student</th>
                                <th>Message</th>
                                <th style="width: 130px;">Requested</th>
                                <th style="width: 120px;">Status</th>
                                <th class="text-end pe-4" style="width: 140px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($passwordRequests as $i => $r): ?>
                            <?php
                                $statusBadge = [
                                    'pending'  => 'bg-warning text-dark',
                                    'resolved' => 'bg-success',
                                    'expired'  => 'bg-secondary',
                                ][$r['status']] ?? 'bg-secondary';
                            ?>
                            <tr>
                                <td class="ps-4 text-muted small"><?= $i + 1 ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle fw-semibold"
                                              style="width: 36px; height: 36px; font-size: 13px;
                                                     background: rgba(30,58,138,.1); color: var(--pcu-blue);">
                                            <?= strtoupper(substr($r['user_name'], 0, 1)) ?>
                                        </span>
                                        <div>
                                            <div class="fw-semibold"><?= htmlspecialchars($r['user_name']) ?></div>
                                            <div class="small text-muted"><?= htmlspecialchars($r['user_email']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="small text-muted">
                                    <?= $r['note'] ? htmlspecialchars(mb_strimwidth($r['note'], 0, 50, '...')) : '<em>—</em>' ?>
                                </td>
                                <td class="small text-muted">
                                    <?= htmlspecialchars(date('M d, g:i A', strtotime($r['created_at']))) ?>
                                </td>
                                <td>
                                    <span class="badge <?= $statusBadge ?> rounded-pill px-3">
                                        <?= ucfirst($r['status']) ?>
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <?php if ($r['status'] === 'pending'): ?>
                                        <a href="/admin/users/reset/<?= (int)$r['id'] ?>"
                                           class="btn btn-sm btn-primary rounded-3">
                                            <i class="bi bi-key"></i> Reset
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>

    <?php elseif ($isProfile): ?>

        <!-- ═══ TAB 3: PROFILE CHANGE REQUESTS ═══ -->
        <?php if (empty($profileGroups)): ?>
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-5 text-center">
                    <i class="bi bi-pencil-square display-1 text-muted"></i>
                    <h4 class="fw-bold mt-3">No profile requests</h4>
                    <p class="text-muted mb-0">Students' change requests will appear here.</p>
                </div>
            </div>
        <?php else: ?>
            <div class="d-flex flex-column gap-3">
                <?php foreach ($profileGroups as $g): ?>
                    <?php $idParam = implode('-', $g['ids']); ?>
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">

                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle fw-semibold"
                                          style="width: 44px; height: 44px;
                                                 background: rgba(30,58,138,.1); color: var(--pcu-blue);">
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
                                <span class="badge-pcu-dark small">
                                    <i class="bi bi-clock"></i> Pending
                                </span>
                            </div>

                            <div class="rounded-4 p-3 mb-3"
                                 style="background: #f8fafc; border-left: 3px solid var(--pcu-blue);">
                                <div class="small text-muted mb-1"><i class="bi bi-chat-left-text"></i> Reason</div>
                                <div class="small"><?= nl2br(htmlspecialchars($g['reason'])) ?></div>
                            </div>

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
                                                <td class="small fw-semibold text-pcu-blue"><?= htmlspecialchars($c['new_value']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

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

                            <div class="d-flex gap-2 mt-3 pt-3 border-top">
                                <form method="POST" action="/admin/users/profile-requests/<?= $idParam ?>/approve"
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

                            <div class="collapse mt-3" id="reject-<?= (int)$g['ids'][0] ?>">
                                <form method="POST" action="/admin/users/profile-requests/<?= $idParam ?>/reject">
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

    <?php endif; ?>

</div>

<?php require BASE_PATH . '/app/Views/admin/layouts/footer.php'; ?>