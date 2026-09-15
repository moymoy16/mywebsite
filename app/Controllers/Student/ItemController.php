<?php
namespace App\Controllers\Student;

use App\Core\Controller;
use App\Core\Middleware;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(): void
    {
        Middleware::student();

        $search   = trim($_GET['search'] ?? '');
        $category = trim($_GET['category'] ?? '');

        $itemModel  = new Item();
        $items      = $itemModel->filterActive($search ?: null, $category ?: null);
        $categories = $itemModel->allCategories();

        $this->view('student/items/index', [
            'title'      => 'Browse Items',
            'items'      => $items,
            'categories' => $categories,
            'search'     => $search,
            'category'   => $category,
        ]);
    }

    public function show(string $id): void
    {
        Middleware::student();

        $item = (new Item())->findActive((int)$id);
        if (!$item) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }

        $this->view('student/items/show', [
            'title' => $item['name'],
            'item'  => $item,
        ]);
    }
}