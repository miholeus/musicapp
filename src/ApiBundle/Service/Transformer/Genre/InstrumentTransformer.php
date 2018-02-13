<?php
/**
 * This file is part of ApiBundle\Service\Transformer\Genre package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiBundle\Service\Transformer\Genre;

use ApiBundle\Service\Transformer\TransformerAbstract;
use CoreBundle\Entity\Instrument;

/**
 * Instrument transformer
 */
class InstrumentTransformer extends TransformerAbstract
{
    /**
     * @param Instrument $instrument
     * @return array
     */
    public function transform(Instrument $instrument)
    {
        return [
            'id' => $instrument->getId(),
            'name' => $instrument->getName(),
            'photo' => $instrument->getPhoto()
        ];
    }
}