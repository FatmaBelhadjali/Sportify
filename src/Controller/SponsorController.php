<?php

namespace App\Controller;

use App\Entity\Sponsor;
use App\Form\SponsorType;
use App\Repository\SponsorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sponsor')]
class SponsorController extends AbstractController
{
    #[Route('/', name: 'app_sponsor_index', methods: ['GET'])]
    public function index(Request $request, SponsorRepository $sponsorRepository): Response
    {
        $sort = $request->query->get('sort', 'idSponsor');
        $order = $request->query->get('order', 'asc');
        $filter = $request->query->get('filter');
    
        if ($sort === 'evenement') {
            $sort = 'evenement.nom';
        }
    
        // Use repository method to filter by nom if filter is provided
        if ($filter) {
            $sponsors = $sponsorRepository->findByNom($filter, [$sort => $order]);
        } else {
            // Otherwise, retrieve all sponsors
            $sponsors = $sponsorRepository->findBy([], [$sort => $order]);
        }
    
        return $this->render('sponsor/index.html.twig', [
            'sponsors' => $sponsors,
            'currentSort' => $sort,
            'currentOrder' => $order,
        ]);
    }
    
    

    #[Route('/new', name: 'app_sponsor_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sponsor = new Sponsor();
        $form = $this->createForm(SponsorType::class, $sponsor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sponsor);
            $entityManager->flush();

            return $this->redirectToRoute('app_sponsor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sponsor/new.html.twig', [
            'sponsor' => $sponsor,
            'form' => $form,
        ]);
    }

    #[Route('/{idSponsor}', name: 'app_sponsor_show', methods: ['GET'])]
    public function show(Sponsor $sponsor): Response
    {
        return $this->render('sponsor/show.html.twig', [
            'sponsor' => $sponsor,
        ]);
    }

    #[Route('/{idSponsor}/edit', name: 'app_sponsor_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sponsor $sponsor, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SponsorType::class, $sponsor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_sponsor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sponsor/edit.html.twig', [
            'sponsor' => $sponsor,
            'form' => $form,
        ]);
    }

    #[Route('/{idSponsor}', name: 'app_sponsor_delete', methods: ['POST'])]
    public function delete(Request $request, Sponsor $sponsor, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sponsor->getIdSponsor(), $request->request->get('_token'))) {
            $entityManager->remove($sponsor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_sponsor_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/ShowStatistics', name: 'ShowStatistics')]
    public function pieChart(SponsorRepository $eventRepository): Response
    {
        // 1. Extract data from the database
        $eventData = $eventRepository->getEventData();

        // 2. Prepare data for the chart
        $labels = [];
        $data = [];

        // Total count of all events
        $totalEvents = array_sum(array_column($eventData, 'count'));

        // Group the data by event name and calculate percentages based on the count of events for each number of participants
        $groupedEventData = [];
        foreach ($eventData as $event) {
            $name = $event['evenement'];
            $nbrParticipants = $event['nbrParticipants'];
            $count = $event['nbrParticipants'];

            if (!isset($groupedEventData[$name])) {
                $groupedEventData[$name] = [];
            }

            if (!isset($groupedEventData[$name][$nbrParticipants])) {
                $groupedEventData[$name][$nbrParticipants] = 0;
            }

            $groupedEventData[$name][$nbrParticipants] += $count;
        }

        // Calculate percentages and prepare labels and data
        foreach ($groupedEventData as $name => $participantsData) {
            foreach ($participantsData as $nbrParticipants => $count) {
                $labels[] = "$name ($nbrParticipants participants)";
                $percentage = ($count / $totalEvents) * 100;
                $data[] = round($percentage, 2);
            }
        }

        // 3. Render the chart
        return $this->render('dashboard/ShowStatistics.html.twig', [
            'labels' => json_encode($labels),
            'data' => json_encode($data),
        ]);
    }




}
