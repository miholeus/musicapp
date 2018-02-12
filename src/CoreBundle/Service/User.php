<?php
/**
 * This file is part of CoreBundle\Service package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CoreBundle\Service;

use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use CoreBundle\Entity\User as EntityUser;
use CoreBundle\Entity\UserStatus;

/**
 * Service for managing users
 */
class User extends UserAwareService
{
    /**
     * @var UserPasswordEncoder
     */
    protected $passwordEncoder;

    /**
     * @param EntityUser $user
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(EntityUser $user)
    {
        $em = $this->getEntityManager();

        $em->persist($user);
        $em->flush();
    }

    /**
     * Check user password
     *
     * @param EntityUser $user
     * @param $password
     * @return bool
     */
    public function isPasswordValid(EntityUser $user, $password)
    {
        if (!$this->getPasswordEncoder()->isPasswordValid($user, $password)) {
            return false;
        }
        return true;
    }

    /**
     * @return UserPasswordEncoder
     */
    public function getPasswordEncoder()
    {
        return $this->passwordEncoder;
    }

    /**
     * @param UserPasswordEncoder $passwordEncoder
     */
    public function setPasswordEncoder(UserPasswordEncoder $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Найти пользователя по email
     *
     * @param $email
     * @return null|EntityUser
     */
    public function findByEmail($email)
    {
        return $this->getEntityManager()
            ->getRepository(EntityUser::class)
            ->findOneBy(['email' => $email]);
    }

    /**
     * Change user's password
     *
     * @param EntityUser $user
     * @param $password
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function changePassword(EntityUser $user, $password)
    {
        $user->setPassword($password);
        $this->save($user);
    }


    /**
     * Find User by id
     *
     * @param $userId
     * @return null|EntityUser
     */
    public function findById($userId)
    {
        return $this->getRepository()->find($userId);
    }

    /**
     * Finds user by login
     *
     * @param string $login
     * @return null|EntityUser
     * @throws EntityNotFoundException
     */
    public function findByLogin(string $login)
    {
        $user =  $this->getRepository()->findOneBy(['login' => $login]);
        if (null === $user) {
            throw new EntityNotFoundException(sprintf("User was not found by login %s", $login));
        }
        return $user;
    }

    private function getRepository()
    {
        return $this->getEntityManager()->getRepository(EntityUser::class);
    }

    /**
     * Update's user last login time
     *
     * @param EntityUser $user
     * @param \DateTime|null $dateTime
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateLastLoginTime(EntityUser $user, \DateTime $dateTime = null)
    {
        $user->setLastLoginOn($dateTime ? $dateTime : new \DateTime());
        $this->getEntityManager()->flush($user);
    }

    /**
     * Blocks user
     *
     * @param EntityUser $user
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function block(EntityUser $user)
    {
        $status = $this->getUserStatus(UserStatus::STATUS_BLOCKED);

        $user->setStatus($status);
        $user->setIsBlocked(true);

        $this->save($user);
    }

    /**
     * @param $code
     * @return null|object|UserStatus
     */
    protected function getUserStatus($code)
    {
        $em = $this->getEntityManager();
        $status = $em->getRepository('CoreBundle:UserStatus')->findOneBy(['code' => $code]);
        return $status;
    }

    /**
     * Unblocks user
     *
     * @param EntityUser $user
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function unblock(EntityUser $user)
    {
        if (!$user->getIsBlocked()) {
            throw new \RuntimeException('User is not blocked');
        }

        $status = $this->getUserStatus(UserStatus::STATUS_ACTIVE);
        $user->setStatus($status);
        $user->setIsBlocked(false);

        $this->save($user);
    }
}
