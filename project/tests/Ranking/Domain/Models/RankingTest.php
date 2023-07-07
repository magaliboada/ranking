<?php

namespace App\Tests\Ranking\Domain\Models;

use App\Ranking\Domain\Factories\PlayerFactory;
use App\Ranking\Domain\Models\Ranking;
use PHPUnit\Framework\TestCase;

class RankingTest extends TestCase
{
    private PlayerFactory $factory;

    public function setUp(): void
    {
        parent::setUp();
        $this->factory = new PlayerFactory();
    }

    public function testGivenARankingWhenCreateRankingThenReturnRanking()
    {
        $ranking = new Ranking();
        $this->assertInstanceOf(Ranking::class, $ranking);
    }

    public function testGivenAPlayerWhenAddPlayerThenPlayerIsAdded()
    {
        $ranking = new Ranking();

        $ranking->addPlayer($this->factory->createNewPlayer('test'));

        $player = $ranking->getPlayers()[0];
        $this->assertSame('test', $player->getUsername());
        $this->assertSame(0, $player->getScore());
    }

    public function testGivenARankingWithPlayersWhenAddPlayerThenPlayerIsAdded()
    {
        $ranking = new Ranking(
            [
                $this->factory->createNewPlayer('test'),
                $this->factory->createNewPlayer('test2'),
            ]
        );

        $ranking->addPlayer($this->factory->createNewPlayer('test3'));

        $players = $ranking->getPlayers();
        $this->assertCount(3, $players);
        $this->assertSame('test3', $players[2]->getUsername());
        $this->assertSame(0, $players[2]->getScore());
    }

    public function testGivenARankingWithPlayersWhenGetPlayersSortedByScoreThenPlayersAreSorted()
    {
        $ranking = new Ranking(
            [
                $this->factory->createPlayerWithScore('test', 2),
                $this->factory->createPlayerWithScore('test2', 5),
                $this->factory->createPlayerWithScore('test3', 3),
            ]
        );

        $players = $ranking->getPlayersSortedByScore();
        $this->assertCount(3, $players);
        $this->assertSame('test2', $players[0]->getUsername());
        $this->assertSame(5, $players[0]->getScore());
        $this->assertSame('test3', $players[1]->getUsername());
        $this->assertSame(3, $players[1]->getScore());
        $this->assertSame('test', $players[2]->getUsername());
        $this->assertSame(2, $players[2]->getScore());
    }

}