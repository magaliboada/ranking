<?php


namespace App\Tests\Ranking\Domain\UseCases;

use App\Ranking\Domain\Factories\PlayerFactory;
use App\Ranking\Domain\Models\Player;
use App\Ranking\Domain\UseCases\AddNewScore;
use App\Ranking\Infrastructure\Repositories\PlayerRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class AddNewScoreTest extends TestCase
{
    private AddNewScore $addNewScore;
    private MockObject $playerRepository;
    private PlayerFactory $factory;

    public function setUp(): void
    {
        parent::setUp();
        $this->factory = new PlayerFactory();
        $this->playerRepository = $this
            ->getMockBuilder(PlayerRepository::class)
            ->getMock();
        $this->addNewScore = new AddNewScore($this->playerRepository);
    }

    public function testGivenAUsernameAndScoreWhenAddingNewScoreThenReturnPlayerWithNewScore()
    {
        $user = $this->factory->createPlayerWithScore(username: 'test', score: 3);
        $this->setGetByUserNameParameters($user);

        $this->addNewScore->execute(username: 'test', newScore: '+5');

        $this->assertSame(8, $user->getScore());
    }

    public function setGetByUserNameParameters(Player $user): void
    {
        $this->playerRepository->expects($this->exactly(1))
            ->method('getByUsername')
            ->with('test')
            ->willReturn($user);

        $this->playerRepository->expects($this->exactly(1))
            ->method('save');
    }

    public function testGivenAUsernameAndNegativeScoreWhenAddingNewScoreThenReturnPlayerWithNewScore()
    {
        $user = $this->factory->createPlayerWithScore(username: 'test', score: 12);
        $this->setGetByUserNameParameters($user);

        $this->addNewScore->execute(username: 'test', newScore: '-5');

        $this->assertSame(7, $user->getScore());
    }

    public function testGivenAUsernameAndNegativeScoreOnZeroWhenAddingNewScoreThenReturnPlayerWithZeroScore()
    {
        $user = $this->factory->createPlayerWithScore(username: 'test', score: 0);
        $this->setGetByUserNameParameters($user);

        $this->addNewScore->execute(username: 'test', newScore: '-5');

        $this->assertSame(0, $user->getScore());
    }

}