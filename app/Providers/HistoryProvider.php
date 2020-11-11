<?php

namespace App\Providers;

use App\Sources\Interfaces\HistorySource;
use App\Sources\MySQL\HistoryMySQL;
use Illuminate\Support\ServiceProvider;

class HistoryProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->singleton(HistorySource::class, HistoryMySQL::class);
    }

    public function register(): array
    {
        return [
            HistorySource::class
        ];
    }
}
