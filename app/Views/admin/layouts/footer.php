</main>

<footer class="mt-5 py-4" style="background: #0f1e5c; color: rgba(255,255,255,.6);">
    <div class="container-fluid px-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 small">
            <div>
                <i class="bi bi-shield-lock-fill me-1" style="color: #fbbf24;"></i>
                &copy; <?= date('Y') ?> PCU Borrow System — Admin Panel
            </div>
            <div class="d-flex gap-3">
                <a href="/admin/items" class="text-decoration-none" style="color: rgba(255,255,255,.6);">Inventory</a>
                <a href="/admin/borrowings" class="text-decoration-none" style="color: rgba(255,255,255,.6);">Borrowings</a>
                <a href="/admin/contracts" class="text-decoration-none" style="color: rgba(255,255,255,.6);">Contracts</a>
                <a href="/admin/users" class="text-decoration-none" style="color: rgba(255,255,255,.6);">Users</a>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/app.js"></script>
</body>
</html>