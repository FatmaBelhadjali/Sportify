<?php

namespace App\Controller\frontOffice;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\QRCodeGenerator as ServiceQRCodeGenerator;

class ProduitController extends AbstractController
{
    #[Route('/home/produit', name: 'home_produit')]
    public function index(Request $request, ProduitRepository $produitRepository,ServiceQRCodeGenerator $qrcode): Response
    {
        $qr = [];
        $produits = $produitRepository->findAll();
        foreach($produits as $produit){
            $qr[] = $qrcode->generateQRCode($produit);
        }
        return $this->render('frontOffice/produit/index.html.twig', [
            "produits" => $produits,
            "qr" => $qr
        ]);
        // Use forward slashes in the path instead of backslashes
    }
}