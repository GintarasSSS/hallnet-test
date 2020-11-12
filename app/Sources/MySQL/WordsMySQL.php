<?php

namespace App\Sources\MySQL;

use App\Sources\Interfaces\WordsSource;
use Carbon\Carbon;
use Illuminate\Database\DatabaseManager;

class WordsMySQL implements WordsSource
{
    const WORD_LIST_TABLE = 'eff_short_wordlist';
    const URL_MAPPING_TABLE = 'urls_mapping';

    protected $db;
    protected $carbon;

    public function __construct(DatabaseManager $databaseManager, Carbon $carbon)
    {
        $this->db = $databaseManager;
        $this->carbon = $carbon;
    }

    public function index(): array
    {
        return $this->db->table(self::WORD_LIST_TABLE)->get()->toArray();
    }

    public function store(string $url, string $description, int $isPrivate): void
    {
        $result = $this->db->table(self::WORD_LIST_TABLE)->where('used', 0)->first();

        if (!$result) {
            return;
        }

        $success = $this->db->table(self::URL_MAPPING_TABLE)->insert([
            '_fk_pk_eff_short_wordlist' => $result->__pk,
            'url' => $url,
            'description' => $description,
            'private' => $isPrivate,
            'created' => $this->carbon->format('Y-m-d H:i:s')
        ]);

        if ($success) {
            $this->db->table(self::WORD_LIST_TABLE)->where('__pk', '=', $result->__pk)->update(['used' => 1]);
        }
    }

    public function show(string $url): array
    {
        return $this->db->table(self::WORD_LIST_TABLE)->where('short_word', $url)->get()->toArray();
    }
}
