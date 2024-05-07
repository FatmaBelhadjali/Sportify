<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sponsor;
use App\Form\SponsorType;
use App\Repository\SponsorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Offre;
use App\Form\OffreType;
use App\Repository\OffreRepository;

#[Route('/sponsorfront')]
class SponsorFrontController extends AbstractController
{
    #[Route('/', name: 'app_sponsor_indexfront', methods: ['GET'])]
    public function index(SponsorRepository $sponsorRepository): Response
    {
        return $this->render('SponsorFront/index.html.twig', [
            'sponsors' => $sponsorRepository->findAll(),
        ]);
    }
    
}