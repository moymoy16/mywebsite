<?php
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\Admin\ItemController;
use App\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Controllers\Student\ItemController as StudentItemController;
use App\Controllers\Student\BorrowController as StudentBorrowController;
use App\Controllers\Admin\BorrowController  as AdminBorrowController;
use App\Controllers\Admin\ContractController;

/** @var App\Core\Router $router */

// Public
$router->get('/',         [HomeController::class, 'index']);
$router->get('/about',    [HomeController::class, 'about']);

// Auth
$router->get('/login',    [AuthController::class, 'showLogin']);
$router->post('/login',   [AuthController::class, 'login']);
$router->get('/signup',   [AuthController::class, 'showSignup']);
$router->post('/signup',  [AuthController::class, 'signup']);
$router->get('/logout',   [AuthController::class, 'logout']);

// Protected
$router->get('/dashboard', [DashboardController::class, 'index']);

// Existing
$router->get('/users',      [UserController::class, 'index']);
$router->get('/users/{id}', [UserController::class, 'show']);

$router->get('/admin/dashboard', [AdminDashboardController::class, 'index']);
$router->get('/admin/items',            [ItemController::class, 'index']);
$router->get('/admin/items/create',     [ItemController::class, 'create']);
$router->post('/admin/items',           [ItemController::class, 'store']);
$router->get('/admin/items/{id}/edit',  [ItemController::class, 'edit']);
$router->post('/admin/items/{id}',      [ItemController::class, 'update']);
$router->post('/admin/items/{id}/archive', [ItemController::class, 'archive']);
// ═══ ADDED: admin borrow management ═══
$router->get('/admin/borrowings',              [AdminBorrowController::class, 'index']);
$router->get('/admin/borrowings/{id}',         [AdminBorrowController::class, 'show']);
$router->post('/admin/borrowings/{id}/approve',[AdminBorrowController::class, 'approve']);
$router->post('/admin/borrowings/{id}/reject', [AdminBorrowController::class, 'reject']);
$router->post('/admin/borrowings/{id}/return', [AdminBorrowController::class, 'markReturned']);
// ═══ ADDED: contracts ═══
$router->get('/admin/contracts',              [ContractController::class, 'index']);
$router->get('/admin/contracts/{id}',         [ContractController::class, 'show']);
$router->get('/admin/contracts/{id}/print',   [ContractController::class, 'print']);
$router->post('/admin/contracts/{id}/sign',   [ContractController::class, 'sign']);


// Student item browsing
$router->get('/items',      [StudentItemController::class, 'index']);
$router->get('/items/{id}', [StudentItemController::class, 'show']);
$router->get('/items/{id}/borrow',  [StudentBorrowController::class, 'create']);
$router->post('/items/{id}/borrow', [StudentBorrowController::class, 'store']);
$router->get('/my-borrowings',      [StudentBorrowController::class, 'myBorrowings']);





