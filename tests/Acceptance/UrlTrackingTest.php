<?php

namespace Tests\Acceptance;

use App\Sources\MySQL\UrlTrackingMySQL;
use App\Sources\MySQL\WordsMySQL;
use Illuminate\Database\DatabaseManager;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UrlTrackingTest extends TestCase
{
    /**
     * @dataProvider storePageData
     */
    public function testStorePage($urlShort, $shortWordResult)
    {
        $db = $this->mock(DatabaseManager::class);

        $db->shouldReceive('table')
            ->once()
            ->with(WordsMySQL::WORD_LIST_TABLE)
            ->andReturnSelf()
            ->shouldReceive('where')
            ->once()
            ->with('short_word', $urlShort)
            ->andReturnSelf()
            ->shouldReceive('get')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('toArray')
            ->once()
            ->andReturn($shortWordResult);

        $db->shouldReceive('table')
            ->times(count($shortWordResult))
            ->with(UrlTrackingMySQL::WORD_LIST_TABLE)
            ->andReturnSelf()
            ->shouldReceive('where')
            ->times(count($shortWordResult))
            ->with('__pk', '=', current($shortWordResult)->__pk ?? '')
            ->andReturnSelf()
            ->shouldReceive('update')
            ->times(count($shortWordResult))
            ->with([
                'visited' => (current($shortWordResult)->visited ?? 0) + 1
            ]);

        $response = $this->get('/' . $urlShort);

        $response->assertStatus(Response::HTTP_FOUND);
    }

    public function storePageData(): array
    {
        return [
            'call url tracking with existent url' => [
                'urlShort' => 'existent',
                'shortWordResult' => [
                    (object) [
                        '__pk' => 9999,
                        'visited' => 123
                    ]
                ]
            ],
            'call url tracking with non existent url' => [
                'urlShort' => 'notExistent',
                'shortWordResult' => []
            ]
        ];
    }
}
