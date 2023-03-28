<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class AppController extends Controller
{
    public function __invoke(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('app');
    }
}
