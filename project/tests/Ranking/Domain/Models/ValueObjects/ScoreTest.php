<?php

namespace App\Tests\Ranking\Domain\Models\ValueObjects;

use App\Ranking\Domain\Exceptions\NegativeScoreException;
use App\Ranking\Domain\Models\ValueObjects\Score;
use PHPUnit\Framework\TestCase;

class ScoreTest extends TestCase
{
    public function testGivenAScoreWhenCreateScoreThenReturnScore()
    {
        $score = new Score(5);
        $this->assertInstanceOf(Score::class, $score);
    }

    public function testGivenANegativeScoreWhenCreateScoreThenThrowNegativeScoreException()
    {
        $this->expectException(NegativeScoreException::class);
        new Score(-1);
    }

    public function testGivenAScoreWhenGetScoreThenReturnScore()
    {
        $score = new Score(5);
        $this->assertSame(5, $score->getValue());
    }

    public function testGivenAPositiveScoreWhenSetScoreThenScoreIsSet()
    {
        $score = new Score(0);
        $score->add(5);
        $this->assertSame(5, $score->getValue());
    }

    public function testGivenPositiveScoreWhenAddPositiveScoreThenScoreIsIncreased()
    {
        $score = new Score(2);
        $score->add(5);
        $this->assertSame(7, $score->getValue());
    }

    public function testGivenPositiveScoreWhenAddNegativeScoreThenScoreIsDecreased()
    {
        $score = new Score(7);
        $score->add(-5);
        $this->assertSame(2, $score->getValue());
    }

    public function testGivenANegativeScoreWhenScoreIsSetThenSetScoreToZero()
    {
        $score = new Score(0);
        $score->add(-1);
        $this->assertSame(0, $score->getValue());
    }

}