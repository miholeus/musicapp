<?php

namespace ApiBundle\Service\Transformer;

/**
 * Manager that initializes scope manager
 */
class Manager
{
    public function __construct(ScopeManager $manager)
    {
        $this->manager = $manager;
    }
    /**
     * @var ScopeManager
     */
    protected $manager;

    /**
     * @return ScopeManager
     */
    public function getManager()
    {
        return $this->manager;
    }
}