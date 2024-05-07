<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sport;
use App\Repository\SportRepository;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_sport_search')]
    public function searchUser(Request $request, SportRepository $repository,  PaginatorInterface $paginator): Response
    {
        $query = $request->request->get('query');
        $sports = $paginator->paginate(
            $repository->searchByNom($query),
            $request->query->getInt('page', 1),
            2
        );
        return $this->render('sport/search.html.twig', [
            'sports' => $sports
        ]);
    } 
}
