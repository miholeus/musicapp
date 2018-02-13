<?php

namespace ApiBundle\Service;

use ApiBundle\Service\Transformer\NullValueInterface;
use ApiBundle\Service\Transformer\TransformerInterface;

/**
 * Scope
 *
 * The scope class acts as a tracker, relating a specific resource in a specific
 * context. For example, the same resource could be attached to multiple scopes.
 * There are root scopes, parent scopes and child scopes.
 */
class Scope extends \League\Fractal\Scope
{
    protected function fireTransformer($transformer, $data)
    {
        $includedData = [];

        if (is_callable($transformer)) {
            $transformedData = call_user_func($transformer, $data);
        } else {
            if (!$transformer instanceof TransformerInterface) {
                throw new \InvalidArgumentException(
                    sprintf("Transformer should implement \\ApiBundle\\Service\\Transformer\\TransformerInterface, but instance of %s given.",
                    get_class($transformer)
                ));
            }
            $transformedData = $transformer->transform($data);
            if ($transformer instanceof NullValueInterface) {
                $transformedData = $this->cleanData($transformer, $transformedData);
            }
        }

        if ($this->transformerHasIncludes($transformer)) {
            $includedData = $this->fireIncludedTransformers($transformer, $data);
            if ($transformer instanceof NullValueInterface) {
                $includedData = $this->cleanData($transformer, $includedData);
            }
            foreach ($includedData as &$item) {
                if (is_array($item)) {
                    $data = [];
                    foreach ($item as $resource) {
                        if ($resource instanceof \League\Fractal\Resource\Item) {
                            $resource = $resource->getTransformer()->transform($resource->getData());
                            $data[] = $resource;
                        }
                    }
                    if (!empty($data)) {
                        $item = $data;
                    }
                }

            }
            unset($item);
            $transformedData = $transformedData ?? [];

            $transformedData = $this->manager->getSerializer()->mergeIncludes($transformedData, $includedData);
        }

        return [$transformedData, $includedData];
    }

    /**
     * Clean data
     *
     * @param NullValueInterface $transformer
     * @param $data
     * @return array
     */
    protected function cleanData(NullValueInterface $transformer, $data)
    {
        if (!$transformer->includeNull()) {
            return array_filter($data, function($value){
                return $value !== null;
            });
        }
        return $data;
    }
}