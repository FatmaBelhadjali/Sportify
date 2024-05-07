<?php

namespace App\Controller;

use App\Entity\Club;
use App\Form\ClubType;
use App\Repository\ClubRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Knp\Component\Pager\PaginatorInterface;
use Dompdf\Dompdf;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Controller\Weather;

#[Route('/clubfront')]
class ClubFrontController extends AbstractController
{
    #[Route('/', name: 'app_club_indexfront', methods: ['GET'])]
    public function index(ClubRepository $clubRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $clubs = $paginator->paginate(
            $clubs=$clubRepository->findAll(),
            $page=$request->query->getInt('page', 1), // Get the current page number from the request, default to 1
            3 // Number of items per page
        );
        return $this->render('Front_Office/index.html.twig', [
            'clubs' => $clubs,
        ]);
        
        
    }
    
}