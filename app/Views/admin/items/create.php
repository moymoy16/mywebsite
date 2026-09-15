<?php require BASE_PATH . '/app/Views/admin/layouts/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-5">
                <h3 class="fw-bold mb-4">Add Item to Inventory</h3>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger rounded-3">
                        <?php foreach ($errors as $e): ?>
                            <div><?= htmlspecialchars($e) ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/admin/items" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Item name</label>
                        <input type="text" name="name" class="form-control rounded-3"
                               value="<?= htmlspecialchars($old['name'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <input type="text" name="category" class="form-control rounded-3"
                               placeholder="e.g. Electronics, Sports, Lab"
                               value="<?= htmlspecialchars($old['category'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="3" class="form-control rounded-3"><?= htmlspecialchars($old['desc'] ?? '') ?></textarea>
                    </div>

                    <!-- ═══ ADDED: image upload ═══ -->
                    <div class="mb-3">
                        <label class="form-label">Item image <span class="text-muted small">(JPG, PNG, WebP — max 2 MB)</span></label>
                        <input type="file" name="image" accept="image/jpeg,image/png,image/webp"
                            class="form-control rounded-3" onchange="previewImage(event)">
                        <div class="mt-2">
                            <img id="imagePreview" src="" alt="" style="display:none; max-height: 180px; border-radius: .5rem;">
                        </div>
                    </div>
                    <script>
                    function previewImage(e) {
                        const file = e.target.files[0];
                        const img  = document.getElementById('imagePreview');
                        if (!file) { img.style.display = 'none'; return; }
                        img.src = URL.createObjectURL(file);
                        img.style.display = 'block';
                    }
                    </script>
                    <!-- ═══ END ADDED ═══ -->

                    <div class="mb-4">
                        <label class="form-label">Total stock</label>
                        <input type="number" name="total_stock" min="1" class="form-control rounded-3"
                               value="<?= htmlspecialchars($old['stock'] ?? 1) ?>" required>
                    </div>

                    <div class="d-flex gap-2">
                        <button class="btn btn-primary rounded-3 px-4">Save Item</button>
                        <a href="/admin/items" class="btn btn-outline-secondary rounded-3">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require BASE_PATH . '/app/Views/admin/layouts/footer.php'; ?>