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
use App\Controllers\Admin\UserController as AdminUserController;
use App\Controllers\Student\ProfileController as StudentProfileController;

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

// ═══ ADDED: forgot password ═══
$router->get('/forgot-password',  [AuthController::class, 'showForgot']);
$router->post('/forgot-password', [AuthController::class, 'sendReset']);

// ═══ ADDED: force password change ═══
$router->get('/change-password',  [AuthController::class, 'showChangePassword']);
$router->post('/change-password', [AuthController::class, 'changePassword']);

// ═══ ADDED: student profile ═══
$router->get('/profile',      [StudentProfileController::class, 'show']);
$router->get('/profile/edit', [StudentProfileController::class, 'edit']);
$router->post('/profile/edit',[StudentProfileController::class, 'submit']);



// ═══ UNIFIED USER MANAGEMENT ═══
$router->get('/admin/users',                                  [AdminUserController::class, 'index']);

// Password requests
$router->get('/admin/users/reset/{id}',                       [AdminUserController::class, 'resetPassword']);
$router->post('/admin/users/reset/{id}',                      [AdminUserController::class, 'performReset']);
$router->post('/admin/users/cancel/{id}',                     [AdminUserController::class, 'cancelRequest']);

// Direct reset (no request needed)
$router->get('/admin/users/reset-direct/{id}',                [AdminUserController::class, 'resetDirect']);
$router->post('/admin/users/reset-direct/{id}',               [AdminUserController::class, 'performDirectReset']);

// Profile edit
$router->get('/admin/users/profile/{id}/edit',                [AdminUserController::class, 'editProfile']);
$router->post('/admin/users/profile/{id}',                    [AdminUserController::class, 'updateProfile']);

// Profile change requests
$router->post('/admin/users/profile-requests/{group}/approve',[AdminUserController::class, 'approveProfileRequest']);
$router->post('/admin/users/profile-requests/{group}/reject', [AdminUserController::class, 'rejectProfileRequest']);

// ═══ ADDED: multi-item cart ═══
$router->post('/items/{id}/cart',       [StudentBorrowController::class, 'addToCart']);
$router->get('/borrow/cart',            [StudentBorrowController::class, 'cart']);
$router->post('/borrow/cart/remove/{i}',[StudentBorrowController::class, 'removeFromCart']);
$router->get('/borrow/multi',           [StudentBorrowController::class, 'create']);
$router->post('/borrow/multi',          [StudentBorrowController::class, 'store']);