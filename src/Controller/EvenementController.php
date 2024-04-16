<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Participate;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/evenement')]
class EvenementController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/', name: 'app_evenement_index', methods: ['GET'])]
    public function index(EvenementRepository $evenementRepository): Response
    {
        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }

    #[Route('/front', name: 'app_evenement_indexFront', methods: ['GET'])]
    public function indexFront(EvenementRepository $evenementRepository): Response
    {
        $id_user = 1;

        $queryBuilder = $this->entityManager->createQueryBuilder();

        $subQuery = $this->entityManager->createQueryBuilder();
        $subQuery
            ->select('COUNT(t2_sub.id)')
            ->from(Participate::class, 't2_sub')
            ->where('t1.id = t2_sub.id_event_id');

        $subQuery2 = $this->entityManager->createQueryBuilder();
        $subQuery2
            ->select('COUNT(t3_sub)')
            ->from(Participate::class, 't3_sub')
            ->where('t1.id = t3_sub.id_event_id')
            ->andWhere('t3_sub.id_user_id = '.$id_user);

        $query = $queryBuilder
            ->select('t1',  '(' . $subQuery->getDQL() . ') AS total' , '(' . $subQuery2->getDQL() . ') AS isparticipated  ')
            ->from(Evenement::class, 't1')
            ->getQuery();

        $result = $query->getResult();




        return $this->render('evenementFront/index.html.twig', [
            // 'evenements' => $evenementRepository->findAll(),
            'evenements' => $result,
        ]);
    }


    #[Route('/participate/{id}', name: 'app_evenement_participate', methods: ['GET'])]
    public function participate(EvenementRepository $evenementRepositor,$id): Response
    {
        
        $id_user = 1;

        $existingRow = $this->entityManager->getRepository(Participate::class)->findOneBy(['id_user_id' => $id_user,'id_event_id' => $id ]);

        if ($existingRow) {
            return $this->redirectToRoute('app_evenement_indexFront', ['success' => true]);
        }

        $newRow = new Participate(); 
        $newRow->setIdEventId($id);
        $newRow->setIdUserId($id_user);
        $newRow->setVerificationCode(0000);
        $this->entityManager->persist($newRow);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_evenement_indexFront', ['success' => true]);
    }

    #[Route('/cancel/{id}', name: 'app_evenement_cancel', methods: ['GET'])]
    public function cancel(EvenementRepository $evenementRepositor,$id): Response
    {
        
        $id_user = 1;

        $existingRow = $this->entityManager->getRepository(Participate::class)->findOneBy(['id_user_id' => $id_user,'id_event_id' => $id ]);


        $this->entityManager->remove($existingRow);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_evenement_indexFront', ['success' => true]);
    }

    #[Route('/new', name: 'app_evenement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evenement_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evenement_delete', methods: ['POST'])]
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
    }
}
