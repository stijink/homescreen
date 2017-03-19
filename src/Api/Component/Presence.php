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
            $presence[] = $this->personPresence($person);
        }

        return $presence;
    }

    /**
     * @param  array $person
     * @return array
     */
    private function personPresence(array $person) : array
    {
        $isPresent = $this->isPersonPresent($person);

        return [
            'person' => $person,
            'is_present' => $isPresent,
        ];
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

        return  (bool)$NewActive_h[0]->__toString();
    }
}
