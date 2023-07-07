<?php

namespace App\Tests\Ranking\Infrastructure\Http;

use GuzzleHttp\Client;
use JetBrains\PhpStorm\NoReturn;
use PHPUnit\Framework\TestCase;

class RankingControllerTest extends TestCase
{
    public static function invalidParameters(): array
    {
        return [
            ['top12a'],
            ['tor100'],
            ['top100/3'],
            ['At100'],
            ['At30/'],
            ['At12/a']
        ];
    }

    #[NoReturn] public function testGivenAnAbsoluteRankingWhenMakingTheRequestThenGetRankingMessage(): void
    {
        $client = new Client([
            'base_uri' => 'http://localhost:8000',
            'http_errors' => false,
        ]);

        $request = $client->get('/ranking?type=top2');

        $this->assertEquals(200, $request->getStatusCode());
        $this->assertEquals(
            '[{"username":"Magali","score":500},{"username":"Mary","score":400}]',
            $request->getBody()->getContents()
        );
    }

    #[NoReturn] public function testGivenARelativeRankingWhenMakingTheRequestThenGetRankingMessage(): void
    {
        $client = new Client([
            'base_uri' => 'http://localhost:8000',
            'http_errors' => false,
        ]);

        $request = $client->get('/ranking?type=At1/2');

        $this->assertEquals(200, $request->getStatusCode());
        $this->assertEquals(
            '[{"username":"Magali","score":500},{"username":"Mary","score":400},{"username":"Bob","score":300},{"username":"Jane","score":200}]',
            $request->getBody()->getContents()
        );
    }

    /**
     * @dataProvider invalidParameters
     */
    #[NoReturn] public function testGivenAnInvalidParameterWhenMakingTheRequestThenGetErrorMessage($parameter): void
    {
        $client = new Client([
            'base_uri' => 'http://localhost:8000',
            'http_errors' => false,
        ]);

        $request = $client->get("/ranking?type=$parameter");

        $this->assertEquals(400, $request->getStatusCode());
        $this->assertEquals(
            'The value has to be in the format: At{position}/{limit} or top{limit}',
            $request->getBody()->getContents()
        );
    }

}