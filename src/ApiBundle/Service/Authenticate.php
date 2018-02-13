<?php

namespace ApiBundle\Service;

use ApiBundle\Service\Exception\AuthenticateException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use CoreBundle\Repository\UserRepository;

/**
 * Authenticate service
 */
class Authenticate
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var UserPasswordEncoder
     */
    private $encoder;

    public function __construct(UserRepository $userRepository, UserPasswordEncoder $encoder)
    {
        $this->userRepository = $userRepository;
        $this->encoder = $encoder;
    }

    /**
     * Returns authenticated user
     *
     * @param $login
     * @param $password
     * @return \CoreBundle\Entity\User
     */
    public function authenticate($login, $password)
    {
        if (empty($login) || empty($password)) {
            throw new HttpException(400, 'Bad Request');
        }

        $user = $this->findUserByLogin($login);

        if (!$this->getEncoder()->isPasswordValid($user, $password)) {
            throw new AuthenticateException(401, "Invalid credentials");
        } elseif ($user->getIsBlocked()) {
            throw new AuthenticateException(403, "User is blocked");
        }

        return $user;
    }

    /**
     * @param $login
     * @return \CoreBundle\Entity\User
     */
    public function findUserByLogin($login)
    {
        /** @var \CoreBundle\Entity\User $user */
        $user = $this->getUserRepository()->findOneBy(['login' => $login]);
        if (null === $user) {
            throw new HttpException(404, 'User not found');
        }
        return $user;
    }

    /**
     * @return UserRepository
     */
    public function getUserRepository()
    {
        return $this->userRepository;
    }

    /**
     * @return UserPasswordEncoder
     */
    public function getEncoder()
    {
        return $this->encoder;
    }
}
