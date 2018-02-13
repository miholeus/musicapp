<?php
/**
 * This file is part of ApiBundle\Service\Serializer package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ApiBundle\Service\Serializer;

class ArraySerializer extends \League\Fractal\Serializer\ArraySerializer
{
    public function collection($resourceKey, array $data)
    {
        return $resourceKey ?: $data;
    }

}