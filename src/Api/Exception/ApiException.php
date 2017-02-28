<?php

namespace Api\Exception;

abstract class ApiException extends \Exception
{
    protected $description;

    public function getDescription()
    {
        return $this->description;
    }
}
