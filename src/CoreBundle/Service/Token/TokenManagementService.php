<?php
/**
 * This file is part of CoreBundle\Service\Token package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CoreBundle\Service\Token;

use Symfony\Component\DependencyInjection\ContainerInterface;
use CoreBundle\Form\Model\TokenInterface;

/**
 * Service used to manipulate tokens and send them using message service
 */
abstract class TokenManagementService
{
    const DEFAULT_SMS_CLIENT = 'default';
    /**
     * @var ContainerInterface
     */
    private $container;// request token for registration

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return \CoreBundle\Service\Token\Storage
     */
    public function getTokenStorage()
    {
        return $this->getContainer()->get('core.service.token.storage');
    }

    /**
     * Check if confirmation (session) token is valid
     *
     * @param $token
     * @return array|null
     * @throws ClientException
     */
    public function getSessionToken($token)
    {
        $storage = $this->getTokenStorage();
        $key = $this->getSessionTokenKey($token);

        $result = json_decode($storage->get($key), true);
        return $result;
    }

    /**
     * Validates token saved in storage
     *
     * @param $token
     * @param $code
     * @return bool
     * @throws ClientException
     */
    public function isTokenValid($token, $code)
    {
        $result = $this->getDataByToken($token);

        if (!empty($result) && $result['code'] == $code) {
            return true;
        }
        return false;
    }

    /**
     * Get user's registration data
     *
     * @param $token
     * @return mixed
     * @throws ClientException
     */
    public function getDataByToken($token)
    {
        $storage = $this->getTokenStorage();
        $token = $this->getRequestTokenName($token);

        return json_decode($storage->get($token), true);
    }

    /**
     * Clear registration tokens information
     *
     * @param TokenInterface $tokenInterface
     * @throws ClientException
     */
    public function clear(TokenInterface $tokenInterface)
    {
        $storage = $this->getTokenStorage();
        $key = $this->getSessionTokenName($tokenInterface->getToken());

        $sessionData = $this->getSessionToken($tokenInterface->getToken());
        $storage->delete($key);
        if (!empty($sessionData['token'])) {
            $storage->delete($sessionData['token']);
        }
    }

    /**
     * Support function that returns session token name
     *
     * @param $token
     * @return string
     */
    abstract protected function getSessionTokenName($token);

    /**
     * Returns Request token name
     *
     * @param $token
     * @return mixed
     */
    abstract protected function getRequestTokenName($token);

    /**
     * Token used to identify user requests
     *
     * @param $token
     * @return mixed
     */
    abstract protected function getSessionTokenKey($token);

    /**
     * Generates random string
     *
     * @param int $length
     * @param bool $digitsOnly if set to true then only digits will be returned
     * @return string
     */
    protected function getRandomNumber($length = 6, $digitsOnly = false)
    {
        if (!$digitsOnly) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        } else {
            $characters = '0123456789';
        }
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
