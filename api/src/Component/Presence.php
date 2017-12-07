<?php

namespace Api\Component;

use Api\Exception\ApiComponentException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;

class Presence implements ComponentInterface
{
    private $httpClient;
    private $config;
    private $persons;

    /**
     * @param Client $httpClient
     * @param array  $config
     * @param array  $persons
     */
    public function __construct(Client $httpClient, array $config, array $persons)
    {
        $this->httpClient = $httpClient;
        $this->config = $config;
        $this->persons = $persons;
    }

    /**
     * @return array
     * @throws ApiComponentException
     */
    public function load(): array
    {
        try {
            $presence = [];

            foreach ($this->persons as $person) {
                $isPresent = $this->isPersonPresent($person);

                // Do not add visitors that are not present
                if ($person['type'] == 'visitor' && $isPresent === false) {
                    continue;
                }

                // Unset the mac_address to not expose it into the frontend
                unset($person['mac_address']);

                $presence[] = [
                    'person'      => $person,
                    'is_present'  => $isPresent,
                    'status_text' => $this->getStatusText($person, $isPresent),
                ];
            }

            $presence = $this->sortByPresence($presence);
            $presence = $this->sortByPersonType($presence);

            return $presence;
        } catch (\Exception $e) {
            throw new ApiComponentException('Anwesende/Abwesende Personen konnten nicht bestimmt werden');
        }
    }

    /**
     * Sort Persons by presence.
     *
     * @param array $presence
     *
     * @return array
     */
    private function sortByPresence(array $presence): array
    {
        usort($presence, function (array $presence1, array $presence2): int {
            return (int) $presence2['is_present'];
        });

        return $presence;
    }

    /**
     * Sort Persons by presence.
     *
     * @param array $presence
     *
     * @return array
     */
    private function sortByPersonType(array $presence): array
    {
        usort($presence, function (array $presence1, array $presence2): int {
            return (int) $presence2['person']['type'] == 'resident';
        });

        return $presence;
    }

    /**
     * Assamble the status text.
     *
     * @param array $person
     * @param bool  $isPresent
     *
     * @return string
     */
    private function getStatusText(array $person, bool $isPresent): string
    {
        if ($person['type'] == 'visitor') {
            return $person['name'].' ist zu Besuch';
        }

        if ($isPresent === true) {
            return $person['name'].' ist zuhause';
        }

        return $person['name'].' ist nicht zuhause';
    }

    /**
     * Check against the API if a person is currently present.
     *
     * @param array $person
     *
     * @return bool
     */
    private function isPersonPresent(array $person): bool
    {
        try {
            $body = '<?xml version="1.0" encoding="utf-8"?>
            <s:Envelope s:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"
              xmlns:s="http://schemas.xmlsoap.org/soap/envelope/" >
              <s:Body>
                <u:GetSpecificHostEntry xmlns:u="urn:dslforum-org:service:Hosts:1">
                  <NewMACAddress>'.$person['mac_address'].'</NewMACAddress>
                </u:GetSpecificHostEntry>
              </s:Body>
            </s:Envelope>';

            $headers = [
                'Content-type' => 'text/xml;charset="utf-8',
                'SoapAction'   => 'urn:dslforum-org:service:Hosts:1#GetSpecificHostEntry',
            ];

            $request = new Request('POST', $this->config['api_url'], $headers, $body);
            $response = $this->httpClient->send($request);

            if ($response->getStatusCode() == 500) {
                throw new ServerException('error', $request, $response);
            }

            preg_match(
                '/<NewActive>([0|1])<\/NewActive>/',
                (string) $response->getBody(),
                $matches
            );

            return boolval($matches[1]);
        } catch (ServerException $e) {
            return false;
        }
    }
}
