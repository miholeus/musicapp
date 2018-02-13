<?php
/**
 * This file is part of ApiBundle\Service package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiBundle\Service;

use CoreBundle\Entity\Vote;
use CoreBundle\Event\NotificationManager;
use CoreBundle\Event\Vote\AddVoteEvent;
use CoreBundle\Event\Vote\RevokeVoteEvent;
use CoreBundle\Service\Traits\EventsAwareTrait;

class VoteService
{
    use EventsAwareTrait;

    public function __construct(NotificationManager $manager)
    {
        $this->notificationManager = $manager;
    }

    /**
     * Add new vote
     *
     * @param Vote $vote
     */
    public function addVote(Vote $vote)
    {
        $event = new AddVoteEvent($vote);
        $this->attachEvent($event);

        $this->updateEvents();
    }

    /**
     * Revoke current vote
     *
     * @param Vote $vote
     */
    public function revokeVote(Vote $vote)
    {
        $event = new RevokeVoteEvent($vote);
        $this->attachEvent($event);

        $this->updateEvents();
    }
}