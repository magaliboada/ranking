<?php

namespace App\Tests\Ranking\Domain\Models;

use App\Ranking\Domain\Exceptions\NegativeScoreException;
use App\Ranking\Domain\Models\Player;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    public function testGivenAUsernameAndScoreWhenCreatePlayerThenReturnPlayer()
    {
        $player = new Player(username: 'test', score: 0);
        $this->assertInstanceOf(Player::class, $player);
    }

    public function testGivenANegativeScoreWhenCreatePlayerThenThrowNegativeScoreException()
    {
        $this->expectException(NegativeScoreException::class);
        new Player(username: 'test', score: -1);
    }

    public function testGivenAScoreWhenGetScoreThenReturnScore()
    {
        $player = new Player(username: 'test', score: 5);
        $this->assertSame(5, $player->getScore());
    }

    public function testGivenAUsernameWhenGetUsernameThenReturnUsername()
    {
        $player = new Player(username: 'test_name', score: 0);
        $this->assertSame('test_name', $player->getUsername());
    }

    public function testGivenAPositiveScoreWhenSetScoreThenScoreIsSet()
    {
        $player = new Player(username: 'test', score: 0);
        $player->setScore(5);
        $this->assertSame(5, $player->getScore());
    }

    public function testGivenANegativeScoreWhenSetScoreThenThrowNegativeScoreException()
    {
        $this->expectException(NegativeScoreException::class);
        $player = new Player(username: 'test', score: 0);
        $player->setScore(-1);
    }

    public function testGivenPositiveScoreWhenAddScoreThenScoreIsIncreased()
    {
        $player = new Player(username: 'test', score: 2);
        $player->addScore(5);
        $this->assertSame(7, $player->getScore());
    }

    public function testGivenPositiveScoreWhenAddScoreThenScoreIsDecreased()
    {
        $player = new Player(username: 'test', score: 7);
        $player->addScore(-5);
        $this->assertSame(2, $player->getScore());
    }


    public function testGivenZeroScoreWhenRemoveScoreThenScoreIsZero()
    {
        $player = new Player(username: 'test', score: 0);
        $player->addScore(-5);
        $this->assertSame(0, $player->getScore());
    }
}