<?php

namespace App\Controller;

use App\Entity\Sport;
use App\Entity\Terrain;
use App\Form\SportType;
use App\Repository\SportRepository;
use App\Repository\TerrainRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\HttpFoundation\JsonResponse;




#[Route('/sportfront')]
class SportFrontController extends AbstractController
{
    #[Route('/', name: 'app_sport_indexfront', methods: ['GET'])]
    public function index(SportRepository $sportRepository): Response
    {
        return $this->render('sportfront/index.html.twig', [
            'sports' => $sportRepository->findAll(),
        ]);
    }
    
#[Route('/{id}', name: 'app_sport_showfront', methods: ['GET'])]
public function show(Request $request, Sport $sport, TerrainRepository $terrainRepository): Response
{
    // Récupérer l'ID du sport à partir de la requête
    $sportId = $request->get('id');

    // Récupérer le sport correspondant à partir de la base de données
    $sport = $this->getDoctrine()->getRepository(Sport::class)->find($sportId);

    if (!$sport) {
        throw $this->createNotFoundException('Sport non trouvé avec l\'ID : '.$sportId);
    }

    // Récupérer les terrains associés à ce sport
    $terrains = $terrainRepository->findBy(['sport' => $sport]);

    // Rendre le template avec les terrains associés à ce sport
    return $this->render('sportfront/showfront.html.twig', [
        'sport' => $sport,
        'terrains' => $terrains,
    ]);
}
/*#[Route('/search', name: 'app_sport_search', methods: ['GET'])]
public function search(Request $request, SportRepository $sportRepository)
{
    // Récupérer le terme de recherche à partir de la requête
    $keyword = $request->query->get('q');

    // Effectuer la recherche dans le repository SportRepository
    $results = $sportRepository->findByKeyword($keyword);

    // Rendre le template avec les résultats de la recherche
    return $this->render('sportfront/search.html.twig', [
        'results' => $results,
        'keyword' => $keyword,
    ]);
}*/

/*#[Route('/search', name: 'app_sport_search')]
    public function searchUser(Request $request, SportRepository $repository): Response
    {
        $query = $request->request->get('query');
        $sports = $repository->searchByNom($query);
        return $this->render('sportfront/search.html.twig', [
            'sports' => $sports
        ]);
    } */
}
