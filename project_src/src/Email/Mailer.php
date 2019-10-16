<?php


namespace App\Email;


use App\Entity\User;

class Mailer
{
    private $mailer;
    private $twig;

    public function __construct(\Swift_Mailer $mailer, \Twig\Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendConfirmationEmail(User $user)
    {
        $body = $this->twig->render('emails/confirmation.html.twig', [
            'user' => $user,
        ]);

        $message = (new \Swift_Message())
            ->setSubject('Confirm your email!')
            ->setFrom('symfony@study.com')
            ->setTo($user->getEmail())
            ->setBody($body, 'text/html');

        $this->mailer->send($message);
    }
}