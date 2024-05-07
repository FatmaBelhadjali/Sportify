<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sport;
use App\Repository\SportRepository;
use Symfony\Component\HttpFoundation\Request;

class SearchFrontController extends AbstractController
{
    #[Route('/search/front', name: 'app_search_front')]
    public function searchUser(Request $request, SportRepository $repository): Response
    {
        $query = $request->request->get('query');
        $sports = $repository->searchByNom($query);
        return $this->render('sportfront/search.html.twig', [
            'sports' => $sports
        ]);
    }
}
