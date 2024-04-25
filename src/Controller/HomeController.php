<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    
    #[Route('/front', name: 'app_front')]
    public function frontend(): Response
    {
        return $this->render('Home/Front.html.twig');
    }

    #[Route('/back', name: 'app_back')]
    public function backend(): Response
    {
        return $this->render('Home/Back.html.twig');
    }
}
