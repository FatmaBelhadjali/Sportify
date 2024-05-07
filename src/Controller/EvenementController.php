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
use Knp\Component\Pager\PaginatorInterface;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Attachment;




#[Route('/evenement')]
class EvenementController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    // #[Route('/', name: 'app_evenement_index', methods: ['GET'])]
    // public function index(EvenementRepository $evenementRepository): Response
    // {
    //     return $this->render('evenement/index.html.twig', [
    //         'evenements' => $evenementRepository->findAll(),
    //     ]);
    // }
    #[Route('/', name: 'app_evenement_index', methods: ['GET'])]
    public function index(Request $request, EvenementRepository $evenementRepository, PaginatorInterface $paginator): Response
    {
        $queryBuilder = $evenementRepository->createQueryBuilder('e')
            ->orderBy('e.id', 'DESC');
        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            1
        );
        return $this->render('evenement/index.html.twig', [
            'evenements' => $pagination
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
            ->andWhere('t3_sub.id_user_id = ' . $id_user);

        $query = $queryBuilder
            ->select('t1',  '(' . $subQuery->getDQL() . ') AS total', '(' . $subQuery2->getDQL() . ') AS isparticipated  ')
            ->from(Evenement::class, 't1')
            ->getQuery();

        $result = $query->getResult();




        return $this->render('evenementFront/index.html.twig', [
            // 'evenements' => $evenementRepository->findAll(),
            'evenements' => $result,
        ]);
    }


    #[Route('/participate/{id}', name: 'app_evenement_participate', methods: ['GET'])]
    public function participate(EvenementRepository $evenementRepositor, $id, MailerInterface $mailer): Response
    {

        $id_user = 1;

        $existingRow = $this->entityManager->getRepository(Participate::class)->findOneBy(['id_user_id' => $id_user, 'id_event_id' => $id]);

        if ($existingRow) {
            return $this->redirectToRoute('app_evenement_indexFront', ['success' => true]);
        }

        $newRow = new Participate();
        $newRow->setIdEventId($id);
        $newRow->setIdUserId($id_user);
        $newRow->setVerificationCode(0000);
        $this->entityManager->persist($newRow);
        $this->entityManager->flush();
        $this->sendEventParticipationEmail($mailer, $id_user, 'ahmedhachicha712@gmail.com');
        return $this->redirectToRoute('app_evenement_indexFront', ['success' => true]);
    }

    #[Route('/cancel/{id}', name: 'app_evenement_cancel', methods: ['GET'])]
    public function cancel(EvenementRepository $evenementRepositor, $id): Response
    {

        $id_user = 1;

        $existingRow = $this->entityManager->getRepository(Participate::class)->findOneBy(['id_user_id' => $id_user, 'id_event_id' => $id]);


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
//hhhhhhh
    #[Route('/{id}', name: 'app_evenement_delete', methods: ['POST'])]
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $evenement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
    }



    public function sendEventParticipationEmail(MailerInterface $mailer, string $content, string $recipientEmail)
    {
      

        $qrCode = new QrCode($content);
        $writer = new PngWriter();
        $qrCodeImageContent = $writer->write($qrCode)->getString();

        // Create the HTML body
        $htmlContent = '<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; color: #333; }
        .container { padding: 20px; background-color: #f7f7f7; }
        .header { background-color: #007bff; padding: 10px; color: white; text-align: center; }
        .content { margin-top: 20px; text-align: center; }
        .footer { margin-top: 20px; text-align: center; padding: 10px; font-size: 12px; color: #666; }
        .qr-code { margin-top: 20px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Event Participation Confirmation</h1>
        </div>
        <div class="content">
            <p>Thank you for registering to participate in our event. Below is your QR code which you will need to present at the entrance.</p>
        </div>
        <div class="qr-code">
            <img src="cid:qr-code">
        </div>
        <div class="footer">
            <p>If you have any questions, please do not hesitate to contact us at support@example.com.</p>
        </div>
    </div>
    <img src="cid:qr-code">
</body>
</html>';

        // Create email with embedded image
        $email = (new Email())
            ->from('kammoun.nour24@gmail.com')
            ->to($recipientEmail)
            ->subject('Event Participation Confirmation')
            ->html($htmlContent)
            ->embed($qrCodeImageContent, 'qr-code', 'image/png');

            // ->attach($qrCodeImage);

        // Send the email
        $mailer->send($email);


        return new Response('Email sent with embedded QR Code.');
    }
}
