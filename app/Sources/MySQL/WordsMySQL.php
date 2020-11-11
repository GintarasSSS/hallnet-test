<?php

namespace App\Sources\MySQL;

use App\Sources\Interfaces\WordsSource;
use Carbon\Carbon;
use Illuminate\Database\DatabaseManager;

class WordsMySQL implements WordsSource
{
    protected $db;
    protected $carbon;

    public function __construct(DatabaseManager $databaseManager, Carbon $carbon)
    {
        $this->db = $databaseManager;
        $this->carbon = $carbon;
    }

    public function index(): array
    {
        return $this->db->table('eff_short_wordlist')->get()->toArray();
    }

    public function store(string $url, string $description, int $isPrivate): void
    {
        $result = $this->db->table('eff_short_wordlist')->where('used', 0)->first();

        if (!$result) {
            return;
        }

        $success = $this->db->table('urls_mapping')->insert([
            '_fk_pk_eff_short_wordlist' => $result->__pk,
            'url' => $url,
            'description' => $description,
            'private' => $isPrivate,
            'created' => $this->carbon->format('Y-m-d H:i:s')
        ]);

        if ($success) {
            $this->db->table('eff_short_wordlist')->where('__pk', '=', $result->__pk)->update(['used' => 1]);
        }
    }
}
