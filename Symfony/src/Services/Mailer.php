<?php

namespace App\Services;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class Mailer
{
    public function __construct(
        protected MailerInterface $mailer
    ) {
    }

    public function sendWelcomeMail(User $user)
    {
        $email = (new TemplatedEmail())
            ->from(new Address('noreply@symfony.skillbox', 'Spill-Coffee-On-The-Keyboard'))
            ->to(new Address($user->getEmail(), $user->getFirstName()))
            ->subject('Добро пожаловать')
            ->htmlTemplate("email/welcome.html.twig")
        ;

        $this->mailer->send($email);
    }

    public function sendWeekNewsletter(
        User $user,
        array $articles
    ): void {
        $email =  (new TemplatedEmail())
            ->from(new Address('noreply@symfony.skillbox', 'Spill-Coffee-On-The-Keyboard'))
            ->to(new Address($user->getEmail(), $user->getFirstName()))
            ->subject('Еженедельная рассылка')
            ->htmlTemplate('email/newsletter.html.twig')
            ->context([
                'articles' => $articles
            ])
        ;

        $this->mailer->send($email);
    }
}