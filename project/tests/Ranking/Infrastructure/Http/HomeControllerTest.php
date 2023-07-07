<?php

namespace App\Tests\Ranking\Infrastructure\Http;

use GuzzleHttp\Client;
use JetBrains\PhpStorm\NoReturn;
use PHPUnit\Framework\TestCase;

class HomeControllerTest extends TestCase
{
    #[NoReturn] public function testGivenATestReviewerWhenEnteringTheHomePageThenSayHoli(): void
    {
        $client = new Client([
            'base_uri' => 'http://localhost:8000',
            'http_errors' => false,
        ]);

        $request = $client->post('/');

        $this->assertEquals(200, $request->getStatusCode());
        $this->assertEquals(
            'Holi!',
            $request->getBody()->getContents()
        );
    }
}