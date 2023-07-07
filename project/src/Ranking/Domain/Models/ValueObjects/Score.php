<?php

namespace App\Ranking\Domain\Models\ValueObjects;

use App\Ranking\Domain\Exceptions\NegativeScoreException;

class Score
{
    const MINIMUM_SCORE = 0;
    private int $value;

    /**
     * @throws NegativeScoreException
     */
    public function __construct(int $value)
    {
        if ($value < $this::MINIMUM_SCORE) {
            throw new NegativeScoreException();
        }
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function add(int $value): void
    {
        $this->value += $value;
        // Prevent negative scores when adding negative values
        $this->value = max($this->value, $this::MINIMUM_SCORE);
    }

}