<?php

namespace CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use CoreBundle\Entity\UserRole;

class LoadUserRoleData extends AbstractFixture
    implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 2;
    }

    public function load(ObjectManager $manager)
    {
        $data = [
            UserRole::ROLE_USER => 'User',
            UserRole::ROLE_ADMIN => 'Administrator',
            UserRole::ROLE_SUPER_ADMIN => 'A God'
        ];
        $roleAdmin = null;
        $roleUser = null;

        foreach ($data as $code => $name) {
            $role = new UserRole();
            $role->setName($code);
            $role->setTitle($name);
            if ($code == UserRole::ROLE_SUPER_ADMIN) {
                $roleAdmin = $role;
            } elseif ($code == UserRole::ROLE_USER) {
                $roleUser = $role;
            }

            $manager->persist($role);
        }

        $manager->flush();

        $this->addReference('role-super_admin', $roleAdmin);
        $this->addReference('role-user', $roleUser);
    }
}