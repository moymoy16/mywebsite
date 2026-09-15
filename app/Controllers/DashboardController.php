<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Middleware;
use App\Models\Borrowing;

class DashboardController extends Controller
{
    public function index(): void
    {
        Middleware::student();

        $studentId = (int)$_SESSION['user_id'];
        $model     = new Borrowing();

        $this->view('dashboard/index', [
            'title'    => 'Dashboard',
            'name'     => $_SESSION['user_name'] ?? 'Student',
            'summary'  => $model->studentSummary($studentId),
            'active'   => $model->activeForStudent($studentId),
            'upcoming' => $model->upcomingDueForStudent($studentId, 7),
            'recent'   => $model->recentForStudent($studentId, 5),
        ]);
    }
}