<?php

namespace App\Sources\Interfaces;

interface UrlTrackingSource
{
    public function store(array $urlData): void;
}
