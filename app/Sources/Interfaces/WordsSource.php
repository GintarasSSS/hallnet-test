<?php

namespace App\Sources\Interfaces;

interface WordsSource
{
    public function index(): array;
    public function store(string $url, string $description, int $isPrivate): void;
}
