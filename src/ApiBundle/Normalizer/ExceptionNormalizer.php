<?php
/**
 * This file is part of ApiBundle\Normalizer package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ApiBundle\Normalizer;

use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Normalize exceptions
 */
class ExceptionNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        /** @var \Symfony\Component\Debug\Exception\FlattenException $exception */
        $exception = $object;
        $errors = null;
        if (in_array(
            get_class($exception), [
            'ApiBundle\Service\Exception\FormValidateException',
            'ApiBundle\Service\Exception\ParameterValidateException'
        ])) {
            $errors = $exception->getHeaders();
            $exception->setHeaders([]);
        }

        $enableLog = true;
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            $enableLog = false;
        }
        if (!$exception instanceof FlattenException) {
            $exception = FlattenException::create($exception, 500);
        }

        $newException = array(
            'success' => false,
            'log' => [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTrace(),
                'enabled' => $enableLog
            ],
            'exception' => array(
                'code' => $exception->getStatusCode(),
                'message' => $exception->getStatusCode() !== 500 ? $exception->getMessage() : "Internal Server Error"
            ),
            'errors' => $errors
        );

        return $newException;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof \Exception;
    }
}