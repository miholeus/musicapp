<?php
/**
 * Interface EventInChainInterface
 * @package CoreBundle\Event
 */
namespace CoreBundle\Event;
/**
 * Interface EventInChainInterface
 * Mainly used for prefixed events.
 * For example, if any event is a part of other events, it should be prefixed with main event
 * for better understanding of domain processes
 */
interface EventInChainInterface extends EventInterface
{
    /**
     * Get prefix for event
     *
     * @return string
     */
    public function getPrefix();
}
