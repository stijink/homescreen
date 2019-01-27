<?php

namespace App\Component;

use App\Configuration;
use GuzzleHttp\Client;

class BringShoppingList implements ComponentInterface
{
    private $client;
    private $configuration;
    private $userDefinedItems;

    /**
     * @param Client $client
     * @param Configuration $configuration
     */
    public function __construct(Client $client, Configuration $configuration)
    {
        $this->client = $client;
        $this->configuration = $configuration;
    }

    public function load(): array
    {
        $user = $this->authenticate();
        $this->loadUserDefinedItems($user);

        return $this->getShoppingListItems($user);
    }

    /**
     * @return array
     */
    private function authenticate(): array
    {
        $response = $this->client->post('https://api.getbring.com/rest/v2/bringauth', [
            'form_params' => [
                'email'     => $this->configuration['shopping_list']['email'],
                'password'  => $this->configuration['shopping_list']['password'],
            ],
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    private function loadUserDefinedItems(array $user)
    {
        $response = $this->client->get('https://api.getbring.com/rest/v2/bringlists/' . $user['bringListUUID'] . '/details', [
            'headers' => [
                'Authorization'              => 'Bearer ' . $user['access_token'],
                'X-BRING-API-KEY'            => 'cof4Nc6D8saplXjE3h3HXqHH8m7VU2i1Gs0g85Sp',
                'X-BRING-CLIENT'             => 'webApp',
                'X-BRING-CLIENT-INSTANCE-ID' => 'Web-pPPuS1cl7jXeSFVaV0QY2GBR3RARB9oe',
                'X-BRING-CLIENT-SOURCE'      => 'webApp',
                'X-BRING-COUNTRY'            => 'DE',
                'X-BRING-USER-UUID'          => $user['uuid'],
            ],
        ]);

        $this->userDefinedItems = json_decode((string) $response->getBody(), true);
    }

    /**
     * @param   array $user
     * @return  array
     */
    private function getShoppingListItems(array $user): array
    {
        // https://web.getbring.com/assets/images/items/hundesnack.png

        $response = $this->client->get(
            'https://api.getbring.com/rest/v2/bringlists/' . $user['bringListUUID'],
            [
                'headers' => [
                    'Authorization'              => 'Bearer ' . $user['access_token'],
                    'X-BRING-API-KEY'            => 'cof4Nc6D8saplXjE3h3HXqHH8m7VU2i1Gs0g85Sp',
                    'X-BRING-CLIENT'             => 'webApp',
                    'X-BRING-CLIENT-INSTANCE-ID' => 'Web-pPPuS1cl7jXeSFVaV0QY2GBR3RARB9oe',
                    'X-BRING-CLIENT-SOURCE'      => 'webApp',
                    'X-BRING-COUNTRY'            => 'DE',
                    'X-BRING-USER-UUID'          => $user['uuid'],
                ],
            ]
        );

        $items = json_decode((string) $response->getBody(), true);
        $purchases = $items['purchase'];

        for ($i = 0; $i < count($purchases); $i++) {
            $purchases[$i]['icon'] = $this->getItemIcon($purchases[$i]);
            $purchases[$i]['icon_alternative'] = $this->getAlternativeIcon($purchases[$i]);
        }

        return $purchases;
    }

    private function getItemIcon(array $item): string
    {
        $icon = $item['name'];

        foreach ($this->userDefinedItems as $userDefinedItem) {
            if ($userDefinedItem['itemId'] == $item['name']) {
                $icon = $userDefinedItem['userIconItemId'];
                break;
            }
        }

        return 'https://web.getbring.com/assets/images/items/' . strtolower($icon) . '.png';
    }

    private function getAlternativeIcon(array $item): string
    {
        $icon = mb_substr($item['name'], 0, 1);

        return 'https://web.getbring.com/assets/images/items/' . strtolower($icon) . '.png';
    }
}
