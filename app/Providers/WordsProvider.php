<?php

namespace App\Providers;

use App\Sources\Interfaces\WordsSource;
use App\Sources\MySQL\WordsMySQL;
use Illuminate\Support\ServiceProvider;

class WordsProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->singleton(WordsSource::class, WordsMySQL::class);
    }

    public function register(): array
    {
        return [
            WordsSource::class
        ];
    }
}
