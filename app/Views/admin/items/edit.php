<?php require BASE_PATH . '/app/Views/admin/layouts/header.php'; ?>

<?php
$currentImage = item_image_url($item['image']);
$available    = (int)$item['available_stock'];
$total        = (int)$item['total_stock'];
$borrowed     = $total - $available;
?>

<!-- ═══ HERO ═══ -->
<section style="background: linear-gradient(135deg, #0f1e5c 0%, #1e3a8a 60%, #2d4fb8 100%); color:#fff;">
    <div class="container-fluid px-4 py-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <a href="/admin/items" class="text-decoration-none small d-inline-block mb-3"
                   style="color: rgba(255,255,255,.6);">
                    <i class="bi bi-arrow-left"></i> Back to inventory
                </a>

                <div class="d-flex align-items-center gap-3">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-3"
                          style="width: 48px; height: 48px; background: rgba(251,191,36,.2); color: #fbbf24;">
                        <i class="bi bi-pencil-square fs-4"></i>
                    </span>
                    <div>
                        <h1 class="display-6 fw-bold lh-1 mb-0 text-white" style="font-size: 26px;">
                            Edit Item
                        </h1>
                        <div class="text-white-50 small">
                            Updating: <strong class="text-white"><?= htmlspecialchars($item['name']) ?></strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="/admin/items" class="btn btn-outline-light rounded-3">
                        <i class="bi bi-x-lg"></i> Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container-fluid px-4 py-5">

    <!-- ═══ STOCK SUMMARY ═══ -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-3 p-2" style="background: rgba(30,58,138,.1);">
                        <i class="bi bi-stack fs-4" style="color: var(--pcu-blue);"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total stock</div>
                        <div class="fs-5 fw-bold"><?= $total ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-3 p-2 bg-success bg-opacity-10">
                        <i class="bi bi-check-circle fs-4 text-success"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Available</div>
                        <div class="fs-5 fw-bold"><?= $available ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-3 p-2" style="background: rgba(251,191,36,.15);">
                        <i class="bi bi-book fs-4" style="color: #b45309;"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Currently borrowed</div>
                        <div class="fs-5 fw-bold"><?= $borrowed ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger rounded-4 border-0 shadow-sm mb-4">
            <div class="d-flex align-items-start gap-2">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <div>
                    <strong>Please fix the following:</strong>
                    <ul class="mb-0 mt-1 ps-3">
                        <?php foreach ($errors as $e): ?>
                            <li><?= htmlspecialchars($e) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <form method="POST" action="/admin/items/<?= (int)$item['id'] ?>" enctype="multipart/form-data">
        <div class="row g-4">

            <!-- ═══ LEFT: FORM ═══ -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-lg-5">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-info-circle text-pcu-blue me-1"></i> Item Information
                        </h5>

                        <div class="mb-3">
                            <label for="name" class="form-label small fw-semibold text-muted">Item name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                    <i class="bi bi-tag text-muted"></i>
                                </span>
                                <input type="text" name="name" id="name"
                                       class="form-control border-start-0 rounded-end-3"
                                       value="<?= htmlspecialchars($item['name']) ?>"
                                       required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label small fw-semibold text-muted">Category</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                    <i class="bi bi-collection text-muted"></i>
                                </span>
                                <input type="text" name="category" id="category"
                                       class="form-control border-start-0 rounded-end-3"
                                       value="<?= htmlspecialchars($item['category']) ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label small fw-semibold text-muted">Description</label>
                            <textarea name="description" id="description" rows="4"
                                      class="form-control rounded-3"><?= htmlspecialchars($item['description'] ?? '') ?></textarea>
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> Students will see this on the item detail page.
                            </div>
                        </div>

                        <div class="mb-0">
                            <label for="total_stock" class="form-label small fw-semibold text-muted">
                                Total stock
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                    <i class="bi bi-stack text-muted"></i>
                                </span>
                                <input type="number" name="total_stock" id="total_stock" min="1"
                                       class="form-control border-start-0 rounded-end-3"
                                       value="<?= $total ?>" required>
                            </div>
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i>
                                Available stock stays at <strong><?= $available ?></strong> until items are returned or borrowed.
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- ═══ RIGHT: IMAGE ═══ -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-image text-pcu-blue me-1"></i> Item Image
                        </h5>

                        <div class="text-center mb-3">
                            <?php if ($currentImage): ?>
                                <img id="currentImage"
                                     src="<?= htmlspecialchars($currentImage) ?>"
                                     alt="Current item image"
                                     class="rounded-4"
                                     style="width: 100%; height: 220px; object-fit: cover;">
                            <?php else: ?>
                                <div class="rounded-4 d-flex align-items-center justify-content-center"
                                     style="height: 220px; background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);">
                                    <div class="text-center text-muted">
                                        <i class="bi bi-image display-4"></i>
                                        <div class="small mt-2">No image uploaded</div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div id="previewWrap" style="display:none;">
                                <div class="small text-muted mt-3 mb-1">
                                    <i class="bi bi-eye"></i> New image preview
                                </div>
                                <img id="imagePreview" src="" alt=""
                                     class="rounded-4"
                                     style="width: 100%; height: 220px; object-fit: cover;">
                            </div>
                        </div>

                        <label class="form-label small fw-semibold text-muted">
                            Upload new image
                            <span class="fw-normal">(JPG, PNG, WebP — max 2 MB)</span>
                        </label>
                        <input type="file" name="image" accept="image/jpeg,image/png,image/webp"
                               class="form-control rounded-3"
                               onchange="previewImage(event)">
                        <div class="form-text">
                            <i class="bi bi-info-circle"></i>
                            Leave blank to keep the current image.
                        </div>
                    </div>
                </div>
            </div>

            <!-- ═══ FULL-WIDTH: SAVE BAR ═══ -->
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div class="text-muted small">
                            <i class="bi bi-info-circle"></i>
                            Changes take effect immediately.
                        </div>
                        <div class="d-flex gap-2">
                            <a href="/admin/items" class="btn btn-outline-secondary rounded-3 px-4">
                                Cancel
                            </a>
                            <button class="btn btn-primary rounded-3 px-4">
                                <i class="bi bi-check-lg"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ═══ DANGER ZONE ═══ -->
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4" style="border: 1px solid #fecaca !important;">
                    <div class="card-body p-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div>
                            <h6 class="fw-bold text-danger mb-1">
                                <i class="bi bi-exclamation-triangle"></i> Danger Zone
                            </h6>
                            <div class="text-muted small">
                                Archiving hides this item from students. Existing borrowings are not affected.
                            </div>
                        </div>
                        <form method="POST" action="/admin/items/<?= (int)$item['id'] ?>/archive"
                              onsubmit="return confirm('Archive this item? It will no longer be borrowable by students.')">
                            <button class="btn btn-outline-danger rounded-3">
                                <i class="bi bi-archive"></i> Archive Item
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </form>

</div>

<script>
function previewImage(e) {
    const file    = e.target.files[0];
    const preview = document.getElementById('imagePreview');
    const wrap    = document.getElementById('previewWrap');
    const current = document.getElementById('currentImage');

    if (!file) {
        wrap.style.display = 'none';
        if (current) current.style.display = 'block';
        return;
    }

    preview.src = URL.createObjectURL(file);
    wrap.style.display = 'block';
    if (current) current.style.display = 'none';
}
</script>

<?php require BASE_PATH . '/app/Views/admin/layouts/footer.php'; ?>