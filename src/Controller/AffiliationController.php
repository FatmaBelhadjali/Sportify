<?php

namespace App\Controller;

use App\Entity\Affiliation;
use App\Form\AffiliationType;
use App\Repository\AffiliationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/affiliation')]
class AffiliationController extends AbstractController
{
    #[Route('/', name: 'app_affiliation_index', methods: ['GET'])]
    public function index(AffiliationRepository $affiliationRepository): Response
    {
        return $this->render('affiliation/index.html.twig', [
            'affiliations' => $affiliationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_affiliation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $affiliation = new Affiliation();
        $form = $this->createForm(AffiliationType::class, $affiliation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($affiliation);
            $entityManager->flush();

            return $this->redirectToRoute('app_affiliation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affiliation/new.html.twig', [
            'affiliation' => $affiliation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_affiliation_show', methods: ['GET'])]
    public function show(Affiliation $affiliation): Response
    {
        return $this->render('affiliation/show.html.twig', [
            'affiliation' => $affiliation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_affiliation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Affiliation $affiliation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AffiliationType::class, $affiliation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_affiliation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affiliation/edit.html.twig', [
            'affiliation' => $affiliation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_affiliation_delete', methods: ['POST'])]
    public function delete(Request $request, Affiliation $affiliation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$affiliation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($affiliation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_affiliation_index', [], Response::HTTP_SEE_OTHER);
    }
}
