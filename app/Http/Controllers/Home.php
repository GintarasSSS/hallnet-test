<?php

namespace App\Http\Controllers;

use App\Sources\Interfaces\HistorySource;
use Carbon\Carbon;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\URL;

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
            [
                'list' => $this->src->index(),
                'currentUrl' => URL::current()
            ]
        );
    }
}
