<?php

namespace CoreBundle\Entity;

/**
 * Instrument
 */
class Instrument
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $photo;

    /**
     * @param array $data
     * @return Instrument
     */
    public static function fromArray(array $data)
    {
        $self = new self();
        foreach ($data as $key => $value) {
            $self->$key = $value;
        }
        return $self;
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
     * Set name.
     *
     * @param string $name
     *
     * @return Instrument
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set photo.
     *
     * @param string|null $photo
     *
     * @return Instrument
     */
    public function setPhoto($photo = null)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo.
     *
     * @return string|null
     */
    public function getPhoto()
    {
        return $this->photo;
    }
}
