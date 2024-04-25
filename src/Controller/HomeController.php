<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/home')]
class HomeController extends AbstractController
{
    #[Route('/front', name: 'app_home_front')]
    public function front(): Response
    {
        return $this->render('Home/Front.html.twig');
    }

    #[Route('/back', name: 'app_home_back')]
    public function back(): Response
    {
        return $this->render('Home/Back.html.twig');
    }
}
