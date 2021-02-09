<?php


namespace App\Security;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class EmailVerification
{
    private VerifyEmailHelperInterface $verifyEmailHelper;
    private MailerInterface $mailer;
    private EntityManagerInterface $entityManager;

    public function __construct(
        VerifyEmailHelperInterface $helper,
        MailerInterface $mailer,
        EntityManagerInterface $manager
    ) {
        $this->verifyEmailHelper = $helper;
        $this->mailer = $mailer;
        $this->entityManager = $manager;
    }

    public function sendEmailConfirmation(string $verifyEmailRouteName, UserInterface $user,
                                          TemplatedEmail $email): void
    {
        assert($user instanceof User);
        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            $verifyEmailRouteName,
            (string)$user->getId(),
            $user->getEmail()
        );

        $context = $email->getContext();
        $context['signedUrl'] = $signatureComponents->getSignedUrl();
        $context['expiresAt'] = $signatureComponents->getExpiresAt();

        $email->context($context);

        $this->mailer->send($email);
    }

    public function handleEmailConfirmation(Request $request, UserInterface $user):void
    {
        assert($user instanceof User);
        try {
            $this->verifyEmailHelper->validateEmailConfirmation(
                $request->getUri(),
                (string)$user->getId(),
                $user->getEmail()
            );
        } catch (VerifyEmailExceptionInterface $e) {
        }

        $user->setUserVerified();

        $this->entityManager->persist($user);
        $this->entityManager->flush();

    }

}