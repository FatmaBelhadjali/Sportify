<?php

namespace App\Controller;

use App\Entity\Club;
use App\Form\ClubType;
use App\Repository\ClubRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Knp\Component\Pager\PaginatorInterface;
use Dompdf\Dompdf;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Controller\Weather;









#[Route('/club')]
class ClubController extends AbstractController
{

    

    #[Route('/search/ajax', name: 'club_search_ajax', methods: ['GET'])]
    public function searchAjax(Request $request, ClubRepository $clubRepository): Response
    {
        $query = $request->query->get('query');
        $results = $clubRepository->searchByName($query);

        return $this->render('club/_search_results.html.twig', [
            'results' => $results,
        ]);
    }

    
    #[Route('/club/excel', name: 'app_club_generate_excel')]
public function generateExcel(ClubRepository $clubRepository): Response
{
    // Récupérez les données des clubs depuis le repository
    $clubs = $clubRepository->findAll();

    // Créez une nouvelle instance de la classe Spreadsheet
    $spreadsheet = new Spreadsheet();

    // Écrivez du contenu dans le fichier Excel
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'Nom du club');
    $sheet->setCellValue('B1', 'Catégorie');
    // Ajoutez d'autres colonnes selon vos besoins

    // Exemple de remplissage des données
    $row = 2;
    foreach ($clubs as $club) {
        $sheet->setCellValue('A'.$row, $club->getNomclub());
        $sheet->setCellValue('B'.$row, $club->getCategorie());
        // Ajoutez d'autres colonnes ici

        $row++;
    }

    // Créez un objet Writer pour sauvegarder le fichier Excel
    $writer = new Xlsx($spreadsheet);

    // Définissez le nom du fichier Excel à télécharger
    $excelFileName = 'liste_clubs.xlsx';

    // Créez une réponse avec le contenu du fichier Excel
    $response = new Response();
    $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    $response->headers->set('Content-Disposition', 'attachment;filename="'.$excelFileName.'"');
    $response->headers->set('Cache-Control', 'max-age=0');

    // Envoyez le contenu du fichier Excel au navigateur
    $writer->save('php://output');

    return $response;
}

    public function generatePdf(ClubRepository $clubRepository): Response
{
    // Récupérez la liste des clubs depuis le repository
    $clubs = $clubRepository->findAll();

    // Créez une instance de Dompdf
    $dompdf = new Dompdf();

    // Générez le contenu HTML pour le PDF
    $htmlContent = $this->renderView('club/pdf.html.twig', [
        'clubs' => $clubs,
    ]);

    // Chargez le contenu HTML dans Dompdf
    $dompdf->loadHtml($htmlContent);

    // Réglez les options de Dompdf si nécessaire
    $dompdf->setPaper('A4', 'portrait');

    // Rendu du PDF
    $dompdf->render();

    // Obtenez le contenu PDF généré
    $pdfContent = $dompdf->output();

    // Créez une réponse Symfony pour retourner le PDF au navigateur
    $response = new Response($pdfContent);
    $response->headers->set('Content-Type', 'application/pdf');

    // Facultatif : téléchargement du PDF au lieu de l'afficher dans le navigateur
    // $response->headers->set('Content-Disposition', 'attachment; filename="liste_clubs.pdf"');

    return $response;
}



    public function uploadLogo(UploadedFile $file)
{
    $filename = uniqid().'.'.$file->guessExtension();
    $path = 'http://127.0.0.1/img/'.$filename; // Chemin complet pour l'image

    try {
        $file->move($this->getParameter('images_directory'), $filename);
    } catch (FileException $e) {
        // Gérer les erreurs de téléchargement ici
    }

    return $path; // Retourne le chemin complet pour l'enregistrement dans l'entité Club
}




    #[Route('/', name: 'app_club_index', methods: ['GET'])]
    public function index(ClubRepository $clubRepository, PaginatorInterface $paginator, Request $request): Response
{

    $clubs = $clubRepository->findAllSortedByPrice();

    //$query = $clubRepository->findAll(); // Assuming you have a custom query method in ClubRepository

    $clubs = $paginator->paginate(
        $clubs,
        $request->query->getInt('page', 1), // Get the current page number from the request, default to 1
        6 // Number of items per page
    );

    return $this->render('club/index.html.twig', [
        'clubs' => $clubs, // Passage des clubs au template Twig
        
    ]);
}



    #[Route('/new', name: 'app_club_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $club = new Club();
    $form = $this->createForm(ClubType::class, $club);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Gestion du téléchargement de fichier
        $logoFile = $form->get('logo')->getData();
        if ($logoFile) {
            $logoFileName = $this->uploadLogo($logoFile);
            // Enregistrer $logoFileName dans votre entité Club ou où nécessaire
            $club->setLogo($logoFileName);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($club);
        $entityManager->flush();

        return $this->redirectToRoute('app_club_index');
    }

    return $this->renderForm('club/new.html.twig', [
        'club' => $club,
        'form' => $form,
    ]);
}


    #[Route('/{id}', name: 'app_club_show', methods: ['GET'])]

    public function show(Club $club): Response
    {
        return $this->render('club/show.html.twig', [
            'club' => $club,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_club_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Club $club, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClubType::class, $club);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_club_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('club/edit.html.twig', [
            'club' => $club,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_club_delete', methods: ['POST'])]
    public function delete(Request $request, Club $club, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$club->getId(), $request->request->get('_token'))) {
            $entityManager->remove($club);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_club_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/sort-by-name', name: 'sort_clubs_by_name')]
public function sortClubsByName(ClubRepository $clubRepository): JsonResponse
{
    $clubs = $clubRepository->findBy([], ['nomclub' => 'ASC']); // Trie les clubs par nom en ordre croissant

    $formattedClubs = [];
    foreach ($clubs as $club) {
        $formattedClubs[] = [
            'id' => $club->getId(),
            'nomclub' => $club->getNomclub(),
            'categorie' => $club->getCategorie(),
            // Ajoutez d'autres attributs si nécessaire
        ];
    }

    return new JsonResponse($formattedClubs);
}

    
}
