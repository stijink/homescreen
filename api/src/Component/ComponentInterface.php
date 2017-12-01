<?php

namespace Api\Component;

/**
 * @codeCoverageIgnore
 */
interface ComponentInterface
{
    /**
     * @return array
     */
    public function load(): array;
}
