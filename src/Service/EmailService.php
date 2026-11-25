<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService
{
    public function __construct(
        private MailerInterface $mailer
    ) {

    }

    public function envoyerEmailBienvenue(string $emailUtilisateur): void 
    {
        $email = (new Email())
            ->from('mediatheque@exemple.com')
            ->to($emailUtilisateur)
            ->subject('Bienvenue dans notre médiathèque !')
            ->text('Bienvenue ! Votre compte a bien été créé.');

            $this->mailer->send($email);
    }
}