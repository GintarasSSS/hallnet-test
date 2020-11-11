<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class EffShortWordlist extends Seeder
{
    const EFF_SHORT_WORDLIST_URL = 'https://www.eff.org/files/2016/09/08/eff_short_wordlist_2_0.txt';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('eff_short_wordlist')->insert($this->insertGenerate());
    }

    private function insertGenerate(): array
    {
        $result = [];

        $content = Http::get(self::EFF_SHORT_WORDLIST_URL)->body();
        $lines = explode("\n", $content);

        foreach ($lines as $line) {
            $values = explode("\t", $line);

            if (count($values) == 2) {
                $result[] = [
                    '__pk' => (int)$values[0],
                    'short_word' => $values[1]
                ];
            }
        }

        return $result;
    }
}
