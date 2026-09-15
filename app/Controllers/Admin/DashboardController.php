<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Middleware;

class DashboardController extends Controller
{
    public function index(): void
    {
        Middleware::admin();
        $this->view('admin/dashboard/index', [
            'title' => 'Admin Dashboard',
            'name'  => $_SESSION['user_name'] ?? 'Admin',
        ]);
    }
}