<?php require BASE_PATH . '/app/Views/student/layouts/header.php'; ?>

<?php $old = $old ?? []; ?>

<div class="container py-5">

    <a href="/profile" class="text-decoration-none small mb-4 d-inline-block text-muted">
        <i class="bi bi-arrow-left"></i> Back to profile
    </a>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger rounded-4 border-0 shadow-sm mb-4">
            <i class="bi bi-exclamation-triangle-fill me-1"></i>
            <strong>Please fix the following:</strong>
            <ul class="mb-0 mt-2 ps-3">
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="/profile/edit" enctype="multipart/form-data">
        <div class="row g-4">

            <!-- Left: change fields -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-lg-5">
                        <h5 class="fw-bold mb-3">
                            <i class="bi bi-pencil-square text-pcu-blue me-1"></i>
                            What do you want to change?
                        </h5>
                        <p class="text-muted small mb-4">
                            Only change the fields that need updating. Leave the rest as-is.
                        </p>

                        <?php
                        $fields = [
                            'name'       => ['label' => 'Full Name',  'type' => 'text',   'icon' => 'bi-person'],
                            'email'      => ['label' => 'Email',      'type' => 'email',  'icon' => 'bi-envelope'],
                            'student_id' => ['label' => 'Student ID', 'type' => 'text',   'icon' => 'bi-hash'],
                            'section'    => ['label' => 'Section',    'type' => 'text',   'icon' => 'bi-people'],
                            'age'        => ['label' => 'Age',        'type' => 'number', 'icon' => 'bi-calendar'],
                        ];

                        foreach ($fields as $field => $meta):
                            $current = (string)($profile[$field] ?? '');
                            $input   = $old[$field] ?? $current;
                        ?>
                            <div class="mb-3">
                                <label for="<?= $field ?>" class="form-label small fw-semibold text-muted">
                                    <?= $meta['label'] ?>
                                    <span class="fw-normal">(current: <?= $current !== '' ? htmlspecialchars($current) : 'not set' ?>)</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                        <i class="bi <?= $meta['icon'] ?> text-muted"></i>
                                    </span>
                                    <input type="<?= $meta['type'] ?>"
                                           name="<?= $field ?>" id="<?= $field ?>"
                                           class="form-control border-start-0 rounded-end-3"
                                           value="<?= htmlspecialchars($input) ?>"
                                           placeholder="Leave blank to keep current">
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <!-- Gender -->
                        <div class="mb-3">
                            <label for="gender" class="form-label small fw-semibold text-muted">
                                Gender <span class="fw-normal">(current: <?= htmlspecialchars($profile['gender'] ?? 'not set') ?>)</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                    <i class="bi bi-gender-ambiguous text-muted"></i>
                                </span>
                                <select name="gender" id="gender" class="form-select border-start-0 rounded-end-3">
                                    <option value="">— Keep current —</option>
                                    <?php foreach (['Male','Female','Other'] as $g): ?>
                                        <option value="<?= $g ?>" <?= ($old['gender'] ?? '') === $g ? 'selected' : '' ?>>
                                            <?= $g ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Year level -->
                        <div class="mb-0">
                            <label for="year_level" class="form-label small fw-semibold text-muted">
                                Year Level <span class="fw-normal">(current: <?= htmlspecialchars($profile['year_level'] ?? 'not set') ?>)</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                    <i class="bi bi-mortarboard text-muted"></i>
                                </span>
                                <select name="year_level" id="year_level" class="form-select border-start-0 rounded-end-3">
                                    <option value="">— Keep current —</option>
                                    <?php foreach (['1st Year','2nd Year','3rd Year','4th Year'] as $y): ?>
                                        <option value="<?= $y ?>" <?= ($old['year_level'] ?? '') === $y ? 'selected' : '' ?>>
                                            <?= $y ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: reason + proof -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">
                            <i class="bi bi-chat-left-text text-pcu-blue me-1"></i> Reason
                        </h5>

                        <label for="reason" class="form-label small fw-semibold text-muted">
                            Why are you requesting this change?
                        </label>
                        <textarea name="reason" id="reason" rows="5"
                                  class="form-control rounded-3"
                                  placeholder="Explain your request. Be specific."
                                  required><?= htmlspecialchars($old['reason'] ?? '') ?></textarea>
                        <div class="form-text">
                            <i class="bi bi-info-circle"></i> Admin will see this when reviewing.
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">
                            <i class="bi bi-image text-pcu-blue me-1"></i> Proof
                            <span class="badge bg-secondary bg-opacity-10 text-secondary ms-1 small fw-normal">Optional</span>
                        </h5>

                        <label for="proof" class="form-label small fw-semibold text-muted">
                            Upload a supporting image
                        </label>
                        <input type="file" name="proof" id="proof"
                               accept="image/jpeg,image/png,image/webp"
                               class="form-control rounded-3"
                               onchange="previewProof(event)">
                        <div class="form-text mb-3">
                            <i class="bi bi-info-circle"></i> JPG, PNG, WebP · max 3 MB. E.g. ID card, enrollment form.
                        </div>

                        <div id="proofWrap" style="display:none;">
                            <img id="proofPreview" src="" alt=""
                                 class="rounded-4"
                                 style="width: 100%; height: 200px; object-fit: cover;">
                        </div>
                    </div>
                </div>

                <div class="alert rounded-4 small"
                     style="background: rgba(251,191,36,.1); border: 1px solid rgba(251,191,36,.35);">
                    <i class="bi bi-info-circle me-1"></i>
                    Your request will be reviewed by an admin. You'll see the result in your profile.
                </div>

                <div class="d-flex gap-2">
                    <a href="/profile" class="btn btn-outline-secondary rounded-3 flex-grow-1">Cancel</a>
                    <button class="btn btn-primary rounded-3 flex-grow-1">
                        <i class="bi bi-send"></i> Submit Request
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
function previewProof(e) {
    const file = e.target.files[0];
    const wrap = document.getElementById('proofWrap');
    const img  = document.getElementById('proofPreview');

    if (!file) { wrap.style.display = 'none'; return; }

    img.src = URL.createObjectURL(file);
    wrap.style.display = 'block';
}
</script>

<?php require BASE_PATH . '/app/Views/student/layouts/footer.php'; ?>