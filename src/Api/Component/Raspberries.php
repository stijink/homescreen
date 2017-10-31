<?php

namespace Api\Component;

use GuzzleHttp\Client;

class Raspberries implements ComponentInterface
{
    private $httpClient;
    private $config;

    /**
     * @param Client $httpClient
     * @param array  $config
     */
    public function __construct(Client $httpClient, array $config)
    {
        $this->httpClient = $httpClient;
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function load(): array
    {
        $raspberries = [];

        foreach ($this->config as $raspberryConfig) {
            $response  = $this->httpClient->get($raspberryConfig['url']);
            $raspberry = json_decode((string)$response->getBody(), true);

            if ($raspberryConfig['diskinfo'] !== null) {
                $raspberry['disk'] = $raspberry['disks'][$raspberryConfig['diskinfo']['volume']];

                $raspberry['disk']['label']    = $raspberryConfig['diskinfo']['label'];
                $raspberry['disk']['free']     = $this->convertDiskSize($raspberry['disk']['free']);
                $raspberry['disk']['size']     = $this->convertDiskSize($raspberry['disk']['size']);
                $raspberry['disk']['used']     = $this->convertDiskSize($raspberry['disk']['used']);
                $raspberry['disk']['percent']  = floatval(number_format($raspberry['disk']['percent'] * 100, 0));
            }

            unset($raspberry['disks']);

            $raspberry['temperature'] = floatval(number_format($raspberry['temperature'], 1));
            $raspberries[] = $raspberry;
        }

        return $raspberries;
    }

    /**
     * Convert the disk size from bytes to gigabytes
     *
     * @param   string $sizeInBytes
     * @return  float
     */
    private function convertDiskSize(string $sizeInBytes): float
    {
        $sizeInGigaBytes = $sizeInBytes / (1024 * 1014);
        $sizeInGigaBytes = number_format($sizeInGigaBytes, 0, '.', '');

        return floatval($sizeInGigaBytes);
    }
}
