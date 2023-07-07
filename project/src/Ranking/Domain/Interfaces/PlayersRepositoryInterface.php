<?php

namespace App\Ranking\Domain\Interfaces;

use App\Ranking\Domain\Models\Player;

interface PlayersRepositoryInterface
{
    public function getByUsername(string $username): ?Player;

    public function getAll(): array;

    public function save(Player $newPlayer): void;
}