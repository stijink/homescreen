<?php

namespace App\Component;

use App\ApiException;

trait ComponentTrait
{
    /**
     * @param   \Exception $e
     * @param   string $message
     * @throws  ApiException
     */
    public function handleException(\Exception $e, string $message)
    {
        $logMessage = $e->getMessage() . ' (' . get_class($e) . ')';

        $this->logger->error($logMessage);
        throw new ApiException($message);
    }
}
