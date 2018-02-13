<?php
/**
 * This file is part of CoreBundle\Event\Vote package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CoreBundle\Event\Vote;

use Symfony\Component\HttpKernel\Exception\HttpException;

class NotVotedException extends HttpException
{
    public function __construct($message)
    {
        parent::__construct(400, $message);
    }
}