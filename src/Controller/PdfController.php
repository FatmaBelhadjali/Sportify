<?php

namespace App\Controller;
use App\Entity\Sport;
use App\Form\SportType;
use App\Repository\SportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

class PdfController extends AbstractController
{
    #[Route('/listS', name: 'generate_sports_pdf')]
    public function pdf(SportRepository $sportRepository): Response
    {
       // Configure Dompdf according to your needs
       $pdfOptions = new Options();
       $pdfOptions->set('defaultFont', 'Open Sans');

       // Instantiate Dompdf with our options
       $dompdf = new Dompdf($pdfOptions);
       // Retrieve the HTML generated in our twig file
       $html = $this->renderView('sport/print.html.twig', [
           'sports' => $sportRepository->findAll(),
       ]);

       // Add header HTML to $html variable
       $headerHtml = '<h1 style="text-align: center; color: #b00707;">Liste des sports</h1>';
       $html = $headerHtml . $html;

       // Load HTML to Dompdf
       $dompdf->loadHtml($html);
       // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
       $dompdf->setPaper('A3', 'portrait');

       // Render the HTML as PDF
       $dompdf->render();
       
       // Output the generated PDF to Browser (inline view)
       return new Response($dompdf->output(), Response::HTTP_OK, [
           'Content-Type' => 'application/pdf',
       ]);
    }
}
