<?php

namespace App\Tests\Ranking\Infrastructure\Http;

use GuzzleHttp\Client;
use JetBrains\PhpStorm\NoReturn;
use PHPUnit\Framework\TestCase;

class ScoreControllerTest extends TestCase
{
    public static function provideInvalidUsername(): array
    {
        return [
            ['Ma', 'This value is too short. It should have 3 characters or more.'],
            ['Maaaaaaaaaaaaaaaaaaaaaa', 'This value is too long. It should have 15 characters or less.'],
            ['M@gali', 'The username must be alphanumeric']
        ];
    }

    public static function provideInvalidScore(): array
    {
        return [
            ['Miau'],
            ['399A'],
            ['A399'],
            ['+399A'],
            ['*399'],
        ];
    }

    #[NoReturn] public function testGivenANewScoreWhenMakingTheRequestThenGetSuccessMessage(): void
    {
        $client = new Client([
            'base_uri' => 'http://localhost:8000',
            'http_errors' => false,
        ]);

        $request = $client->post('/user/Magali/1000');

        $this->assertEquals(200, $request->getStatusCode());
        $this->assertEquals("The new score is: 1000", $request->getBody()->getContents());
    }

    #[NoReturn] public function testGivenANegativeScoreResultWhenUpdatingScoreThenReturn0(): void
    {
        $client = new Client([
            'base_uri' => 'http://localhost:8000',
            'http_errors' => false,
        ]);

        $request = $client->post('/user/Magali/-10000');

        $this->assertEquals(200, $request->getStatusCode());
        $this->assertEquals("The new score is: 0", $request->getBody()->getContents());
    }

    #[NoReturn] public function testGivenANonExistingUserWhenUpdatingScoreThenGetErrorMessage(): void
    {
        $client = new Client([
            'base_uri' => 'http://localhost:8000',
            'http_errors' => false,
        ]);

        $request = $client->post('/user/MagaliFake/-10000');

        $this->assertEquals(404, $request->getStatusCode());
        $this->assertEquals("Player not found", $request->getBody()->getContents());
    }

    /**
     * @dataProvider provideInvalidUsername
     */
    #[NoReturn] public function testGivenAnInvalidUsernameWhenGetScoreThenReturnInvalidParameters($parameter, $response): void
    {
        $client = new Client([
            'base_uri' => 'http://localhost:8000',
            'http_errors' => false,
        ]);

        $request = $client->post("/user/$parameter/1000");

        $this->assertEquals(400, $request->getStatusCode());
        $this->assertEquals($response, $request->getBody()->getContents());
    }

    /**
     * @dataProvider provideInvalidScore
     */
    #[NoReturn] public function testGivenAnInvalidScoreWhenGetScoreThenReturnInvalidParameters($data): void
    {
        $client = new Client([
            'base_uri' => 'http://localhost:8000',
            'http_errors' => false,
        ]);

        $request = $client->post("/user/Magali/$data");

        $this->assertEquals(400, $request->getStatusCode());
        $this->assertEquals('The score must be a number', $request->getBody()->getContents());
    }
}