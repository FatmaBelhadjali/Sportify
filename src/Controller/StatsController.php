<?php

namespace App\Controller;
use App\Entity\Sport;
use App\Form\SportType;
use App\Repository\SportRepository;
use App\Repository\TerrainRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

class StatsController extends AbstractController
{
    #[Route('/terrain/stats', name: 'app_sport_stat')]
    public function stats(TerrainRepository $terrainRepository)
    {
    $stats = $terrainRepository->getStatsByType();

    return $this->render('terrain/stats.html.twig', [
        'stats' => $stats,
    ]);
    }
}