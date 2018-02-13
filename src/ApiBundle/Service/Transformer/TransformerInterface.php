<?php

namespace ApiBundle\Service\Transformer;

interface TransformerInterface
{
    public function getAvailableIncludes();

    public function getDefaultIncludes();
}