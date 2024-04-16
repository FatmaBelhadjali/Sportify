<?php

namespace App\Controller;

use App\Entity\Terrain;
use App\Form\TerrainType;
use App\Repository\TerrainRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Sport;

#[Route('/terrainfront')]
class TerrainFrontController extends AbstractController
{
    #[Route('/', name: 'app_terrain_indexfront', methods: ['GET'])]
    public function index(TerrainRepository $terrainRepository): Response
    {
        $sports = $this->getDoctrine()->getRepository(Sport::class)->findAll();
$terrainsBySport = [];

foreach ($sports as $sport) {
    $terrains = $terrainRepository->findBy(['sport' => $sport->getId()]);
    $terrainsBySport[$sport->getName()] = $terrains;
}

return $this->render('terrainfront/index.html.twi²g', [
    'terrainsBySport' => $terrainsBySport,
]);

    }
}

