<?php
/**
 * This file is part of ApiBundle\Service package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ApiBundle\Service;
/**
 * Options to authenticate user
 */
class AuthenticateOptions implements \ArrayAccess
{
    const AUTH_KEY_TTL = 3600; // 1 hour

    protected $options;

    public function __construct(array $options = array())
    {
        if (empty($options['auth_key_ttl'])) {
            $options['auth_key_ttl'] = self::AUTH_KEY_TTL;
        }
        $this->options = $options;
    }

    public function offsetExists($offset)
    {
        return isset($this->options[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->options[$offset]) ? $this->options[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        $this->options[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->options[$offset]);
    }

    /**
     * Authenticate key ttl
     *
     * @return mixed
     */
    public function getAuthKeyTtl()
    {
        return $this->options['auth_key_ttl'];
    }
}