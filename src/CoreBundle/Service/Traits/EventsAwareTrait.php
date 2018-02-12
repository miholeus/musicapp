<?php
/**
 * Trait EventsAwareTrait
 * @package CoreBundle\Service\Traits
 */
namespace CoreBundle\Service\Traits;

use CoreBundle\Event\Event;
use CoreBundle\Event\NotificationInterface;

/**
 * Awareness of events
 */
trait EventsAwareTrait
{
    /**
     * @var NotificationInterface
     */
    protected $notificationManager;

    /**
     * Pending events
     *
     * @var Event[]
     */
    protected $pendingEvents = [];

    /**
     * @return NotificationInterface
     */
    public function getNotificationManager()
    {
        return $this->notificationManager;
    }

    /**
     * Notify events
     */
    protected function updateEvents()
    {
        $events = $this->pendingEvents;
        foreach ($events as $event) {
            $this->getNotificationManager()->notify($event);
        }
        $this->pendingEvents = [];
    }

    public function attachEvent(Event $event)
    {
        $this->pendingEvents[] = $event;
    }
}
