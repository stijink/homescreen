<?php

namespace App\Component;

use App\ApiException;

/**
 * @codeCoverageIgnore
 */
interface ComponentInterface
{
    /**
     * @throws ApiException
     * @return array
     */
    public function load(): array;
}
