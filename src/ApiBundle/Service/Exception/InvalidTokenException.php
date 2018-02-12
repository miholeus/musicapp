<?php
/**
 * This file is part of ApiBundle\Service\Exception package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ApiBundle\Service\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Invalid token
 */
class InvalidTokenException extends HttpException
{

}
