<?php

namespace App\Ranking\Domain\UseCases;

use App\Ranking\Domain\Interfaces\PlayersRepositoryInterface;
use App\Ranking\Domain\Models\Ranking;

class GetAbsoluteRanking
{
    private PlayersRepositoryInterface $playerRepository;

    public function __construct(PlayersRepositoryInterface $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    public function execute(int $limit): array
    {
        $users = $this->playerRepository->getAll();

        $ranking = new Ranking($users);

        return array_slice($ranking->getPlayersSortedByScore(), 0, $limit);
    }
}