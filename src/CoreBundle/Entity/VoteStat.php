<?php

namespace CoreBundle\Entity;

/**
 * VoteStat
 */
class VoteStat
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime|null
     */
    private $updatedOn;

    /**
     * @var int
     */
    private $votes;

    /**
     * @var \CoreBundle\Entity\Instrument
     */
    private $instrument;

    public function __construct()
    {
        $this->updatedOn = new \DateTime();
        $this->votes = 0;
    }
    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set updatedOn.
     *
     * @param \DateTime|null $updatedOn
     *
     * @return VoteStat
     */
    public function setUpdatedOn($updatedOn = null)
    {
        $this->updatedOn = $updatedOn;

        return $this;
    }

    /**
     * Get updatedOn.
     *
     * @return \DateTime|null
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * Set votes.
     *
     * @param int $votes
     *
     * @return VoteStat
     */
    public function setVotes($votes)
    {
        $this->votes = $votes;

        return $this;
    }

    /**
     * Get votes.
     *
     * @return int
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * Set instrument.
     *
     * @param \CoreBundle\Entity\Instrument $instrument
     *
     * @return VoteStat
     */
    public function setInstrument(\CoreBundle\Entity\Instrument $instrument)
    {
        $this->instrument = $instrument;

        return $this;
    }

    /**
     * Get instrument.
     *
     * @return \CoreBundle\Entity\Instrument
     */
    public function getInstrument()
    {
        return $this->instrument;
    }

    /**
     * Add votes
     */
    public function increaseVotes()
    {
        $this->votes++;
    }

    /**
     * Revoke votes
     */
    public function decreaseVotes()
    {
        $this->votes--;
    }
}
