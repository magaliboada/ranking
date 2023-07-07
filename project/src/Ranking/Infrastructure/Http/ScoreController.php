<?php

namespace App\Ranking\Infrastructure\Http;

use App\Ranking\Domain\Exceptions\NegativeScoreException;
use App\Ranking\Domain\UseCases\AddNewScore;
use App\Ranking\Infrastructure\Exceptions\PlayerNotFound;
use App\Ranking\Infrastructure\Repositories\PlayerRepository;
use App\Ranking\Infrastructure\Services\ValidationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScoreController extends AbstractController
{
    #[Route('/user/{username}/{newScore}', name: 'add_score', methods: ['POST'])]
    public function index(string $username, string $newScore): Response
    {
        $violations = ValidationService::validateScoreRequest(username: $username, newScore: $newScore);

        if (count($violations) > 0) {
            return new Response($violations[0]->getMessage(), 400);
        }

        $playerRepository = new PlayerRepository();
        $addNewScore = new AddNewScore($playerRepository);

        try {
            $addNewScore->execute(username: $username, newScore: $newScore);
        } catch (PlayerNotFound $e) {
            return new Response('Player not found', 404);
        } catch (NegativeScoreException $e) {
            return new Response('The score cannot be negative', 400);
        }

        $finalScore = $playerRepository->getByUsername($username)->getScore();
        return new Response(
            "The new score is: $finalScore"
        );
    }
}
