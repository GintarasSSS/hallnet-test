<?php

namespace App\Http\Controllers;

use App\Sources\Interfaces\UrlTrackingSource;
use App\Sources\Interfaces\WordsSource;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class UrlTracking extends BaseController
{
    protected $src;
    protected $wordsSrc;

    public function __construct(UrlTrackingSource $urlTrackingSource, WordsSource $wordsSource)
    {
        $this->src = $urlTrackingSource;
        $this->wordsSrc = $wordsSource;
    }

    public function store(string $shortUrl)
    {
        $validator = Validator::make(['shortUrl' => $shortUrl], [
            'shortUrl' => 'required|string|max:100'
        ]);

        if (!$validator->fails()) {
            $this->src->store(
                $this->wordsSrc->show($shortUrl)
            );
        }

        return redirect('/');
    }
}
