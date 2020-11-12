<?php

namespace App\Http\Controllers;

use App\Sources\Interfaces\WordsSource;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Words extends BaseController
{
    protected $src;

    public function __construct(WordsSource $wordsSource)
    {
        $this->src = $wordsSource;
    }
    public function index(): JsonResponse
    {
        return response()->json(['payload' => $this->src->index()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'text' => 'string|max:140',
            'private' => 'in:0,1'
        ]);

        $this->src->store(
            $request->post('url'),
            $request->post('text'),
            $request->post('private', 0)
        );

        return redirect()->back();
    }
}
