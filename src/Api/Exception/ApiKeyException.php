<?php

namespace Api\Exception;

/**
 * We throw this exception if we're missing an Api-Key.
 */
class ApiKeyException extends ApiException
{
    protected $message = 'Ein API-Key wurde nicht konfiguriert';
    protected $description = 'Midestens ein API-Key wurde nicht konfiguriert. Bitte prüfe die Konfiguration und starte die Anwendung dann neu.';
}
