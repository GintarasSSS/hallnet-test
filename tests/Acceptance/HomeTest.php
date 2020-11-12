<?php

namespace Tests\Acceptance;

use App\Sources\MySQL\HistoryMySQL;
use Carbon\Carbon;
use Illuminate\Database\DatabaseManager;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class HomeTest extends TestCase
{
    const MOCKED_DATE = '2 hours ago';

    public function testHomePage()
    {
        $parameters = [
            'um.url',
            'um.description',
            'um.private',
            'um.created',
            'esw.visited',
            'esw.short_word'
        ];

        $data = [
            (object) [
                'url' => 'https://testUrl.co.uk',
                'description' => 'test description test description',
                'private' => '1',
                'created' => self::MOCKED_DATE,
                'visited' => '9999',
                'short_word' => 'testShortWord'
            ]
        ];

        $this->mock(Carbon::class)
            ->shouldReceive('parse')
            ->with(self::MOCKED_DATE)
            ->andReturnSelf()
            ->shouldReceive('diffForHumans')
            ->andReturn(self::MOCKED_DATE);

        $this->mock(DatabaseManager::class)
            ->shouldReceive('table')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('select')
            ->once()
            ->with($parameters)
            ->andReturnSelf()
            ->shouldReceive('join')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('orderBy')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('limit')
            ->once()
            ->with(HistoryMySQL::RESULTS_LIMIT)
            ->andReturnSelf()
            ->shouldReceive('get')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('toArray')
            ->once()
            ->andReturn($data);

        $response = $this->get('/');

        foreach (current($data) as $key => $value) {
            $this->assertStringContainsString($value, $response->content());
        }

        $response->assertStatus(Response::HTTP_OK);
    }
}
