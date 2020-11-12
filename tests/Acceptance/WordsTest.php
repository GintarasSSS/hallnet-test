<?php

namespace Tests\Acceptance;

use App\Sources\MySQL\WordsMySQL;
use Carbon\Carbon;
use Illuminate\Database\DatabaseManager;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class WordsTest extends TestCase
{
    use WithoutMiddleware;

    const MOCKED_DATE = '2010-10-10 12:00:00';

    protected $dbMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->dbMock = $this->mock(DatabaseManager::class);
        $this->mock(Carbon::class)->shouldReceive('format')->andReturn(self::MOCKED_DATE);
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

    /**
     * @dataProvider storeData
     */
    public function testStore($requestData, $wordListResult, $insertResult)
    {
        $this->dbMock
            ->shouldReceive('table')
            ->times((int)!empty($requestData))
            ->with(WordsMySQL::WORD_LIST_TABLE)
            ->andReturnSelf()
            ->shouldReceive('where')
            ->times((int)!empty($requestData))
            ->with('used', 0)
            ->andReturnSelf()
            ->shouldReceive('first')
            ->times((int)!empty($requestData))
            ->andReturn($wordListResult);

        $this->dbMock
            ->shouldReceive('table')
            ->times((int)!empty($wordListResult))
            ->with(WordsMySQL::URL_MAPPING_TABLE)
            ->andReturnSelf()
            ->shouldReceive('insert')
            ->times((int)!empty($wordListResult))
            ->with([
                '_fk_pk_eff_short_wordlist' => $wordListResult->__pk ?? '',
                'url' => $requestData['url'] ?? '',
                'description' => $requestData['text'] ?? '',
                'private' => $requestData['private'] ?? 0,
                'created' => self::MOCKED_DATE
            ])
            ->andReturn($insertResult);

        $this->dbMock
            ->shouldReceive('table')
            ->times((int)$insertResult)
            ->with(WordsMySQL::WORD_LIST_TABLE)
            ->andReturnSelf()
            ->shouldReceive('where')
            ->times((int)$insertResult)
            ->with('__pk', '=', $wordListResult->__pk ?? '')
            ->andReturnSelf()
            ->shouldReceive('update')
            ->times((int)$insertResult)
            ->with(['used' => 1]);

        $response = $this->post('/words/store', $requestData);

        $response->assertStatus(Response::HTTP_FOUND);
    }

    public function storeData(): array
    {
        $requestData = [
            'url' => 'https://test.co.uk',
            'text' => 'description test',
            'private' => '1'
        ];

        $wordListData = (object) [
            '__pk' => 9999
        ];

        return [
            'endpoint call without data' => [
                'requestData' => [],
                'wordListResult' => null,
                'insertResult' => false
            ],
            'shortened word list is out of data' => [
                'requestData' => $requestData,
                'wordListResult' => null,
                'insertResult' => false
            ],
            'insert new data failed into url mapping table ' => [
                'requestData' => $requestData,
                'wordListResult' => $wordListData,
                'insertResult' => false
            ],
            'update word list table by marking word as used' => [
                'requestData' => $requestData,
                'wordListResult' => $wordListData,
                'insertResult' => true
            ]
        ];
    }
}
