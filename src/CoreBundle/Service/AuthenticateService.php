<?php
/**
 * This file is part of CoreBundle\Service package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CoreBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\SecurityEvents;
use CoreBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Authenticate user
 */
class AuthenticateService
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Authenticate user
     *
     * @param Request $request
     * @param User $user
     */
    public function authenticate(Request $request, User $user)
    {
        // authenticate user
        $token = new UsernamePasswordToken($user, null, 'db_provider', $user->getRoles());
        $this->getContainer()->get('security.token_storage')->setToken($token);

        // notify all listeners
        $loginEvent = new InteractiveLoginEvent($request, $token);
        $this->getContainer()->get('event_dispatcher')->dispatch(SecurityEvents::INTERACTIVE_LOGIN, $loginEvent);
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }
}