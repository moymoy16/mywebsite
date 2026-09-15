<?php
/** @var string $title */
/** @var array $users */

?>
<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<h1><?= htmlspecialchars($title) ?></h1>

<table class="table table-striped">
    <thead>
        <tr><th>ID</th><th>Name</th><th></th></tr>
    </thead>
    <tbody>
        <?php foreach ($users as $u): ?>
            <tr>
                <td><?= (int)$u['id'] ?></td>
                <td><?= htmlspecialchars($u['name']) ?></td>
                <td>
                    <a href="/users/<?= (int)$u['id'] ?>" class="btn btn-sm btn-primary">View</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>