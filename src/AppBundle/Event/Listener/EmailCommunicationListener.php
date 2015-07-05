<?php

namespace AppBundle\Event\Listener;

use AppBundle\Document\Email;
use AppBundle\Event\Communication\Email\EmailEvent;
use AppBundle\Event\Communication\Email\EmailSent;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\ODM\MongoDB\DocumentManager;

class EmailCommunicationListener
{

    /**
     *
     * @var DocumentManager
     */
    private $documentManager;

    public function __construct(ManagerRegistry $registry)
    {
        $this->documentManager = $registry->getManager();
    }

    public function onBeforeSend(EmailEvent $event)
    {
        
    }

    public function onEmailSent(EmailSent $event)
    {
        $message = $event->getMessage();
        $email = new Email();
        $email->setType($event->getType());
        $email->setBody($message->getMessage());
        $email->setEmailAddress($message->getTo());
        $email->setFrom($message->getFrom());
        $email->setSubject($message->getSubject());
        $email->setArguments($event->getArguments());
        $email->setStatus(Email::SATUS_SENT);

        $this->documentManager->persist($email);
        $this->documentManager->flush();
    }

    public function onTemporaryError(EmailEvent $event)
    {
        
    }

    public function onPermanentError(EmailEvent $event)
    {
        
    }

}
