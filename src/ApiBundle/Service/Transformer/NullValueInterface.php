<?php

namespace ApiBundle\Service\Transformer;

/**
 * Interface that helps to handle default values (usually, null values)
 */
interface NullValueInterface
{
    /**
     * Check if null value should be included into output
     *
     * @return bool
     */
    public function includeNull();
}