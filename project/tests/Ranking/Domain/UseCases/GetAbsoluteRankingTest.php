<?php

namespace App\Tests\Ranking\Domain\UseCases;

use App\Ranking\Domain\UseCases\GetAbsoluteRanking;

class GetAbsoluteRankingTest extends GetRankingTest
{
    private GetAbsoluteRanking $getAbsoluteRanking;

    public function setUp(): void
    {
        parent::setUp();
        $this->getAbsoluteRanking = new GetAbsoluteRanking($this->playerRepository);
    }

    public function testGivenAUserListWhenGettingAbsoluteRankingThenReturnResult()
    {
        $this->setGetAllParameters();
        $ranking = $this->getAbsoluteRanking->execute(limit: 5);

        $this->assertCount(5, $ranking);
        $this->assertSame('Peter', $ranking[0]->getUsername());
        $this->assertSame('John', $ranking[1]->getUsername());
        $this->assertSame('Bob', $ranking[2]->getUsername());
        $this->assertSame('Magali', $ranking[3]->getUsername());
        $this->assertSame('Mary', $ranking[4]->getUsername());
    }

    public function testGivenAUserListWhenGettingAbsoluteRankingWithLimitThenReturnResult()
    {
        $this->setGetAllParameters();
        $ranking = $this->getAbsoluteRanking->execute(limit: 1);

        $this->assertCount(1, $ranking);
        $this->assertSame('Peter', $ranking[0]->getUsername());
    }
}