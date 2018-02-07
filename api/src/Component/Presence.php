<?php

namespace App\Component;

use App\Configuration;
use App\ApiComponentException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use Psr\Log\LoggerInterface;

class Presence implements ComponentInterface
{
    use ComponentTrait;

    private $configuration;
    private $logger;
    private $httpClient;

    // Used in "isPersonPresent"
    private $soapBodyTemplate = '<?xml version="1.0" encoding="utf-8"?>
            <s:Envelope s:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"
              xmlns:s="http://schemas.xmlsoap.org/soap/envelope/" >
              <s:Body>
                <u:GetSpecificHostEntry xmlns:u="urn:dslforum-org:service:Hosts:1">
                  <NewMACAddress>%mac_address%</NewMACAddress>
                </u:GetSpecificHostEntry>
              </s:Body>
            </s:Envelope>';

    /**
     * @param $configuration
     * @param $logger
     * @param $httpClient
     */
    public function __construct(Configuration $configuration, LoggerInterface $logger, Client $httpClient)
    {
        $this->configuration = $configuration;
        $this->logger = $logger;
        $this->httpClient = $httpClient;
    }


    /**
     * @return array
     * @throws ApiComponentException
     */
    public function load(): array
    {
        try {
            $presentPersons = [];

            foreach ($this->configuration['persons'] as $person) {
                $presentPerson = $this->handlePerson($person);

                if (is_array($presentPerson)) {
                    $presentPersons[] = $presentPerson;
                }
            }

            $presentPersons = $this->sortByPersonType($presentPersons);
            $presentPersons = $this->sortByPresence($presentPersons);

            return $presentPersons;
        } catch (\Exception $e) {
            $this->handleException($e, 'Anwesende/Abwesende Personen konnten nicht bestimmt werden');
        }
    }

    /**
     * Handle the presence for a single person
     *
     * @param  array $person
     * @return array|null
     */
    private function handlePerson(array $person)
    {
        $isPresent = $this->isPersonPresent($person);

        // Do not add visitors that are not present
        if ($person['type'] == 'visitor' && $isPresent === false) {
            return null;
        }

        // Unset the mac_address to not expose it into the frontend
        unset($person['mac_address']);

        return [
            'person'      => $person,
            'is_present'  => $isPresent,
            'status_text' => $this->getStatusText($person, $isPresent),
        ];
    }

    /**
     * Sort Persons by presence.
     *
     * @param array $presence
     * @return array
     */
    private function sortByPresence(array $presence): array
    {
        usort($presence, function (array $personToCompare): int {
            return intval(! $personToCompare['is_present']);
        });

        return $presence;
    }

    /**
     * Sort Persons by presence.
     *
     * @param array $presence
     * @return array
     */
    private function sortByPersonType(array $presence): array
    {
        usort($presence, function (array $personToCompare): int {
            return intval($personToCompare['person']['type'] !== 'resident');
        });

        return $presence;
    }

    /**
     * Assamble the status text.
     *
     * @param   array $person
     * @param   bool  $isPresent
     * @return  string
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
     * @param   array $person
     * @return  bool
     */
    private function isPersonPresent(array $person): bool
    {
        try {
            $body = str_replace('%mac_address%', $person['mac_address'], $this->soapBodyTemplate);

            $headers = [
                'Content-type' => 'text/xml;charset="utf-8',
                'SoapAction'   => 'urn:dslforum-org:service:Hosts:1#GetSpecificHostEntry',
            ];

            $request = new Request('POST', $this->configuration['presence']['api_url'], $headers, $body);
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
