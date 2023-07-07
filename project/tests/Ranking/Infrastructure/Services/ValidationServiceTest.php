<?php

use App\Ranking\Infrastructure\Services\ValidationService;
use PHPUnit\Framework\TestCase;

class ValidationServiceTest extends TestCase
{
    public static function invalidParameters(): array
    {
        return [
            ['top12a'],
            ['tor100'],
            ['top100/3'],
            ['At100'],
            ['At30/'],
            ['At12/a']
        ];
    }

    public static function provideInvalidUsername(): array
    {
        return [
            ['Ma', 'This value is too short. It should have 3 characters or more.'],
            ['Maaaaaaaaaaaaaaaaaaaaaa', 'This value is too long. It should have 15 characters or less.'],
            ['M@gali', 'The username must be alphanumeric']
        ];
    }

    public static function provideInvalidScore(): array
    {
        return [
            ['Miau'],
            ['399A'],
            ['A399'],
            ['+399A'],
            ['*399'],
        ];
    }

    /**
     * @dataProvider invalidParameters
     */
    public function testGivenAnInvalidParameterWhenValidatingRankingRequestThenReturnErrorMessage($parameter): void
    {
        $validationService = ValidationService::validateRankingRequest($parameter);

        $this->assertEquals(
            'The value has to be in the format: At{position}/{limit} or top{limit}',
            $validationService[0]->getMessage()
        );
    }

    public function testGivenAnAbsoluteRankingWhenValidatingRankingRequestThenReturnEmptyArray(): void
    {
        $validationService = ValidationService::validateRankingRequest('top2');


        $this->assertCount(0, $validationService);
    }

    public function testGivenARelativeRankingWhenValidatingRankingRequestThenReturnEmptyArray(): void
    {
        $validationService = ValidationService::validateRankingRequest('At2/3');


        $this->assertCount(0, $validationService);
    }

    public function testGivenAnInvalidUsernameWhenValidatingScoreRequestThenReturnErrorMessage(): void
    {
        $validationService = ValidationService::validateScoreRequest('Magali@', '100');

        $this->assertEquals(
            'The username must be alphanumeric',
            $validationService[0]->getMessage()
        );
    }

    public function testGivenAnInvalidScoreWhenValidatingScoreRequestThenReturnErrorMessage(): void
    {
        $validationService = ValidationService::validateScoreRequest('Magali', '100a');

        $this->assertEquals(
            'The score must be a number',
            $validationService[0]->getMessage()
        );
    }

    /**
     * @dataProvider provideInvalidUsername
     */
    public function testGivenAnInvalidUsernameWhenValidatingUsernameThenReturnErrorMessage($username, $errorMessage): void
    {
        $validationService = ValidationService::validateScoreRequest($username, '100');

        $this->assertEquals(
            $errorMessage,
            $validationService[0]->getMessage()
        );
    }

    /**
     * @dataProvider provideInvalidScore
     */
    public function testGivenAnInvalidScoreWhenValidatingScoreThenReturnErrorMessage($score): void
    {
        $validationService = ValidationService::validateScoreRequest('Magali', $score);

        $this->assertEquals(
            'The score must be a number',
            $validationService[0]->getMessage()
        );
    }

}

