<?php

namespace App\Tests\Ranking\Domain\Factories;

use App\Ranking\Domain\Factories\PlayerFactory;
use App\Ranking\Domain\Models\Player;
use PHPUnit\Framework\TestCase;

class PlayerFactoryTest extends TestCase
{
    private PlayerFactory $factory;
    
    public function setUp(): void
    {
        parent::setUp();
        $this->factory = new PlayerFactory();
    }

    public function testGivenANewPlayerWhenCreateThenReturnPlayer()
    {
        $player = $this->factory->createNewPlayer('test');
        $this->assertInstanceOf(Player::class, $player);
        $this->assertSame('test', $player->getUsername());
    }

    public function testGivenAPlayerWithScoreWhenCreateThenReturnPlayer()
    {
        $player = $this->factory->createPlayerWithScore('test', 10);
        $this->assertInstanceOf(Player::class, $player);
        $this->assertSame('test', $player->getUsername());
        $this->assertSame(10, $player->getScore());
    }
}