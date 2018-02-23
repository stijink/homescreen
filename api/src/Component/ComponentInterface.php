<?php

namespace App\Component;

use App\ApiException;

/**
 * @codeCoverageIgnore
 */
interface ComponentInterface
{
    /**
     * @return array
     * @throws ApiException
     */
    public function load(): array;
}
