<?php

namespace App\Component;

use App\Configuration;
use App\ApiException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Raspberries implements ComponentInterface
{
    private $configuration;
    private $httpClient;

    /**
     * @param Configuration $configuration
     * @param HttpClientInterface $httpClient
     */
    public function __construct(Configuration $configuration, HttpClientInterface $httpClient)
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
            $response = $this->httpClient->request('GET', $device['url']);
            $raspberry = json_decode($response->getContent(), true);

            $raspberry['is_online'] = true;

            foreach ($raspberry['disks'] as $diskName => $disk) {
                if (! in_array($diskName, $device['volumes'])) {
                    unset($raspberry['disks'][$diskName]);
                }
                else {
                    $raspberry['disks'][$diskName]['label'] = $diskName;
                    $raspberry['disks'][$diskName]['free'] = $this->convertDiskSize($raspberry['disks'][$diskName]['free']);
                    $raspberry['disks'][$diskName]['size'] = $this->convertDiskSize($raspberry['disks'][$diskName]['size']);
                    $raspberry['disks'][$diskName]['used'] = $this->convertDiskSize($raspberry['disks'][$diskName]['used']);
                    $raspberry['disks'][$diskName]['percent'] = floatval(number_format($raspberry['disks'][$diskName]['percent'] * 100, 0));
                }
            }

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

    private function mapVolumeLabel(string $diskName): string
    {

    }
}
