<?php 
// src/Controller/FrontController.php

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


class FrontController extends AbstractController
{
    #[Route('/front', name: 'front_static')]
    public function staticPage(SponsorRepository $sponsorRepository, OffreRepository $offreRepository): Response
    {
        $sponsors = $sponsorRepository->findAll();
        $offres = $offreRepository->findAll();

    
        return $this->render('front/match.html.twig', [
            'sponsors' => $sponsors,
            'offres' => $offres,

        ]);
    }
    
}
