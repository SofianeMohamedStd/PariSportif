<?php

namespace App\Controller;

use App\Entity\DocumentUser;
use App\Entity\User;
use App\Entity\Wallet;
use App\Form\RefisteruserType;
use App\Security\EmailVerification;
use App\Services\DataBaseManager;
use App\Services\EmailService;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegisterController extends AbstractController
{

    private EmailVerification $emailVerification;

    public function __construct(EmailVerification $emailVerification)
    {
        $this->emailVerification = $emailVerification;
    }

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param DataBaseManager $dbManager
     * @param EmailService $emailService
     * @return Response
     * @Route("/register", name="user_registration")
     */
    public function register(Request $request,
                             UserPasswordEncoderInterface $passwordEncoder,
                             DataBaseManager $dbManager,
                             EmailService $emailService): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $user = new User();
        $user->setWallet(new Wallet());
        $user->setDocument(new DocumentUser());

        $form = $this->createForm(RefisteruserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $dbManager->insertDataIntoBase($user);
            $emailService->sendRegisterEmail($user);

            return $this->redirectToRoute('app_login');
        }
        return $this->render(
            'register/index.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     * @param Request $request
     * @param EmailService $emailService
     * @return Response
     */
    public function verifyUserEmail(Request $request, EmailService $emailService): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');


        try {
            $emailService->getEmailVerification()->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('user_registration');
        }

        //TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('index_user');
    }
}
