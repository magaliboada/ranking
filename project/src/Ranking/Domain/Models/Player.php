<?php

namespace App\Ranking\Domain\Models;

use App\Ranking\Domain\Exceptions\NegativeScoreException;
use App\Ranking\Domain\Models\ValueObjects\Score;
use JsonSerializable;

class Player implements JsonSerializable
{
    private string $username;
    private Score $score;

    /**
     * @throws NegativeScoreException
     */
    public function __construct(string $username, int $score)
    {
        $this->username = $username;
        $this->score = new Score($score);
    }

    public function addScore(int $newScore): void
    {
        $this->score->add($newScore);
    }

    public function jsonSerialize(): array
    {
        return [
            'username' => $this->getUsername(),
            'score' => $this->getScore(),
        ];
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getScore(): int
    {
        return $this->score->getValue();
    }

    /**
     * @throws NegativeScoreException
     */
    public function setScore(int $score): void
    {
        $this->score = new Score($score);
    }
}