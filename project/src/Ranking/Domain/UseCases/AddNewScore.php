<?php

namespace App\Ranking\Domain\UseCases;

use App\Ranking\Domain\Exceptions\NegativeScoreException;
use App\Ranking\Domain\Interfaces\PlayersRepositoryInterface;

class AddNewScore
{
    private PlayersRepositoryInterface $playerRepository;

    public function __construct(PlayersRepositoryInterface $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    /**
     * @throws NegativeScoreException
     */
    public function execute(string $username, string $newScore): void
    {
        $user = $this->playerRepository->getByUsername($username);

        if ($this->isAbsoluteScore($newScore)) {
            $user->setScore((int)$newScore);
        } else {
            $user->addScore((int)$newScore);
        }
        $this->playerRepository->save($user);
    }

    private function isAbsoluteScore(string $newScore): bool
    {
        return preg_match('/[+-]/', $newScore) === 0;
    }
}