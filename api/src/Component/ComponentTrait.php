<?php

namespace App\Component;

use App\ApiComponentException;

trait ComponentTrait
{
    /**
     * @param  \Exception $e
     * @param  string $message
     * @throws ApiComponentException
     */
    public function handleException(\Exception $e, string $message)
    {
        $logMessage = $e->getMessage() . ' ('.get_class($e).')';

        $this->logger->error($logMessage);
        throw new ApiComponentException($message);
    }
}
