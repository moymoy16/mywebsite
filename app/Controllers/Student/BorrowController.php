<?php
namespace App\Controllers\Student;

use App\Core\Controller;
use App\Core\Middleware;
use App\Models\Borrowing;
use App\Models\Item;
use App\Models\User;  

class BorrowController extends Controller
{
public function create(string $itemId = ''): void
{
    Middleware::student();

    // If a specific item is passed, this is a "quick borrow" for one item
    if ($itemId !== '') {
        $item = (new Item())->findActive((int)$itemId);
        if (!$item || (int)$item['available_stock'] < 1) {
            redirect('/items');
        }

        $this->view('student/borrow/create', [
            'title' => 'Borrow ' . $item['name'],
            'items' => [[
                'id'              => $item['id'],
                'name'            => $item['name'],
                'category'        => $item['category'],
                'image'           => $item['image'],
                'available_stock' => $item['available_stock'],
                'quantity'        => 1,
            ]],
        ]);
        return;
    }

    // Multi-item flow — read the cart from session
    $cart = $_SESSION['borrow_cart'] ?? [];
    if (empty($cart)) {
        redirect('/items');
    }

    // Fetch full item details for each cart entry
    $itemModel = new Item();
    $items = [];
    foreach ($cart as $entry) {
        $item = $itemModel->findActive((int)$entry['id']);
        if (!$item) continue;
        $items[] = [
            'id'              => $item['id'],
            'name'            => $item['name'],
            'category'        => $item['category'],
            'image'           => $item['image'],
            'available_stock' => $item['available_stock'],
            'quantity'        => (int)$entry['quantity'],
        ];
    }

    if (empty($items)) {
        redirect('/items');
    }

    $this->view('student/borrow/create', [
        'title' => 'Borrow Request',
        'items' => $items,
    ]);
}

public function store(string $itemId = ''): void
{
    Middleware::student();

    $userModel = new User();
    $profile   = $userModel->find((int)$_SESSION['user_id']);

    if ((new \App\Models\Borrowing())->overdueCountForStudent((int)$_SESSION['user_id']) > 0) {
        redirect('/my-borrowings');
    }

    $borrowDate = $_POST['borrow_date'] ?? '';
    $dueDate    = $_POST['due_date'] ?? '';
    $errors     = [];

    if (!$borrowDate || !strtotime($borrowDate)) $errors[] = 'Please pick a borrow date.';
    if (!$dueDate    || !strtotime($dueDate))    $errors[] = 'Please pick a due date.';
    if ($borrowDate && $dueDate && strtotime($dueDate) <= strtotime($borrowDate)) {
        $errors[] = 'Due date must be after the borrow date.';
    }

    // Collect items
    $itemModel = new Item();
    $items     = [];

    if ($itemId !== '') {
        // Single-item flow
        $item     = $itemModel->findActive((int)$itemId);
        $quantity = (int)($_POST['quantity'] ?? 1);

        if (!$item) {
            $errors[] = 'Item not found.';
        } else {
            if ($quantity < 1) $errors[] = 'Quantity must be at least 1.';
            if ($quantity > (int)$item['available_stock']) {
                $errors[] = 'Only ' . (int)$item['available_stock'] . ' unit(s) available.';
            }
            $items[] = [
                'id'              => $item['id'],
                'name'            => $item['name'],
                'category'        => $item['category'],
                'image'           => $item['image'],
                'available_stock' => $item['available_stock'],
                'quantity'        => $quantity,
            ];
        }
    } else {
        // Multi-item flow
        $cart = $_SESSION['borrow_cart'] ?? [];
        foreach ($cart as $entry) {
            $item = $itemModel->findActive((int)$entry['id']);
            if (!$item) continue;
            $qty = (int)$entry['quantity'];
            if ($qty < 1) $qty = 1;
            if ($qty > (int)$item['available_stock']) {
                $errors[] = $item['name'] . ': only ' . (int)$item['available_stock'] . ' available.';
            }
            $items[] = [
                'id'              => $item['id'],
                'name'            => $item['name'],
                'category'        => $item['category'],
                'image'           => $item['image'],
                'available_stock' => $item['available_stock'],
                'quantity'        => $qty,
            ];
        }

        if (empty($items)) {
            $errors[] = 'Your cart is empty.';
        }
    }

    if ($errors) {
        $this->view('student/borrow/create', [
            'title'  => 'Borrow Request',
            'items'  => $items,
            'errors' => $errors,
            'old'    => [
                'borrowDate' => $borrowDate,
                'dueDate'    => $dueDate,
            ],
        ]);
        return;
    }

    // Save
    (new \App\Models\Borrowing())->createWithItems(
        (int)$_SESSION['user_id'],
        $items,
        $borrowDate,
        $dueDate
    );

    unset($_SESSION['borrow_cart']);
    $_SESSION['flash'] = 'Your borrow request has been submitted.';
    redirect('/my-borrowings');
}

public function myBorrowings(): void
{
    Middleware::student();

    $borrowings = (new \App\Models\Borrowing())->forStudent((int)$_SESSION['user_id']);

    $this->view('student/borrow/index', [
        'title'      => 'My Borrowings',
        'borrowings' => $borrowings,
    ]);
}

public function addToCart(string $itemId): void
{
    Middleware::student();

    $quantity = max(1, (int)($_POST['quantity'] ?? 1));
    $cart     = $_SESSION['borrow_cart'] ?? [];

    // Check if item already in cart
    foreach ($cart as $i => $entry) {
        if ((int)$entry['id'] === (int)$itemId) {
            $cart[$i]['quantity'] += $quantity;
            $_SESSION['borrow_cart'] = $cart;
            redirect('/items');
        }
    }

    $cart[] = ['id' => (int)$itemId, 'quantity' => $quantity];
    $_SESSION['borrow_cart'] = $cart;

    $_SESSION['flash'] = 'Item added to your borrow list.';
    redirect('/items');
}

public function removeFromCart(string $index): void
{
    Middleware::student();

    $cart = $_SESSION['borrow_cart'] ?? [];
    if (isset($cart[(int)$index])) {
        unset($cart[(int)$index]);
        $_SESSION['borrow_cart'] = array_values($cart);
    }
    redirect('/borrow/cart');
}

public function cart(): void
{
    Middleware::student();

    $cart = $_SESSION['borrow_cart'] ?? [];

    $itemModel = new Item();
    $items = [];
    foreach ($cart as $entry) {
        $item = $itemModel->findActive((int)$entry['id']);
        if (!$item) continue;
        $items[] = [
            'id'              => $item['id'],
            'name'            => $item['name'],
            'category'        => $item['category'],
            'image'           => $item['image'],
            'available_stock' => $item['available_stock'],
            'quantity'        => (int)$entry['quantity'],
        ];
    }

    $this->view('student/borrow/cart', [
        'title' => 'Borrow Cart',
        'items' => $items,
    ]);
}
}