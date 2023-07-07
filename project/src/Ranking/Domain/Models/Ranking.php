<?php

namespace App\Ranking\Domain\Models;


class Ranking
{
    private array $players;

    public function __construct($players = [])
    {
        $this->players = $players;
    }

    public function addPlayer(Player $player): void
    {
        $this->players[] = $player;
    }

    public function getPlayers(): array
    {
        return $this->players;
    }

    public function getPlayersSortedByScore(): array
    {
        usort($this->players, function (Player $playerA, Player $playerB) {
            return $playerB->getScore() <=> $playerA->getScore();
        });

        return $this->players;
    }
}