<?php

namespace App\Component;

use App\Configuration;
use App\ApiException;
use GuzzleHttp\Client;

class Raspberries implements ComponentInterface
{
    private $configuration;
    private $httpClient;

    /**
     * @param $configuration
     * @param $httpClient
     */
    public function __construct(Configuration $configuration, Client $httpClient)
    {
        $this->configuration = $configuration;
        $this->httpClient = $httpClient;
    }

    /**
     * @throws ApiException
     * @return array
     */
    public function load(): array
    {
        try {
            $raspberries = [];

            foreach ($this->configuration['raspberries'] as $raspberry) {
                $raspberries[] = $this->handleDevice($raspberry);
            }

            return $raspberries;
        } catch (\Exception $e) {
            throw new ApiException('Der Status der Raspberries konnte nicht bestimmt werden');
        }
    }

    /**
     * @param  array $device
     * @return array
     */
    private function handleDevice(array $device)
    {
        try {
            $response = $this->httpClient->get($device['url']);
            $raspberry = json_decode((string) $response->getBody(), true);

            $raspberry['is_online'] = true;

            if ($device['volumes'] !== null) {
                $raspberry['disk'] = $raspberry['disks'][$device['volumes']['device']];

                $raspberry['disk']['label'] = $device['volumes']['label'];
                $raspberry['disk']['free'] = $this->convertDiskSize($raspberry['disk']['free']);
                $raspberry['disk']['size'] = $this->convertDiskSize($raspberry['disk']['size']);
                $raspberry['disk']['used'] = $this->convertDiskSize($raspberry['disk']['used']);
                $raspberry['disk']['percent'] = floatval(number_format($raspberry['disk']['percent'] * 100, 0));
            }

            unset($raspberry['disks']);

            $raspberry['temperature'] = floatval(number_format($raspberry['temperature'], 1));

            return $raspberry;
        } catch (\Exception $e) {
            return [
                'hostname'  => $device['name'],
                'is_online' => false,
            ];
        }
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
