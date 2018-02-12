<?php

namespace ApiBundle\Security;

class BadCredentialsException extends \Symfony\Component\Security\Core\Exception\BadCredentialsException
{
    protected $messageKey;

    public function __construct($message = null)
    {
        if (null === $message) {
            $this->messageKey = parent::getMessageKey();
        } else {
            $this->messageKey = $message;
        }
    }

    public function getMessageKey()
    {
        return $this->messageKey;
    }
}