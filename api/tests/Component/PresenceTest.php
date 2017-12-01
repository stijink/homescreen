<?php

namespace Tests\Api\Component;

use Api\Component\Presence;
use GuzzleHttp\Psr7\Response;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class PresenceTest extends MockeryTestCase
{
    public function testLoad()
    {
        $config = [
            'api_url' => 'http://fritz.box:49000/upnp/control/hosts',
        ];

        $persons = [
            'resident1' => [
                'name' => 'Resident 1',
                'type' => 'resident',
                'image_url' => 'http://graph.facebook.com/2/picture?type=square',
                'mac_address' => '48:43:7C:6B:F4:33',
            ],
            'resident2' => [
                'name' => 'Resident 2',
                'type' => 'resident',
                'image_url' => 'http://graph.facebook.com/2/picture?type=square',
                'mac_address' => '18:65:90:2D:66:55',
            ],
            'visitor1' => [
                'name' => 'Visitor 1',
                'type' => 'visitor',
                'image_url' => 'http://graph.facebook.com/2/picture?type=square',
                'mac_address' => 'F0:43:47:00:90:FF',
            ],
            'visitor2' => [
                'name' => 'Visitor 2',
                'type' => 'visitor',
                'image_url' => 'http://graph.facebook.com/2/picture?type=square',
                'mac_address' => '4C:57:CA:0F:C5:EE',
            ],
        ];

        $expectedResponse = [
            [
                'person' => [
                    'name'      => 'Resident 1',
                    'type'      => 'resident',
                    'image_url' => 'http://graph.facebook.com/2/picture?type=square'
                ],
                'is_present' => true,
                'status_text' => 'Resident 1 ist zuhause',
            ],
            [
                'person' => [
                    'name'      => 'Resident 2',
                    'type'      => 'resident',
                    'image_url' => 'http://graph.facebook.com/2/picture?type=square'
                ],
                'is_present' => false,
                'status_text' => 'Resident 2 ist nicht zuhause',
            ],
            [
                'person' => [
                    'name'      => 'Visitor 1',
                    'type'      => 'visitor',
                    'image_url' => 'http://graph.facebook.com/2/picture?type=square'
                ],
                'is_present' => true,
                'status_text' => 'Visitor 1 ist zu Besuch',
            ],
        ];

        $mockedHttpClient = \Mockery::mock('GuzzleHttp\Client')
            ->shouldReceive('send')
                ->once()
                ->with(\Mockery::on(function ($arg) {
                    return stripos((string) $arg->getBody(), '48:43:7C:6B:F4:33') !== false;
                }))
                ->andReturn($this->expectSuccessResponse('1'))
            ->shouldReceive('send')
                ->once()
                ->with(\Mockery::on(function ($arg) {
                    return stripos((string) $arg->getBody(), '18:65:90:2D:66:55') !== false;
                }))
                ->andReturn($this->expectSuccessResponse('0'))
            ->shouldReceive('send')
                ->once()
                ->with(\Mockery::on(function ($arg) {
                    return stripos((string) $arg->getBody(), 'F0:43:47:00:90:FF') !== false;
                }))
                ->andReturn($this->expectSuccessResponse('1'))
            ->shouldReceive('send')
                ->once()
                ->with(\Mockery::on(function ($arg) {
                    return stripos((string) $arg->getBody(), '4C:57:CA:0F:C5:EE') !== false;
                }))
                ->andReturn($this->expectErrorResponse())
            ->getMock();

        $presence = new Presence($mockedHttpClient, $config, $persons);
        $response = $presence->load();

         $this->assertEquals($expectedResponse, $response);
    }

    /**
     * @param string $isOnline
     *
     * @return Response
     */
    private function expectSuccessResponse(string $isOnline) : Response
    {
        $body = '<?xml version="1.0"?>
        <s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/" s:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
        <s:Body>
            <u:GetSpecificHostEntryResponse xmlns:u="urn:dslforum-org:service:Hosts:1">
                <NewIPAddress>192.168.178.30</NewIPAddress>
                <NewAddressSource>DHCP</NewAddressSource>
                <NewLeaseTimeRemaining>595845</NewLeaseTimeRemaining>
                <NewInterfaceType>802.11</NewInterfaceType>
                <NewActive>'.$isOnline.'</NewActive>
                <NewHostName>Devicename</NewHostName>
            </u:GetSpecificHostEntryResponse>
        </s:Body>
        </s:Envelope>';

        return new Response(200, [], $body);
    }

    private function expectErrorResponse() : Response
    {
        return new Response(500, [], '');
    }
}
