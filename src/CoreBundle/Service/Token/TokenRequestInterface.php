<?php
/**
 * Interface TokenRequestInterface
 *
 * @package CoreBundle\Service\Token
 */
namespace CoreBundle\Service\Token;

interface TokenRequestInterface
{
    /**
     * Remembers token and sends registration request
     *
     * @param string $phone phone number to send key
     * @param string $token token saved in storage to identify user's requests
     * @param array $context additional context for request
     * @return string key to register new user
     */
    public function makeRequest($phone, $token, $context = []);
}
