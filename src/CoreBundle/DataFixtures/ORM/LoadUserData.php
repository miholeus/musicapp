<?php

namespace CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use CoreBundle\Entity\User;

class LoadUserData extends AbstractFixture
    implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setFirstname('Alexander');
        $user->setLastname('Pierce');
        $user->setLogin('demo');
        $user->setEmail('noreply@example.com');
        $user->setRole($this->getReference('role-super_admin'));
        $user->setStatus($this->getReference('status-active'));
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, 'demo');
//        $password = 'demo';

        $user->setPassword($password);
        $user->setIsActive(true);
        $user->setIsSuperuser(true);

        $manager->persist($user);

        $manager->flush();

        $this->addReference('admin-user', $user);
    }

    public function getOrder()
    {
        return 3;
    }
}