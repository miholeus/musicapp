<?php

namespace CoreBundle\Event\Vote;

use CoreBundle\Event\EventInChain;

/**
 * Abstract vote event
 * Prefixed with its own namespace
 */
abstract class AbstractEvent extends EventInChain
{
    public function getPrefix()
    {
        return 'vote';
    }
}