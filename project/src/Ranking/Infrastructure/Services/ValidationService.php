<?php

namespace App\Ranking\Infrastructure\Services;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

class ValidationService
{
    public static function validateScoreRequest(string $username, string $newScore): ConstraintViolationListInterface
    {
        $constraints = new Assert\Collection([
            'username' => [
                new Assert\Regex([
                    'pattern' => '/^[a-zA-Z0-9]+$/',
                    'message' => 'The username must be alphanumeric',
                ]),
                new Assert\Length([
                    'min' => 3,
                    'max' => 15,
                ]),
            ],
            'newScore' => [
                new Assert\Regex([
                    'pattern' => '/^[+-]?[0-9]+$/',
                    'message' => 'The score must be a number',
                ]),
            ],
        ]);

        return Validation::createValidator()->validate([
            'username' => $username,
            'newScore' => $newScore,
        ], $constraints);
    }

    public static function validateRankingRequest(string $rankingType): ConstraintViolationListInterface
    {
        $constraints = new Assert\Collection([
            'ranking_type' => [
                new Assert\Regex([
                    'pattern' => '/^(?:At\d+\/\d+|top\d+)$/',
                    'message' => 'The value has to be in the format: At{position}/{limit} or top{limit}',
                ]),
            ],
        ]);

        return Validation::createValidator()->validate([
            'ranking_type' => $rankingType,
        ], $constraints);
    }
}