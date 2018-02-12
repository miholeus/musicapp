<?php

namespace ApiBundle\Service;

use ApiBundle\Service\Exception\InvalidTokenException;
use CoreBundle\Entity\User;
use Ramsey\Uuid\Uuid;
use CoreBundle\Service\Token\Storage;

class ApiKeyProvider
{
    /**
     * Name that is used to store api keys
     */
    const API_KEYS_NAME = 'api:keys';
    const API_TOKEN_NAME = 'api:tokens';

    /**
     * @var Storage
     */
    private $storage;
    /**
     * @var AuthenticateOptions
     */
    private $authenticateOptions;

    /**
     * ApiKeyProvider constructor.
     *
     * @param Storage $storage
     * @param AuthenticateOptions $authenticateOptions
     */
    public function __construct(Storage $storage, AuthenticateOptions $authenticateOptions)
    {
        $this->storage = $storage;
        $this->authenticateOptions = $authenticateOptions;
    }

    /**
     * Authentication Token full name
     *
     * @param $token
     * @return string
     */
    protected function getTokenKey($token)
    {
        return sprintf("%s:%s", self::API_TOKEN_NAME, $token);
    }

    /**
     * Generates user's token
     *
     * @param User $user
     * @return string
     * @throws \CoreBundle\Service\Token\ClientException
     */
    public function generateToken(User $user)
    {
        $token = Uuid::uuid1($user->getId(), time());
        $key = $this->getTokenKey($token);
        $ttl = $this->getAuthenticateOptions()->getAuthKeyTtl();

        /** @var \Predis\Response\Status $result */
        $result = $this->getStorage()->set($key, $user->serialize(), $ttl);
        if($result->getPayload() != 'OK') {
            throw new InvalidTokenException("No API token was generated");
        }

        return $token;
    }

    /**
     * Gets authentication token
     *
     * @param $token
     * @return User
     * @throws \CoreBundle\Service\Token\ClientException
     */
    public function getUserByToken($token)
    {
        $key = $this->getTokenKey($token);
        $result = $this->getStorage()->get($key);
        if (!empty($result)) {
            $user = new User();
            $user->unserialize($result);
            return $user;
        }
        return null;
    }

    /**
     * Deletes token
     *
     * @param string $token
     * @return int
     * @throws \CoreBundle\Service\Token\ClientException
     */
    public function deleteUserToken(string $token)
    {
        $key = $this->getTokenKey($token);
        return $this->getStorage()->delete($key);
    }

    /**
     * Gets api tokens
     *
     * @return array
     * @throws \CoreBundle\Service\Token\ClientException
     */
    public function getTokens()
    {
        $data = [];
        $prefix = self::API_TOKEN_NAME;
        $tokens = $this->getStorage()->keys(sprintf("%s:*", $prefix));
        foreach ($tokens as $token) {
            $data[] = str_replace($prefix . ':', '', $token);
        }
        return $data;
    }

    /**
     * Gets repository for keys
     *
     * @return Storage
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * @return AuthenticateOptions
     */
    public function getAuthenticateOptions()
    {
        return $this->authenticateOptions;
    }

    /**
     * Get api key
     *
     * @param $key
     * @return array|null
     * @throws \CoreBundle\Service\Token\ClientException
     */
    public function getApiKey($key)
    {
        $result = $this->getStorage()->hget(self::API_KEYS_NAME, $key);
        if (!empty($result)) {
            return json_decode($result, true);
        }
        return null;
    }
}