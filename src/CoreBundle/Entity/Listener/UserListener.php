<?php

namespace CoreBundle\Entity\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use CoreBundle\Entity\Exception\ValidatorException;
use CoreBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use CoreBundle\Entity\Traits\ValidatorTrait;

class UserListener
{
    use ValidatorTrait;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * User post load event
     *
     * @param User $user
     * @param LifecycleEventArgs $event
     */
    public function postLoad(User $user, LifecycleEventArgs $event)
    {
        $user->addRole("ROLE_" . $user->getRole()->getName());
    }
    /**
     * @param User $user
     * @param LifecycleEventArgs $event
     * @throws ValidatorException
     */
    public function preUpdate(User $user, LifecycleEventArgs $event)
    {
        $this->validate($user, null, null);

        $uow = $event->getEntityManager()->getUnitOfWork();
        $entityChangeSet = $uow->getEntityChangeSet($user);

        if (trim($user->getPassword()) == '') {
            if (isset($entityChangeSet['password'])) {
                // recover old value
                $user->setPassword($entityChangeSet['password'][0]);
            }
        } else {
            if (!empty($entityChangeSet['password'])) {
                $encoder = $this->getContainer()->get('security.password_encoder');
                $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            }
        }
        $user->setUpdatedOn(new \DateTime());
    }

    public function prePersist(User $user, LifecycleEventArgs $event)
    {
        $this->validate($user, null, null);

        $encoder = $this->getContainer()->get('security.password_encoder');
        $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
    }
}
