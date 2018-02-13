<?php
/**
 * This file is part of CoreBundle\Event\Vote package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CoreBundle\Event\Vote;

class RevokeVoteEvent extends AbstractEvent
{
    protected $name = 'revoke';

    public function getDescription()
    {
        return 'Revoke vote';
    }
}