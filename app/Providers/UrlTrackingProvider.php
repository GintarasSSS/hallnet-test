<?php

namespace App\Providers;

use App\Sources\Interfaces\UrlTrackingSource;
use App\Sources\MySQL\UrlTrackingMySQL;
use Illuminate\Support\ServiceProvider;

class UrlTrackingProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->singleton(UrlTrackingSource::class, UrlTrackingMySQL::class);
    }

    public function register(): array
    {
        return [
            UrlTrackingMySQL::class
        ];
    }
}
