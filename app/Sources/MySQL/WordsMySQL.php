<?php

namespace App\Sources\MySQL;

use App\Sources\Interfaces\WordsSource;
use Illuminate\Database\DatabaseManager;

class WordsMySQL implements WordsSource
{
    protected $db;

    public function __construct(DatabaseManager $databaseManager)
    {
        $this->db = $databaseManager;
    }

    public function index(): array
    {
        return $this->db->table('eff_short_wordlist')->get()->toArray();
    }
}
