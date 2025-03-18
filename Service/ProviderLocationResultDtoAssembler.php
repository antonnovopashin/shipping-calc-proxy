<?php

namespace app\Service;

class ProviderLocationResultDtoAssembler
{

    private array $items;

    public static function makeDtoFromProviderResponse(\Psr\Http\Message\ResponseInterface $response)
    {
        $items = [];
        $response = json_decode($response->getBody(), true);

        foreach ($response['response']['data'] as $item) {
            $providerLocationItemDto = new ProviderLocationItemDto($item);
            $items[] = $providerLocationItemDto;
        }

        return new ProviderLocationItemsDtoCollection($items);
    }
}