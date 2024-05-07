<?php

namespace App\Controller;


use App\Entity\Club;
use App\Repository\ClubRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class SearchClubController extends AbstractController
{
    #[Route('/search', name: 'app_club_search')]
    public function searchUser(Request $request, ClubRepository $repository,PaginatorInterface $paginator): Response
    {
        $query = $request->request->get('query');
        $clubs = $paginator ->paginate(
            $repository->searchByNom($query),
            $request->query->getInt('page', 1),);
        return $this->render('club/_search_results.html.twig', [
            'clubs' => $clubs
        ]);
    }
}
