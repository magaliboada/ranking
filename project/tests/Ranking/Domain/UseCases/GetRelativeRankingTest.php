<?php

namespace App\Tests\Ranking\Domain\UseCases;

use App\Ranking\Domain\UseCases\GetRelativeRanking;

class GetRelativeRankingTest extends GetRankingTest
{
    private GetRelativeRanking $getRelativeRanking;

    public function setUp(): void
    {
        parent::setUp();
        $this->getRelativeRanking = new GetRelativeRanking($this->playerRepository);
    }

    public function testGivenAUserListWhenGettingRelativeRankingThenReturnResult()
    {
        $this->setGetAllParameters();
        $ranking = $this->getRelativeRanking->execute(limit: 2, position: 4);

        $this->assertCount(5, $ranking);
        $this->assertSame('Bob', $ranking[0]->getUsername());
        $this->assertSame('Magali', $ranking[1]->getUsername());
        $this->assertSame('Mary', $ranking[2]->getUsername());
        $this->assertSame('Jane', $ranking[3]->getUsername());
        $this->assertSame('Alice', $ranking[4]->getUsername());
    }

    public function testGivenAUserListWhenGettingRelativeRankingWithLowLimitThenReturnResult()
    {
        $this->setGetAllParameters();
        $ranking = $this->getRelativeRanking->execute(limit: 2, position: 0);

        $this->assertCount(3, $ranking);
        $this->assertSame('Peter', $ranking[0]->getUsername());
        $this->assertSame('John', $ranking[1]->getUsername());
        $this->assertSame('Bob', $ranking[2]->getUsername());

    }

    public function testGivenAUserListWhenGettingRelativeRankingWithTopLimitThenReturnResult()
    {
        $this->setGetAllParameters();
        $ranking = $this->getRelativeRanking->execute(limit: 2, position: 7);


        $this->assertCount(2, $ranking);
        $this->assertSame('Jane', $ranking[0]->getUsername());
        $this->assertSame('Alice', $ranking[1]->getUsername());
    }

    public function testGivenAUserListWhenGettingRelativeRankingWithTopAndLowLimitThenReturnResult()
    {
        $this->setGetAllParameters();
        $ranking = $this->getRelativeRanking->execute(limit: 10, position: 4);

        $this->assertCount(7, $ranking);
        $this->assertSame('Peter', $ranking[0]->getUsername());
        $this->assertSame('Alice', $ranking[6]->getUsername());
    }

    public function testGivenAUserListWhenGettingRelativeRankingWithZeroValuesThenReturnResult()
    {
        $this->setGetAllParameters();
        $ranking = $this->getRelativeRanking->execute(limit: 0, position: 0);

        $this->assertCount(1, $ranking);
        $this->assertSame('Peter', $ranking[0]->getUsername());
    }

}