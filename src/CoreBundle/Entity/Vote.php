<?php

namespace CoreBundle\Entity;

/**
 * Vote
 */
class Vote
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime|null
     */
    private $createdOn;

    /**
     * @var \CoreBundle\Entity\User
     */
    private $user;

    /**
     * @var \CoreBundle\Entity\Instrument
     */
    private $instrument;


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
     * Set createdOn.
     *
     * @param \DateTime|null $createdOn
     *
     * @return Vote
     */
    public function setCreatedOn($createdOn = null)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get createdOn.
     *
     * @return \DateTime|null
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set user.
     *
     * @param \CoreBundle\Entity\User $user
     *
     * @return Vote
     */
    public function setUser(\CoreBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \CoreBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set instrument.
     *
     * @param \CoreBundle\Entity\Instrument $instrument
     *
     * @return Vote
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
}
