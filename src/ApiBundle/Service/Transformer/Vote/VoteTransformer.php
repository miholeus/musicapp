<?php
/**
 * This file is part of ApiBundle\Service\Transformer\Vote package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiBundle\Service\Transformer\Vote;

use ApiBundle\Service\Transformer\TransformerAbstract;

class VoteTransformer extends TransformerAbstract
{
    public function transform(array $data)
    {
        $total = 0;
        array_map(function($item) use (&$total){
            if ($item['cnt']) {
                $total++;
            }
        }, $data);
        $transform = [
            'votes' => $data,
            'total' => $total
        ];
        return $transform;
    }
}