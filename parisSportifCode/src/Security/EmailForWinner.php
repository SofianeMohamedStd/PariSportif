<?php


namespace App\Security;


use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class EmailForWinner
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmailToWinner(TemplatedEmail $email)
    {
        $context = $email->getContext();
        $email->context($context);
        $this->mailer->send($email);
    }

}