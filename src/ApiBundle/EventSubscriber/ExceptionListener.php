<?php
/**
 * This file is part of ApiBundle\EventSubscriber package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ApiBundle\EventSubscriber;

use Monolog\Logger;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Listener for exceptions
 */
class ExceptionListener implements EventSubscriberInterface
{
    private $serializer;
    private $normalizers;
    /**
     * @var Logger
     */
    private $logger;

    public function __construct(Serializer $serializer, Logger $logger)
    {
        $this->serializer = $serializer;
        $this->normalizers = [];
        $this->logger = $logger;
    }

    public function processException(GetResponseForExceptionEvent $event, $name, $dispatcher)
    {
        $result = null;
        $exception = $event->getException();

        if($event->getRequest()->getContentType() !== 'json' &&
            !preg_match("~\/api~", $event->getRequest()->getRequestUri())) {
            return;
        }

        /** @var NormalizerInterface $normalizer */
        foreach ($this->normalizers as $normalizer) {
            if ($normalizer->supportsNormalization($exception)) {
                $result = $normalizer->normalize($exception);
                break;
            }
        }

        if (null !== $result) {
            $level = $result['exception']['code'] == 500 ? Logger::CRITICAL : Logger::ERROR;
            $logData = $result['log'];
            unset($result['log']);

            $body = $this->serializer->serialize($result, 'json');

            $enableLog = $logData['enabled'];
            unset($logData['enabled']);
            if ($enableLog) {
                $this->logger->log($level, $logData['message'], $logData);
            }
            $event->setResponse(new Response($body, $result['exception']['code']));
        }
    }

    public function addNormalizer(NormalizerInterface $normalizer)
    {
        $this->normalizers[] = $normalizer;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => [['processException', 255]]
        ];
    }
}