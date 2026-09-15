<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index(): void
    {
        $users = (new User())->all();
        $this->view('user/index', ['users' => $users, 'title' => 'All Users']);
    }

    public function show(string $id): void
    {
        $user = (new User())->find((int)$id);
        if (!$user) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }
        $this->view('user/show', ['user' => $user, 'title' => $user['name']]);
    }

    public function apiIndex(): void {
        $this->json((new User())->all());
    }
}