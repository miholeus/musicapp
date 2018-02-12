<?php
/**
 * Interface EventInterface
 * @package CoreBundle\Event
 */
namespace CoreBundle\Event;
/**
 * Interface for events
 * Each event should have name
 */
interface EventInterface
{
    /**
     * @return string
     */
    public function getName();
}