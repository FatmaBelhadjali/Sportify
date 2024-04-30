<?php

namespace App\Controller;
use Dompdf\Dompdf;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Service\SmsService;
use Dompdf\Options as Options;

#[Route('/produit')]
class ProduitController extends AbstractController
{
    private $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    #[Route('/', name: 'app_produit_index', methods: ['GET'])]
    public function index(Request $request, ProduitRepository $produitRepository): Response
    {
        $filter = $request->query->get('filter');
        $orderBy = $request->query->get('orderBy', 'nom');
    
    // Check if orderBy is 'prix', if so, order by price in descending order
        $orderDirection = 'desc';
        $produits = $produitRepository->findByFilterAndOrder($filter, $orderBy, $orderDirection);
    
    
    return $this->render('produit/index.html.twig', [
        'produits' => $produits,
        'filter' => $filter,
        'orderBy' => $orderBy,
    ]);
    }
    
   

    #[Route('/new', name: 'app_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
               
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    
                }

                $produit->setImage('images/' . $newFilename);
            }

           
            $entityManager->persist($produit);
            $entityManager->flush();


            return $this->redirectToRoute('app_produit_index');
        }

     
        return $this->renderForm('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'app_produit_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_produit_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $produit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/generatePDF', name: 'generatePDFf'    )]
    public function generatePDF(Request $request, ProduitRepository $produitRepository): Response
    {
        $produits = $produitRepository->findAll();
    
    
        $html=$this->renderView('produit/pdf.html.twig', [
            'produits' => $produits
        ]);
    $pdfOptions=new Options();
    $dompdf = new Dompdf($pdfOptions);

    $pdfOptions->set('isRemoteEnabled','true');
    $dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $pdfOutput=$dompdf->output();
    return new Response($pdfOutput,200,[
        'Content-Type'=>'application/pdf',
        'Content-Disposition'=>'attachment; filename="produit.pdf'
    ]);



}
}
