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
use Joli\JoliNotif\Notification;
use Joli\JoliNotif\NotifierFactory;


class TerrainController extends AbstractController
{
    #[Route('/terrain', name: 'app_terrain_index', methods: ['GET'])]
    public function index(TerrainRepository $terrainRepository): Response
    {
        return $this->render('terrain/index.html.twig', [
            'terrains' => $terrainRepository->findAll(),
        ]);
    }

    #[Route('/terrain/new', name: 'app_terrain_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $terrain = new Terrain();
        $form = $this->createForm(TerrainType::class, $terrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->sendNotification();
            $entityManager->persist($terrain);
            $entityManager->flush();

            return $this->redirectToRoute('app_terrain_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('terrain/new.html.twig', [
            'terrain' => $terrain,
            'form' => $form,
        ]);
    }

    #[Route('/terrain/{idTerrain}', name: 'app_terrain_show', methods: ['GET'])]
    public function show(Terrain $terrain): Response
    {
        return $this->render('terrain/show.html.twig', [
            'terrain' => $terrain,
        ]);
    }

    #[Route('/terrain/{idTerrain}/edit', name: 'app_terrain_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Terrain $terrain, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TerrainType::class, $terrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();


            return $this->redirectToRoute('app_terrain_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('terrain/edit.html.twig', [
            'terrain' => $terrain,
            'form' => $form,
        ]);
    }

    #[Route('/terrain/{idTerrain}', name: 'app_terrain_delete', methods: ['POST'])]
    public function delete(Request $request, Terrain $terrain, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$terrain->getIdTerrain(), $request->request->get('_token'))) {
            $entityManager->remove($terrain);
           

            $entityManager->flush();
        }

        return $this->redirectToRoute('app_terrain_index', [], Response::HTTP_SEE_OTHER);
    }


    public function displaySortedByNomASC()
    {
        $terrains = $this->getDoctrine()->getRepository(Terrain::class)->findBy([], ['nomTerrain' => 'ASC']);

        return $this->render('terrain/index.html.twig', [
            'terrains' => $terrains,
        ]);
    }

    public function displaySortedBySportASC()
    {
        $terrains = $this->getDoctrine()->getRepository(Terrain::class)->findBy([], ['id' => 'ASC']);

        return $this->render('terrain/index.html.twig', [
            'terrains' => $terrains,
        ]);
    }
    public function displaySortedByNomDESC()
    {
        $terrains = $this->getDoctrine()->getRepository(Terrain::class)->findBy([], ['nomTerrain' => 'DESC']);

        return $this->render('terrain/index.html.twig', [
            'terrains' => $terrains,
        ]);
    }

    public function displaySortedBySportDESC()
    {
        $terrains = $this->getDoctrine()->getRepository(Terrain::class)->findBy([], ['id' => 'DESC']);

        return $this->render('terrain/index.html.twig', [
            'terrains' => $terrains,
        ]);
    }

    private function sendNotification(): void
    {
        // Create a notifier
        $notifier = NotifierFactory::create();
    
        // Create a notification
        $notification = (new Notification())
            ->setTitle('Sportify: Terrain ajouté')
            ->setBody('Terrain ajouté avec succès.')
            ->setIcon(__DIR__.'/assets/img/warning.png');

    
        // Send the notification
        $notifier->send($notification);
    }
}
