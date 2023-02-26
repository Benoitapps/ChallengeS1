<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\AppCustomAuthenticator;
use App\Security\EmailVerifier;
use App\Service\EmailService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use SendinBlue\Client\Model\SendSmtpEmail;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use SendinBlue;
use GuzzleHttp;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, VerifyEmailHelperInterface $verifyEmailHelper, UserAuthenticatorInterface $userAuthenticator, AppCustomAuthenticator $authenticator, EntityManagerInterface $entityManager, EmailService $emailService): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            $signatureComponents = $verifyEmailHelper->generateSignature(
                'app_verify_email',
                $user->getId(),
                $user->getEmail(),
                ['id' => $user->getId()]
            );

            $userEmail = $user->getEmail();
            $templateId = 1; //TemplateId = 1 pour register
            $params = array('name'=>'BECLAL', 'USER'=>$user->getEmail(), 'URL'=>$signatureComponents->getSignedUrl());
            try {
                $emailService->sendTransactionalEmail($userEmail, $templateId, $params);
                $this->addFlash('success', 'Un e-mail de confirmation a été envoyé à l\'adresse e-mail ' . $userEmail);
            } catch (Exception $e) {
                $this->addFlash('error', 'Une erreur est survenue lors de l\'envoi de l\'e-mail de confirmation : ' . $e->getMessage());
            }

            return $this->redirectToRoute('app_default');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, VerifyEmailHelperInterface $verifyEmailHelper, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->find($request->query->get('id'));
        if (!$user) {
            throw $this->createNotFoundException();
        }

        try {
            $verifyEmailHelper->validateEmailConfirmation(
                $request->getUri(),
                $user->getId(),
                $user->getEmail(),
            );
        } catch (VerifyEmailExceptionInterface $e) {
            $this->addFlash('error', $e->getReason());
            return $this->redirectToRoute('app_default'); //redirection à mettre vers register si fail
        }

        $user->setIsVerified(true);
        $user->setRoles(["ROLE_CUSTOMER"]);
        $entityManager->flush();

        $this->addFlash('success', 'Compte vérifié ! Vous pouvez maintenant vous connecter.');
        return $this->redirectToRoute('app_default');
    }

    #[Route('/verify/resendemail', name: 'app_verify_resend_email')]
    public function resendVerifyEmail()
    {
        return $this->render('registration/resend_verify_email.html.twig', [
            'controller_name' => 'RegistrationController',
        ]);
    }
}
