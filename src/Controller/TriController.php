<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Terrain;
use App\Entity\Sport;
use App\Form\TerrainType;
use App\Repository\TerrainRepository;

class TriController extends AbstractController
{
    public function displaySortedByNomASC(TerrainRepository $terrainRepository)
    {
        $terrains = $this->getDoctrine()->getRepository(Terrain::class)->findBy([], ['nomterrain' => 'ASC']);

        return $this->render('terrain/index.html.twig', [
            'terrains' => $terrains,
        ]);
    }

    public function displaySortedBySportASC(TerrainRepository $terrainRepository)
    {
        $terrains = $this->getDoctrine()->getRepository(Terrain::class)->findBy([], ['sport' => 'ASC']);

        return $this->render('terrain/index.html.twig', [
            'terrains' => $terrains,
        ]);
    }
    public function displaySortedByNomDESC(TerrainRepository $terrainRepository)
    {
        $terrains = $this->getDoctrine()->getRepository(Terrain::class)->findBy([], ['nomterrain' => 'DESC']);

        return $this->render('terrain/index.html.twig', [
            'terrains' => $terrains,
        ]);
    }

    public function displaySortedBySportDESC(TerrainRepository $terrainRepository)
    {
        $terrains = $this->getDoctrine()->getRepository(Terrain::class)->findBy([], ['sport' => 'DESC']);

        return $this->render('terrain/index.html.twig', [
            'terrains' => $terrains,
        ]);
    }

}
