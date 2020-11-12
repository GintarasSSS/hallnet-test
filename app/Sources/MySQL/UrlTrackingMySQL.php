<?php

namespace App\Sources\MySQL;

use App\Sources\Interfaces\UrlTrackingSource;
use Illuminate\Database\DatabaseManager;

class UrlTrackingMySQL implements UrlTrackingSource
{
    protected $db;

    public function __construct(DatabaseManager $databaseManager)
    {
        $this->db = $databaseManager;
    }

    public function store(array $urlData): void
    {
        if (!$urlData) {
            return;
        }

        $urlData = current($urlData);

        $this->db
            ->table('eff_short_wordlist')
            ->where('__pk', '=', $urlData->__pk)
            ->update(
                [
                    'visited' => $urlData->visited + 1
                ]
            );
    }
}
