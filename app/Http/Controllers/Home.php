<?php

namespace App\Http\Controllers;

use App\Sources\Interfaces\HistorySource;
use Illuminate\Routing\Controller as BaseController;

class Home extends BaseController
{
    protected $src;

    public function __construct(HistorySource $historySource)
    {
        $this->src = $historySource;
    }

    public function index(): string
    {
        return view(
            'pages.home',
            $this->src->index()
        );
    }
}
