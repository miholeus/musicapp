<?php
/**
 * Interface TokenInterface
 *
 * @package CoreBundle\Form\Model
 */
namespace CoreBundle\Form\Model;

interface TokenInterface
{
    /**
     * Get token
     *
     * @return mixed
     */
    public function getToken();

    /**
     * Set token
     *
     * @param mixed $token
     * @return mixed
     */
    public function setToken($token);
}