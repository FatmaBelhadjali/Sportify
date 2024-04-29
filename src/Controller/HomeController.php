<?php

namespace App\Controller;

use App\Entity\Utilisateurs;
use App\Form\VerificationCodeType;
use App\Repository\ResetPasswordRequestRepository;
use App\Repository\UtilisateursRepository;
use App\Service\SmsGenerator;
use Doctrine\ORM\EntityManagerInterface;
use League\OAuth2\Client\Provider\Facebook;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\TexterInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class HomeController extends AbstractController
{

    private $provider;
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage, ParameterBagInterface $parameterBag)
    {
        // Assign tokenStorage parameter to the class property
        $this->tokenStorage = $tokenStorage;

        // Assign parameterBag parameter to the class property
        // $this->parameterBag = $parameterBag;


        // Initialize Facebook provider
        $this->provider = new Facebook([
            'clientId' => $_ENV['FCB_ID'],
            'clientSecret' => $_ENV['FCB_SECRET'],
            'redirectUri' => $_ENV['FCB_CALLBACK'],
            'graphApiVersion' => 'v19.0',
        ]);
    }
  
    #[Route('/', name: 'app_front')]
    public function front(): Response
    {
        return $this->render('home/front.html.twig' ,[
            'title' => 'welcome',
        ]);
    }

    #[Route('/LoggedIn', name: 'app_frontLoggedIn')]
    public function frontLoggedIn(): Response
    {
        return $this->render('home/LoggedIn.html.twig' ,[
            'title' => 'welcome',
        ]);
    }

    #[Route('/back', name: 'app_back')]
    public function back(UtilisateursRepository $userRepository, ResetPasswordRequestRepository $resetPasswordRequestRepository): Response
    {
        $usersByRole = $userRepository->countUsersByRole();
        $verificationStatus = $userRepository->countVerificationStatus();
        $resetRequestsByMonth = $resetPasswordRequestRepository->countRequestsByMonth();

        $labels = [];
        $data = [];
        $totalUsers = 0;

        foreach ($usersByRole as $roleData) {
            $totalUsers += $roleData['count'];
        }

        foreach ($usersByRole as $roleData) {
            $role = $roleData['roles'];
            $count = $roleData['count'];
            $labels[] = $role;
            $percentage = ($count / $totalUsers) * 100;
            $data[] = round($percentage, 2);
        }

        $verificationLabels = [];
        $verificationData = [];

        foreach ($verificationStatus as $statusData) {
            $totalUsers += $statusData['count'];
        }

        foreach ($verificationStatus as $statusData) {
            $status = $statusData['verification_status'] ? 'Verified' : 'Unverified';
            $count = $statusData['count'];
            $verificationLabels[] = $status;
            $percentage = ($count / $totalUsers) * 100;
            $verificationData[] = round($percentage, 2);
        }

        $allMonths = [
            'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
        ];
        $resetRequestLabels = [];
        $resetRequestData = [];

        foreach ($allMonths as $month) {
            $resetRequestLabels[] = $month;
            $resetRequestData[] = 0;
        }

        foreach ($resetRequestsByMonth as $requestData) {
            $month = $requestData['month'];
            $count = $requestData['count'];
            $index = (int)$month - 1; // Month index starts from 1
            if ($index >= 0 && $index < count($resetRequestLabels)) {
                $resetRequestData[$index] = $count;
            }
        }

        return $this->render('home/back.html.twig', [
            'labels' => json_encode($labels),
            'data' => json_encode($data),
            'verificationLabels' => json_encode($verificationLabels),
            'verificationData' => json_encode($verificationData),
            'resetRequestLabels' => json_encode($resetRequestLabels),
            'resetRequestData' => json_encode($resetRequestData),
        ]);
    }

    #[Route('/banned', name: 'app_banned')]
    public function banned(): Response
    {
        return $this->render('home/banned.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/fcb-login', name: 'fcb_login')]
    public function fcbLogin(): Response
    {
        $helper_url=$this->provider->getAuthorizationUrl();
        return $this->redirect($helper_url);
    }

    #[Route('/fcb-callback', name: 'fcb_callback')]
    public function fcbCallback(UtilisateursRepository $userDb, EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {
        $token = $this->provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);

        try {
            $user = $this->provider->getResourceOwner($token);
            $user = $user->toArray(); // Convert user object to array

            $pseudo = $user['id'];
            $email = $user['email'];
            $nom = $user['first_name'];
            $prenom = $user['last_name'];
            $pictureUrl = $user['picture_url'];

            // Download the profile picture
            $httpClient = HttpClient::create();
            $response = $httpClient->request('GET', $pictureUrl);
            $content = $response->getContent();

            // Save the profile picture to the directory
            $directory = 'C:\Users\PC\OneDrive\Bureau\XtraTimeSymfony\assets\profilePics';
            $fileName = $pseudo . '.jpg'; // You can adjust the file name if needed
            $filePath = $directory . '/' . $fileName;
            file_put_contents($filePath, $content);

            // Check if the user already exists
            $existingUser = $userDb->findBySearch($pseudo);
            if ($existingUser) {
                // If user exists, set the existing user's token
                $token = new UsernamePasswordToken($existingUser[0], null, 'main', $existingUser[0]->getRoles());
                $this->tokenStorage->setToken($token);
            } else {
                // If user doesn't exist, create a new user
                $newUser = new Utilisateurs();
                $newUser->setPseudo($pseudo)
                    ->setRoles(["Client"])
                    ->setNom($nom)
                    ->setPrenom($prenom)
                    ->setEmail($email)
                    ->setPictureUrl($filePath) // Set the file path here
                    ->setIsVerified(true)
                    ->setPassword(sha1(str_shuffle('abscdop123390hHHH;:::OOOI')));
                $manager->persist($newUser);
                $manager->flush();

                // Set the new user's token
                $token = new UsernamePasswordToken($newUser, null, 'main', $newUser->getRoles());
                $this->tokenStorage->setToken($token);
            }

            return $this->render('home/front.html.twig', [
                'title' => 'welcome',
            ]);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    #[Route('/resetPassword', name: 'reset_password', methods: ['GET'])]
    public function resetPassword(Request $request, SmsGenerator $smsGenerator, SessionInterface $session): Response
    {
        $verificationCode = random_int(100000, 999999);

        $session->set('verification_code', $verificationCode);

        $phoneNumber = '+21629082789';
        $name = 'Sportify User';
        $text = "Hello $name, this is your secret code to reset your password: $verificationCode";

        $smsGenerator->sendSms($phoneNumber, $name, $text);

        return $this->render('home/verify_verification_code.html.twig', [
            'code' => $verificationCode,
        ]);
    }
    #[Route('/verifyVerificationCode', name: 'verify_verification_code')]
    public function verifyVerificationCodeForm(Request $request, SessionInterface $session): Response
    {
        $form = $this->createForm(VerificationCodeType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $submittedCode = $form->get('verify_verification_code')->getData();
            $storedCode = $session->get('verification_code');

            if ($submittedCode == $storedCode) {
                // Redirect to reset password page
                return $this->redirectToRoute('reset_password');
            } else {
                // Display error message
                $error = 'Invalid verification code. Please try again.';
                return $this->render('home/verify_verification_code.html.twig', [
                    'form' => $form->createView(),
                    'error' => $error,
                ]);
            }
        }

        return $this->render('home/verify_verification_code.html.twig', [
            'form' => $form->createView(),
        ]);
    }







}