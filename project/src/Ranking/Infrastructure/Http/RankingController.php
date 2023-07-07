<?php

namespace App\Ranking\Infrastructure\Http;

use App\Ranking\Domain\UseCases\GetAbsoluteRanking;
use App\Ranking\Domain\UseCases\GetRelativeRanking;
use App\Ranking\Infrastructure\Repositories\PlayerRepository;
use App\Ranking\Infrastructure\Services\ValidationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RankingController extends AbstractController
{
    #[Route('/ranking', name: 'ranking', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $rankingType = $request->query->get('type');
        $violations = ValidationService::validateRankingRequest(rankingType: $rankingType);

        if (count($violations) > 0) {
            return new Response($violations[0]->getMessage(), 400);
        }

        $playerRepository = new PlayerRepository();

        $ranking = $this->isAbsoluteRanking($rankingType)
            ? $this->getAbsoluteRanking($rankingType, $playerRepository)
            : $this->getRelativeRanking($rankingType, $playerRepository);

        return new Response(
            json_encode($ranking),
            200,
            ['Content-Type' => 'application/json']
        );
    }

    private function isAbsoluteRanking(string $rankingType): bool
    {
        return (bool)preg_match('/^top\d+$/', $rankingType);
    }

    private function getAbsoluteRanking(string $rankingType, PlayerRepository $playerRepository): array
    {
        $limit = (int)substr($rankingType, 3);
        $getAbsoluteRanking = new GetAbsoluteRanking($playerRepository);
        return $getAbsoluteRanking->execute(limit: $limit);
    }

    private function getRelativeRanking(string $rankingType, PlayerRepository $playerRepository): array
    {
        $rankingType = explode('/', $rankingType);
        $limit = (int)substr($rankingType[1], 0, 1);
        $position = (int)substr($rankingType[0], 2);
        $getRelativeRanking = new GetRelativeRanking($playerRepository);
        return $getRelativeRanking->execute(limit: $limit, position: $position);
    }
}
