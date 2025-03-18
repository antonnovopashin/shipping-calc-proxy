<?php

namespace app\Service;

class ExternalDataFetcher
{
    public static function requestDataFromProvider(EntryDto $locationFindEntryDto)
    {
        $client = new \GuzzleHttp\Client();
        $addressWithToken = env('DATA_PROVIDER_URL') . '?token=' . env('DATA_PROVIDER_ACCESS_TOKEN');

        $headers = [
            'Accept' => 'application/json',
        ];

        $options = [
            "object" => $locationFindEntryDto->getProviderObject(),
            "action" => $locationFindEntryDto->getProviderAction(),
            "params" => $locationFindEntryDto->getRequestParams(),
        ];

        $response = $client->post( $addressWithToken, [
            'headers' => $headers + ['Content-Type' => 'application/json'],
            'body' => json_encode($options),
        ]);


        return ProviderLocationResultDtoAssembler::makeDtoFromProviderResponse($response);
    }

    public static function requestPriceDataFromProvider(EntryDto $locationFindEntryDto)
    {
        $client = new \GuzzleHttp\Client();
        $addressWithToken = env('DATA_PROVIDER_URL') . '?token=' . env('DATA_PROVIDER_ACCESS_TOKEN');

        $headers = [
            'Accept' => 'application/json',
        ];

        $options = [
            "object" => $locationFindEntryDto->getProviderObject(),
            "action" => $locationFindEntryDto->getProviderAction(),
            "params" => $locationFindEntryDto->getRequestParams(),
        ];

        $response = $client->post( $addressWithToken, [
            'headers' => $headers + ['Content-Type' => 'application/json'],
            'body' => json_encode($options),
        ]);

        return json_decode($response->getBody(), true); //todo dto
    }

}