<?php

namespace App\Tests\Ranking\Infrastructure\Repositories;

use App\Ranking\Infrastructure\Exceptions\PlayerNotFound;
use App\Ranking\Infrastructure\Repositories\PlayerRepository;
use PHPUnit\Framework\TestCase;

class PlayerRepositoryTest extends TestCase
{
    private PlayerRepository $playerRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->playerRepository = new PlayerRepository();
    }

    public function testGivenAPlayerListWhenGetAllThenReturnPlayerList(): void
    {
        $players = $this->playerRepository->getAll();

        $this->assertCount(5, $players);
    }

    public function testGivenAPlayerListWhenGetAllThenReturnPlayerListWithCorrectUsername(): void
    {
        $players = $this->playerRepository->getAll();

        $this->assertSame('John', $players[0]->getUsername());
        $this->assertSame('Jane', $players[1]->getUsername());
        $this->assertSame('Bob', $players[2]->getUsername());
        $this->assertSame('Mary', $players[3]->getUsername());
        $this->assertSame('Magali', $players[4]->getUsername());
    }

    public function testGivenAPlayerListWhenGetAllThenReturnPlayerListWithCorrectScore(): void
    {
        $players = $this->playerRepository->getAll();

        $this->assertSame(100, $players[0]->getScore());
        $this->assertSame(200, $players[1]->getScore());
        $this->assertSame(300, $players[2]->getScore());
        $this->assertSame(400, $players[3]->getScore());
        $this->assertSame(500, $players[4]->getScore());
    }

    public function testGivenAPlayerListWhenGetByUsernameThenReturnPlayer(): void
    {
        $player = $this->playerRepository->getByUsername('John');

        $this->assertSame('John', $player->getUsername());
        $this->assertSame(100, $player->getScore());
    }

    public function testGivenAPlayerListWhenGetByUsernameThenRaiseError(): void
    {
        $this->expectException(PlayerNotFound::class);

        $this->playerRepository->getByUsername('Alice');
    }

    public function testGivenUnUpdatedPlayerWhenSaveThenUpdatePlayerInfo(): void
    {
        $player = $this->playerRepository->getByUsername('John');
        $player->setScore(200);
        $this->playerRepository->save($player);
        $player = $this->playerRepository->getByUsername('John');
        $this->assertSame(200, $player->getScore());
    }

    public function testGivenANotExistingUpdatedPlayerWhenSaveThenRaiseError(): void
    {
        $this->expectException(PlayerNotFound::class);

        $player = $this->playerRepository->getByUsername('Alice');
        $player->setScore(200);
        $this->playerRepository->save($player);
    }


}