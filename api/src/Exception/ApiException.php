<?php

namespace Api\Exception;

/**
 * @codeCoverageIgnore
 */
abstract class ApiException extends \Exception
{
    protected $description;

    public function getDescription()
    {
        return $this->description;
    }
}
