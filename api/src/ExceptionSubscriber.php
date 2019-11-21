<?php

namespace App;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionSubscriber implements EventSubscriberInterface
{
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return [
            ExceptionEvent::class => 'onException',
        ];
    }

    /**
     * Handle exceptions
     *
     * @param ExceptionEvent $event
     */
    public function onException(ExceptionEvent $event): void
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
