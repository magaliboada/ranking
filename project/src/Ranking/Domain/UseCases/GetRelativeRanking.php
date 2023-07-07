<?php

namespace App\Ranking\Domain\UseCases;

use App\Ranking\Domain\Interfaces\PlayersRepositoryInterface;
use App\Ranking\Domain\Models\Ranking;

class GetRelativeRanking
{
    private PlayersRepositoryInterface $playerRepository;

    public function __construct(PlayersRepositoryInterface $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    public function execute(int $limit, int $position): array
    {
        $players = (new Ranking($this->playerRepository->getAll()))
            ->getPlayersSortedByScore();

        $start = max($position - $limit, 0);
        $end = min($position + $limit, count($players) - 1);

        return array_slice($players, $start, $end - $start + 1);
    }
}