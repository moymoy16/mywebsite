<?php
namespace App\Controllers\Student;

use App\Core\Controller;
use App\Core\Middleware;
use App\Models\Borrowing;
use App\Models\Item;

class BorrowController extends Controller
{
    public function create(string $itemId): void
    {

        Middleware::student();

        if ((new \App\Models\Borrowing())->overdueCountForStudent((int)$_SESSION['user_id']) > 0) {
            redirect('/my-borrowings');
        }

        $item = (new Item())->findActive((int)$itemId);
        if (!$item || (int)$item['available_stock'] < 1) {
            redirect('/items');
        }

        $this->view('student/borrow/create', [
            'title' => 'Borrow ' . $item['name'],
            'item'  => $item,
        ]);
    }

    public function store(string $itemId): void
    {
        
        Middleware::student();

        if ((new \App\Models\Borrowing())->overdueCountForStudent((int)$_SESSION['user_id']) > 0) {
            redirect('/my-borrowings');
        }

        $item     = (new Item())->findActive((int)$itemId);
        if (!$item) { redirect('/items'); }

        $quantity    = (int)($_POST['quantity'] ?? 1);
        $borrowDate  = $_POST['borrow_date'] ?? '';
        $dueDate     = $_POST['due_date'] ?? '';
        $errors      = [];

        if ($quantity < 1) {
            $errors[] = 'Quantity must be at least 1.';
        }
        if ($quantity > (int)$item['available_stock']) {
            $errors[] = 'Only ' . (int)$item['available_stock'] . ' unit(s) available.';
        }
        if (!$borrowDate || !strtotime($borrowDate)) {
            $errors[] = 'Please pick a borrow date.';
        }
        if (!$dueDate || !strtotime($dueDate)) {
            $errors[] = 'Please pick a due date.';
        }
        if ($borrowDate && $dueDate && strtotime($dueDate) <= strtotime($borrowDate)) {
            $errors[] = 'Due date must be after the borrow date.';
        }

        if ($errors) {
            $this->view('student/borrow/create', [
                'title'  => 'Borrow ' . $item['name'],
                'item'   => $item,
                'errors' => $errors,
                'old'    => compact('quantity', 'borrowDate', 'dueDate'),
            ]);
            return;
        }

        (new Borrowing())->create([
            'student_id'  => $_SESSION['user_id'],
            'item_id'     => (int)$item['id'],
            'quantity'    => $quantity,
            'borrow_date' => $borrowDate,
            'due_date'    => $dueDate,
        ]);

        redirect('/my-borrowings');
    }

    public function myBorrowings(): void
    {
        Middleware::student();

        $borrowings = (new Borrowing())->forStudent((int)$_SESSION['user_id']);

        $this->view('student/borrow/index', [
            'title'      => 'My Borrowings',
            'borrowings' => $borrowings,
        ]);
    }
}