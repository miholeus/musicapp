<?php
/**
 * This file is part of CoreBundle\Event package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CoreBundle\Event;
/**
 * Event class
 * Main component for event management system
 * It can hold any information about domain
 */
class Event extends \Symfony\Component\EventDispatcher\GenericEvent implements EventInterface
{
    /**
     * Event's name
     *
     * @var string
     */
    protected $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
