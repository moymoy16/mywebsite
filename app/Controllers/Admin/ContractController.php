<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Middleware;
use App\Models\Contract;

class ContractController extends Controller
{
    public function index(): void
    {
        Middleware::admin();

        $this->view('admin/contracts/index', [
            'title'     => 'Contracts',
            'contracts' => (new Contract())->allWithRelations(),
        ]);
    }

    public function show(string $id): void
    {
        Middleware::admin();

        $contract = (new Contract())->findFull((int)$id);
        if (!$contract) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }

        $this->view('admin/contracts/show', [
            'title'    => 'Contract ' . $contract['contract_no'],
            'contract' => $contract,
        ]);
    }

    public function print(string $id): void
    {
        Middleware::admin();

        $contract = (new Contract())->findFull((int)$id);
        if (!$contract) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }

        $this->view('admin/contracts/print', [
            'title'    => 'Print Contract',
            'contract' => $contract,
        ]);
    }

    public function sign(string $id): void
    {
        Middleware::admin();

        (new Contract())->markSigned((int)$id);
        redirect('/admin/contracts/' . $id);
    }
}