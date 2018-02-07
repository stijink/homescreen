<?php

namespace App\Component;

use App\ApiComponentException;

/**
 * @codeCoverageIgnore
 */
interface ComponentInterface
{
    /**
     * @return array
     * @throws ApiComponentException
     */
    public function load(): array;
}
