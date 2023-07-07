<?php

namespace App\Ranking\Domain\Factories;

use App\Ranking\Domain\Exceptions\NegativeScoreException;
use App\Ranking\Domain\Models\Player;

class PlayerFactory
{
    public function createNewPlayer(string $username): Player
    {
        return new Player($username, 0);
    }

    /**
     * @throws NegativeScoreException
     */
    public function createPlayerWithScore(string $username, int $score): Player
    {
        return new Player($username, $score);
    }

}