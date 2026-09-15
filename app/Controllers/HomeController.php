<?php
namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index(): void
    {
        $this->view('home/index', ['title' => 'Home']);
    }

    public function about(): void
    {
        $this->view('home/about', ['title' => 'About']);
    }
}