<?php

namespace Tests\Acceptance;

use App\Sources\MySQL\HistoryMySQL;
use Illuminate\Database\DatabaseManager;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class HomeTest extends TestCase
{
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
                'created' => '',
                'visited' => '9999',
                'short_word' => 'testShortWord'
            ]
        ];

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
