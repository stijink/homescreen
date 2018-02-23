<?php

namespace App;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionListener
{
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Handle exceptions
     *
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        $publicMessage = 'Ein unbekannter Fehler ist aufgetreten';

        if ($exception instanceof ApiException) {
            $publicMessage = $exception->getMessage();
        }

        $this->logger->error($exception->getMessage());
        $event->setResponse(new JsonResponse(['message' => $publicMessage], 500));
    }
}
