<?php

namespace Api\Component;

use Api\Exception\ApiKeyException;
use GuzzleHttp\Client;

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
        $this->config  = $config;
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
     * Sort Persons by presence
     *
     * @param  array $presence
     * @return array
     */
    private function sortByPresence(array $presence) : array
    {
        usort($presence, function (array $a, array $b) : int {
            return (int)$b['is_present'];
        });

        return $presence;
    }

    /**
     * Assamble the status text
     *
     * @param  array $person
     * @param  bool $isPresent
     * @return string
     */
    private function getStatusText(array $person, bool $isPresent) : string
    {
        if ($person['type'] == 'visitor') {
            return $person['name'] . ' ist zu Besuch';
        }

        if ($isPresent === true) {
            return $person['name'] . ' ist zuhause';
        }

        return $person['name'] . ' ist nicht zuhause';
    }

    /**
     * @param  array $person
     * @return bool
     */
    private function isPersonPresent(array $person) : bool
    {
        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
        <s:Envelope s:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" xmlns:s="http://schemas.xmlsoap.org/soap/envelope/" >
          <s:Body>
            <u:GetSpecificHostEntry xmlns:u="urn:dslforum-org:service:Hosts:1">
              <NewMACAddress>' . $person['mac_address'] . '</NewMACAddress>
            </u:GetSpecificHostEntry>
          </s:Body>
        </s:Envelope>';

        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SoapAction:urn:dslforum-org:service:Hosts:1#GetSpecificHostEntry",
            "Content-length: ".strlen($xml_post_string),
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->config['api_url']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);

        $parser = simplexml_load_string($response);
        $parser->registerXPathNamespace("a", "urn:dslforum-org:service:Hosts:1");

        $NewActive_h = $parser->xpath('//NewActive/text()');

        if (isset($NewActive_h[0])) {
            return  (bool)$NewActive_h[0]->__toString();
        }

        return false;
    }
}
