<?php

namespace App;

use ArrayAccess;
class Configuration implements ArrayAccess
{
    /**
     * @var array
     */
    private $configuration;

    /**
     * @param   string $configurationFile
     * @throws  ApiException
     */
    public function __construct(string $configurationFile)
    {
        if (! file_exists($configurationFile)) {
            throw new ApiException('Configuration file not found: ' . $configurationFile);
        }

        $this->configuration = json_decode(file_get_contents($configurationFile), true);
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->configuration);
    }

    public function offsetGet($offset)
    {
        return $this->configuration[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->configuration[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->configuration[$offset]);
    }
}
