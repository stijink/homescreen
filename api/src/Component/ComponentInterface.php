<?php

namespace Api\Component;

use Api\Exception\ApiComponentException;

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
