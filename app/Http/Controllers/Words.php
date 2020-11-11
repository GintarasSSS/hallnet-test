<?php

namespace App\Http\Controllers;

use App\Sources\Interfaces\WordsSource;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

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

    public function show(): JsonResponse
    {

    }

    public function store(): JsonResponse
    {

    }
}
