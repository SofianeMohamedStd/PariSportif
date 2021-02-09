<?php


namespace App\Services;


use App\Entity\User;
use App\Security\EmailVerification;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

class EmailService
{
    private EmailVerification $emailVerification;

    public function  __construct(EmailVerification $emailVerification)
    {
        $this->emailVerification = $emailVerification;

    }

    public function sendRegisterEmail(User $user): void
    {
        $this->emailVerification->sendEmailConfirmation(
            'app_verify_email',
            $user,
            (new TemplatedEmail())
                ->from(new Address('equipePari.confirm@pariSportif.com','confirmationEmail'))
                ->to($user->getEmail())
                ->htmlTemplate('register/confirmation_email.html.twig')
                ->subject('Confirm your Email to start betting ')
        );
    }

    public function getEmailVerification(): EmailVerification
    {
        return $this->emailVerification;
    }

}