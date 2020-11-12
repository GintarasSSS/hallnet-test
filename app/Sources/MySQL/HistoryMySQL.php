<?php

namespace App\Sources\MySQL;

use App\Sources\Interfaces\HistorySource;
use Illuminate\Database\DatabaseManager;

class HistoryMySQL implements HistorySource
{
    const RESULTS_LIMIT = 10;

    protected $db;

    public function __construct(DatabaseManager $databaseManager)
    {
        $this->db = $databaseManager;
    }

    public function index(): array
    {
        return $this->db
            ->table('urls_mapping AS um')
            ->select([
                'um.url',
                'um.description',
                'um.private',
                'um.created',
                'esw.visited',
                'esw.short_word'
            ])
            ->join('eff_short_wordlist AS esw', 'esw.__pk', '=', 'um._fk_pk_eff_short_wordlist')
            ->orderBy('um.created', 'desc')
            ->limit(self::RESULTS_LIMIT)
            ->get()
            ->toArray();
    }
}
