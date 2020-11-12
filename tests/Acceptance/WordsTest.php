<?php

namespace Tests\Acceptance;

use App\Sources\MySQL\WordsMySQL;
use Illuminate\Database\DatabaseManager;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class WordsTest extends TestCase
{
    protected $dbMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->dbMock = $this->mock(DatabaseManager::class);
    }

    public function testIndex()
    {
        $returnData = [
            (object) [
                '__pk'=> '1111',
                'short_word'=> 'aardvark',
                'used'=> '1',
                'visited'=> '3'
            ],
            (object) [
                '__pk'=> '1112',
                'short_word'=> 'abandoned',
                'used'=> '0',
                'visited'=> '0'
            ]
        ];

        $this->dbMock
            ->shouldReceive('table')
            ->once()
            ->with(WordsMySQL::WORD_LIST_TABLE)
            ->andReturnSelf()
            ->shouldReceive('get')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('toArray')
            ->once()
            ->andReturn($returnData);

        $response = $this->get('/words');

        $response->assertStatus(Response::HTTP_OK);

        $this->assertEquals(json_encode(['payload' => $returnData]), $response->content());
    }
}
