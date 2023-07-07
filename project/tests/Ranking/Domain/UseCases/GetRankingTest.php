<?php

namespace App\Tests\Ranking\Domain\UseCases;

use App\Ranking\Domain\Factories\PlayerFactory;
use App\Ranking\Infrastructure\Repositories\PlayerRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetRankingTest extends TestCase
{
    protected MockObject $playerRepository;
    protected PlayerFactory $factory;

    public function setUp(): void
    {
        parent::setUp();
        $this->factory = new PlayerFactory();
        $this->playerRepository = $this
            ->getMockBuilder(PlayerRepository::class)
            ->getMock();
    }

    public function testTrue(): void
    {
        $this->assertTrue(true);
    }

    protected function setGetAllParameters(): void
    {
        $this->playerRepository->expects($this->exactly(1))
            ->method('getAll')
            ->willReturn([
                $this->factory->createPlayerWithScore(username: 'Magali', score: 11),
                $this->factory->createPlayerWithScore(username: 'John', score: 15),
                $this->factory->createPlayerWithScore(username: 'Jane', score: 8),
                $this->factory->createPlayerWithScore(username: 'Bob', score: 12),
                $this->factory->createPlayerWithScore(username: 'Alice', score: 3),
                $this->factory->createPlayerWithScore(username: 'Peter', score: 17),
                $this->factory->createPlayerWithScore(username: 'Mary', score: 9),
            ]);
    }
}