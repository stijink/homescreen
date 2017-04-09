<?php

namespace Api\Component;

class Presence implements ComponentInterface
{
    private $config;
    private $persons;

    /**
     * @param array $config
     * @param array $persons
     */
    public function __construct(array $config, array $persons)
    {
        $this->config = $config;
        $this->persons = $persons;
    }

    /**
     * @return array
     */
    public function load(): array
    {
        $presence = [];

        foreach ($this->persons as $person) {
            $isPresent = $this->isPersonPresent($person);

            // Do not add visitors that are not present
            if ($person['type'] == 'visitor' && $isPresent === false) {
                continue;
            }

            $presence[] = [
                'person' => $person,
                'is_present' => $isPresent,
                'status_text' => $this->getStatusText($person, $isPresent),
            ];
        }

        return $this->sortByPresence($presence);
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
     * @param array $person
     *
     * @return bool
     */
    private function isPersonPresent(array $person): bool
    {
        $xmlPostString = '<?xml version="1.0" encoding="utf-8"?>
        <s:Envelope s:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" 
          xmlns:s="http://schemas.xmlsoap.org/soap/envelope/" >
          <s:Body>
            <u:GetSpecificHostEntry xmlns:u="urn:dslforum-org:service:Hosts:1">
              <NewMACAddress>'.$person['mac_address'].'</NewMACAddress>
            </u:GetSpecificHostEntry>
          </s:Body>
        </s:Envelope>';

        $headers = array(
            'Content-type: text/xml;charset="utf-8"',
            'Accept: text/xml',
            'Cache-Control: no-cache',
            'Pragma: no-cache',
            'SoapAction:urn:dslforum-org:service:Hosts:1#GetSpecificHostEntry',
            'Content-length: '.strlen($xmlPostString),
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->config['api_url']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 2);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xmlPostString);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($curl);
        curl_close($curl);

        // We return in case we cannot connect
        if ($response === false) {
            return false;
        }

        $parser = simplexml_load_string($response);
        $parser->registerXPathNamespace('a', 'urn:dslforum-org:service:Hosts:1');

        $newActive = $parser->xpath('//NewActive/text()');

        if (isset($newActive[0])) {
            return  (bool) $newActive[0]->__toString();
        }

        return false;
    }
}
