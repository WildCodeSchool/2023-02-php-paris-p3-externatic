<?php

namespace App\Service;

use App\Entity\Application;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;



class MailSending
{
    private $mailer;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMessage(Application $application, string $sender, string $render)
    {
        $email = (new Email())
            ->from($sender)
            ->to($application->getCandidate()->getUser()->getLogin())
            ->cc($application->getOffer()->getCompany()->getUser()->getLogin())
            ->subject('you have received a reply to your application for offer ' . $application->getId())
            ->html($render);

        $this->mailer->send($email);
    }
}