<?php

namespace App\Ranking\Infrastructure\Repositories;

use App\Ranking\Domain\Factories\PlayerFactory;
use App\Ranking\Domain\Interfaces\PlayersRepositoryInterface;
use App\Ranking\Domain\Models\Player;
use App\Ranking\Infrastructure\Exceptions\PlayerNotFound;
use Exception;

class PlayerRepository implements PlayersRepositoryInterface
{
    private array $players;

    public function __construct()
    {
        $playerFactory = new PlayerFactory();
        $this->players = [
            $playerFactory->createPlayerWithScore('John', 100),
            $playerFactory->createPlayerWithScore('Jane', 200),
            $playerFactory->createPlayerWithScore('Bob', 300),
            $playerFactory->createPlayerWithScore('Mary', 400),
            $playerFactory->createPlayerWithScore('Magali', 500),
        ];
    }

    /**
     * @throws Exception
     */
    public function getByUsername(string $username): ?Player
    {
        $players = $this->getAll();
        foreach ($players as $player) {
            if ($player->getUsername() === $username) {
                return $player;
            }
        }

        throw new PlayerNotFound();
    }

    public function getAll(): array
    {
        return $this->players;
    }

    /**
     * @throws PlayerNotFound
     */
    public function save(Player $newPlayer): void
    {
        $players = $this->getAll();

        foreach ($players as $key => &$player) {
            if ($player->getUsername() === $newPlayer->getUsername()) {
                $players[$key] = $newPlayer;
                return;
            }
        }

        throw new PlayerNotFound();
    }
}