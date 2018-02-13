<?php
/**
 * This file is part of CoreBundle\Event\Listener package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CoreBundle\Event\Listener;

use CoreBundle\Entity\Vote;
use CoreBundle\Event\Vote\AddVoteEvent;
use CoreBundle\Event\Vote\AlreadyVotedException;
use CoreBundle\Event\Vote\NotVotedException;
use CoreBundle\Event\Vote\RevokeVoteEvent;
use CoreBundle\Repository\VoteRepository;

class VoteListener
{
    /**
     * @var VoteRepository
     */
    private $repository;

    public function __construct(VoteRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param AddVoteEvent $event
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function onAddVoteEvent(AddVoteEvent $event)
    {
        /** @var Vote $vote */
        $vote = $event->getSubject();

        if ($this->getRepository()->voteExists($vote)) {
            throw new AlreadyVotedException("You have already voted");
        }

        $this->getRepository()->addVote($vote);
    }

    /**
     * @param RevokeVoteEvent $event
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function onRevokeVoteEvent(RevokeVoteEvent $event)
    {
        /** @var Vote $vote */
        $vote = $event->getSubject();

        if (!$this->getRepository()->voteExists($vote)) {
            throw new NotVotedException("You haven't voted yet");
        }

        $this->getRepository()->revokeVote($vote);
    }

    /**
     * @return VoteRepository
     */
    public function getRepository(): VoteRepository
    {
        return $this->repository;
    }
}