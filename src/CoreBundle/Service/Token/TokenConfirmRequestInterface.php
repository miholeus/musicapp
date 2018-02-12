<?php
/**
 * Interface TokenConfirmRequestInterface
 *
 * @package CoreBundle\Service\Token
 */
namespace CoreBundle\Service\Token;

interface TokenConfirmRequestInterface extends TokenRequestInterface
{
    /**
     * Register confirm request (after code was received)
     *
     * @param $token
     * @param array $data (['phone' => '<some phone>', 'code' => '<code received>'])
     * @return mixed
     * @throws InvalidTokenException
     */
    public function makeConfirmRequest($token, array $data);
}
