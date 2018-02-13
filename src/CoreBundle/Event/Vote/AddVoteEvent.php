<?php
/**
 * This file is part of CoreBundle\Event\Vote package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CoreBundle\Event\Vote;

class AddVoteEvent extends AbstractEvent
{
    protected $name = 'add';

    public function getDescription()
    {
        return 'Add new vote';
    }
}