<?php

namespace App\Component;

use Exception;
use App\ApiException;
use App\Configuration;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BringShoppingList implements ComponentInterface
{
    private array $userDefinedItems;

    public function __construct(private HttpClientInterface $httpClient, private Configuration $configuration)
    {
    }

    public function load(): array
    {
        try {
            $user = $this->authenticate();
            $this->loadUserDefinedItems($user);

            return $this->getShoppingListItems($user);
        }
        catch (Exception) {
            throw new ApiException('Einkaufsliste konnten nicht bezogen werden');
        }
    }

    /**
     * @return array
     */
    private function authenticate(): array
    {
        $response = $this->httpClient->request('POST', 'https://api.getbring.com/rest/v2/bringauth', [
            'body' => [
                'email'     => $this->configuration['shopping_list']['email'],
                'password'  => $this->configuration['shopping_list']['password'],
            ]
        ]);

        return json_decode($response->getContent(), true);
    }

    private function loadUserDefinedItems(array $user)
    {
        $response = $this->httpClient->request('GET', 'https://api.getbring.com/rest/v2/bringlists/' .$user['bringListUUID'] . '/details', [
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

        $this->userDefinedItems = json_decode($response->getContent(), true);
    }

    /**
     * @param   array $user
     * @return  array
     */
    private function getShoppingListItems(array $user): array
    {
        // https://web.getbring.com/assets/images/items/hundesnack.png

        $response = $this->httpClient->request(
            'GET',
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

        $items = json_decode($response->getContent(), true);
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
