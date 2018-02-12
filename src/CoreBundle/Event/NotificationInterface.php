<?php
/**
 * Interface NotificationInterface
 * @package CoreBundle\Event
 */
namespace CoreBundle\Event;
/**
 * Interface NotificationInterface
 * Main interface for notification system
 */
interface NotificationInterface
{
    /**
     * Notify about triggered event
     *
     * @param $event
     * @return mixed
     */
    public function notify(Event $event);
}