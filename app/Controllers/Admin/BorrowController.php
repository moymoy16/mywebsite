<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Middleware;
use App\Models\Borrowing;
use App\Models\Contract;
use App\Models\Item;

class BorrowController extends Controller
{
    public function index(): void
    {
        Middleware::admin();

        $status = trim($_GET['status'] ?? '');
        $rows   = (new Borrowing())->allWithRelations($status ?: null);

        $this->view('admin/borrowings/index', [
            'title'  => 'Borrow Requests',
            'rows'   => $rows,
            'status' => $status,
        ]);
    }

    public function show(string $id): void
    {
        Middleware::admin();

        $borrowing = (new Borrowing())->findWithRelations((int)$id);
        if (!$borrowing) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }

        $contract = (new Contract())->findByBorrowing((int)$id);

        $this->view('admin/borrowings/show', [
            'title'     => 'Borrowing #' . $borrowing['id'],
            'borrowing' => $borrowing,
            'contract'  => $contract,
        ]);
    }


    public function reject(string $id): void
    {
        Middleware::admin();

        (new Borrowing())->setStatus((int)$id, 'rejected', (int)$_SESSION['user_id']);
        redirect('/admin/borrowings/' . $id);
    }

    public function approve(string $id): void
    {
        Middleware::admin();

        $borrowingModel = new Borrowing();
        $borrowing = $borrowingModel->findWithRelations((int)$id);

        if (!$borrowing || $borrowing['status'] !== 'pending') {
            redirect('/admin/borrowings');
        }

        // Atomic multi-item stock decrement
        $ok = $borrowingModel->decrementStockForBorrowing((int)$id);

        if (!$ok) {
            $_SESSION['flash'] = 'Could not approve: some items are out of stock.';
            redirect('/admin/borrowings/' . $id);
        }

        $borrowingModel->setStatus((int)$id, 'approved', (int)$_SESSION['user_id']);
        (new Contract())->createForBorrowing((int)$id);

        $_SESSION['flash'] = 'Borrowing approved and contract generated.';
        redirect('/admin/borrowings/' . $id);
    }

    public function markReturned(string $id): void
    {
        Middleware::admin();

        $borrowingModel = new Borrowing();
        $borrowing = $borrowingModel->findWithRelations((int)$id);

        if (!$borrowing || !in_array($borrowing['status'], ['approved', 'overdue'], true)) {
            redirect('/admin/borrowings/' . $id);
        }

        $borrowingModel->incrementStockForBorrowing((int)$id);
        $borrowingModel->markReturned((int)$id);

        $_SESSION['flash'] = 'Item(s) returned. Stock restored.';
        redirect('/admin/borrowings/' . $id);
    }
}