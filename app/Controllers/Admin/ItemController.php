<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Middleware;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(): void
    {
        Middleware::admin();
        $items = (new Item())->allActive();
        $this->view('admin/items/index', [
            'title' => 'Inventory',
            'items' => $items,
        ]);
    }

    public function create(): void
    {
        Middleware::admin();
        $this->view('admin/items/create', ['title' => 'Add Item']);
    }

    public function store(): void
    {
        Middleware::admin();

        $name     = trim($_POST['name'] ?? '');
        $category = trim($_POST['category'] ?? '');
        $desc     = trim($_POST['description'] ?? '');
        $stock    = (int)($_POST['total_stock'] ?? 0);
        $errors   = [];

        if ($name === '')      $errors[] = 'Name is required.';
        if ($category === '')  $errors[] = 'Category is required.';
        if ($stock < 1)        $errors[] = 'Stock must be at least 1.';

        // ═══ ADDED: handle image upload ═══
        $imageName = null;
        try {
            $imageName = upload_item_image($_FILES['image'] ?? []);
        } catch (\RuntimeException $e) {
            $errors[] = $e->getMessage();
        }
        // ═══ END ADDED ═══

        if ($errors) {
            $this->view('admin/items/create', [
                'title'  => 'Add Item',
                'errors' => $errors,
                'old'    => compact('name', 'category', 'desc', 'stock'),
            ]);
            return;
        }

        (new Item())->createItem([
            'name'        => $name,
            'category'    => $category,
            'description' => $desc,
            'image'       => $imageName,   // ═══ ADDED ═══
            'total_stock' => $stock,
            'created_by'  => $_SESSION['user_id'],
        ]);

        redirect('/admin/items');
    }

    public function edit(string $id): void
    {
        Middleware::admin();
        $item = (new Item())->find((int)$id);
        if (!$item) { http_response_code(404); $this->view('errors/404'); return; }
        $this->view('admin/items/edit', ['title' => 'Edit Item', 'item' => $item]);
    }

    public function update(string $id): void
    {
        Middleware::admin();

        $item = (new Item())->find((int)$id);
        if (!$item) {
            redirect('/admin/items');
        }

        $name     = trim((string)($_POST['name'] ?? ''));
        $category = trim((string)($_POST['category'] ?? ''));
        $desc     = trim((string)($_POST['description'] ?? ''));
        $stock    = (int)($_POST['total_stock'] ?? 0);
        $errors   = [];

        if ($name === '')     $errors[] = 'Name is required.';
        if ($category === '') $errors[] = 'Category is required.';
        if ($stock < 1)       $errors[] = 'Stock must be at least 1.';

        // Optional image replacement
        $newImageName = null;
        try {
            $newImageName = upload_item_image($_FILES['image'] ?? []);
        } catch (\RuntimeException $e) {
            $errors[] = $e->getMessage();
        }

        if ($errors) {
            $this->view('admin/items/edit', [
                'title'  => 'Edit Item',
                'errors' => $errors,
                'item'   => array_merge($item, [
                    'name'        => $name,
                    'category'    => $category,
                    'description' => $desc,
                    'total_stock' => $stock,
                ]),
            ]);
            return;
        }

        // Only delete the old image AFTER validation passes
        if ($newImageName !== null) {
            delete_item_image($item['image']);
        }

        $payload = [
            'name'        => $name,
            'category'    => $category,
            'description' => $desc,
            'total_stock' => $stock,
        ];

        if ($newImageName !== null) {
            $payload['image'] = $newImageName;
        }

        (new Item())->updateItem((int)$id, $payload);
        redirect('/admin/items');
    }

    public function archive(string $id): void
    {
        Middleware::admin();
        (new Item())->archive((int)$id);
        redirect('/admin/items');
    }
}