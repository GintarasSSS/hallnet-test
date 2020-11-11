<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class Home extends BaseController
{
    public function index(): string
    {
        return view('layouts.default');
    }
}
