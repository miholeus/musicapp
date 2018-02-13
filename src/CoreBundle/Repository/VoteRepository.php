<?php

namespace CoreBundle\Repository;

use CoreBundle\Entity\Vote;
use CoreBundle\Entity\VoteStat;

/**
 * VoteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VoteRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param Vote $vote
     * @return bool
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function voteExists(Vote $vote)
    {
        $instrument = $vote->getInstrument();
        $user = $vote->getUser();

        $qb = $this->_em->createQueryBuilder();
        $query = $qb->select('v')->from('CoreBundle:Vote', 'v')
            ->where('v.instrument = :genre')
            ->andWhere('v.user = :user')
            ->setParameter('genre', $instrument)
            ->setParameter('user', $user)
            ->getQuery();

        $vote = $query->getOneOrNullResult();

        return null !== $vote;
    }

    /**
     * Finds existing stats or create new one
     *
     * @param Vote $vote
     * @return VoteStat|null|object
     */
    protected function getOrCreateVoteStat(Vote $vote)
    {
        $repo = $this->_em->getRepository('CoreBundle:VoteStat');
        $stat = $repo->findOneBy(['instrument' => $vote->getInstrument()]);
        if (null === $stat) {
            $stat = new VoteStat();
            $stat->setInstrument($vote->getInstrument());
        }

        return $stat;
    }
    /**
     * @param Vote $vote
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addVote(Vote $vote)
    {
        $stat = $this->getOrCreateVoteStat($vote);
        $stat->increaseVotes();

        $this->_em->persist($vote);
        $this->_em->persist($stat);

        $this->_em->flush();
    }

    /**
     * @param Vote $vote
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function revokeVote(Vote $vote)
    {
        $stat = $this->getOrCreateVoteStat($vote);
        if (null !== $stat->getId()) {
            $stat->decreaseVotes();
        }
        $voteCurrent = $this->findOneBy(['instrument' => $vote->getInstrument(), 'user' => $vote->getUser()]);

        $this->_em->remove($voteCurrent);
        $this->_em->persist($stat);

        $this->_em->flush();
    }
}
