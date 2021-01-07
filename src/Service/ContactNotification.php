<?php 
namespace App\Service;

use App\Entity\Contact;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class ContactNotification {

    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function notify(Contact $contact){
        $message = (new TemplatedEmail())
        ->From($contact->getEmail())
        ->to('contact@agence.fr')
        ->subject("Demande concernant le bien " .$contact->getProperty()->getTitle())
        ->htmlTemplate('emails/contact.html.twig')
        ->context([
            'contact' => $contact
        ]);
        $this->mailer->send($message);
    }
}