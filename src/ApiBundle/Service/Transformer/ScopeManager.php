<?php

namespace ApiBundle\Service\Transformer;

use League\Fractal\Resource\ResourceInterface;
use League\Fractal\Scope;

/**
 * This manager handles interaction with different scopes
 */
class ScopeManager extends \League\Fractal\Manager
{
    /**
     * @var string
     */
    protected $scopeClass;

    /**
     * string
     */
    public function getScopeClass()
    {
        if (null === $this->scopeClass) {
            $this->scopeClass = '\\League\\Fractal\\Scope';
        }
        return $this->scopeClass;
    }

    /**
     * @param string $class
     */
    public function setScopeClass($class)
    {
        $this->scopeClass = $class;
    }

    /**
     * @param ResourceInterface $resource
     * @param null $scopeIdentifier
     * @param Scope|null $parentScopeInstance
     * @return Scope
     */
    public function createData(ResourceInterface $resource, $scopeIdentifier = null, Scope $parentScopeInstance = null)
    {
        $class = $this->getScopeClass();

        /** @var Scope $scopeInstance */
        $scopeInstance = new $class($this, $resource, $scopeIdentifier);

        // Update scope history
        if ($parentScopeInstance !== null) {
            // This will be the new children list of parents (parents parents, plus the parent)
            $scopeArray = $parentScopeInstance->getParentScopes();
            $scopeArray[] = $parentScopeInstance->getScopeIdentifier();

            $scopeInstance->setParentScopes($scopeArray);
        }
        return $scopeInstance;
    }
}