<?php

namespace CMS\BlogBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\User\UsertInterface;

class MessagePostEvent extends Event
{
    protected $message;
    protected $user;

    public function __construct($message, UserInterface $user)
    {
        $this->message = $message;
        $this->user = $user;
    }

    // Le listener doit avoir accès au message
    public function getMessage()
    {
        return $this->message;
    }

    // Le listener doit pouvoir modifier le message
    public function setMessage($message)
    {
        return $this->message = $message;
    }

    // Et doit pouvoir accès a l'utilisateur
    public function getUser()
    {
        return $this->user;
    }
}