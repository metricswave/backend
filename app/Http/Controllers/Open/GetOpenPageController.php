<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class GetOpenPageController extends Controller
{
    use HasOpenData;

    public function __invoke(): View|Factory
    {
        return view('open.open', $this->getOpenData());
    }
}
