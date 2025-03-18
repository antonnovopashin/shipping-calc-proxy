<?php

namespace app\controllers;

use app\Service\EntryDto;
use app\Service\ExternalDataFetcher;
use app\Service\FindLocationPhoneDto;
use app\Service\FindResultDto;
use app\Service\FindResultLocationDTO;
use app\Service\ProviderLocationItemDto;
use app\Service\ResponseRenderer;
use Yii;
use yii\web\Controller;

class LocationController extends Controller
{
    function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionGet()
    {
        $params = [
            'offset' => 0,
            'limit' => 80,
        ];

        $locationGetEntryDto = new EntryDto('location', 'get', $params);
        $providerResponse = ExternalDataFetcher::requestDataFromProvider($locationGetEntryDto);
        $searchResults = $providerResponse->getItems();

        $searchResultDtoCollection = [];

        foreach ($searchResults as $searchResultItem) {
            $searchResultDto = $this->makeLocationDto($searchResultItem);
            $searchResultDtoCollection[] = $searchResultDto;
        }

        return ResponseRenderer::makeSearchLocationResponse($searchResultDtoCollection);
    }

    public function actionSearch()
    {
        $request = Yii::$app->request;
        $rawBody = $request->getRawBody();
        $rawBodyDecoded = json_decode($rawBody, true);

        $params = [
            "search" => $rawBodyDecoded['search'],
        ];

        $locationSearchEntryDto = new EntryDto('location', 'get', $params);
        $providerResponse = ExternalDataFetcher::requestDataFromProvider($locationSearchEntryDto);

        $searchResults = $providerResponse->getItems();
        $searchResultDtoCollection = [];

        foreach ($searchResults as $searchResultItem) {
            $searchResultDto = $this->makeLocationDto($searchResultItem);
            $searchResultDtoCollection[] = $searchResultDto;
        }

        return ResponseRenderer::makeSearchLocationResponse($searchResultDtoCollection);
    }

    public function actionFind()
    {
        $request = Yii::$app->request;
        $rawBody = $request->getRawBody();
        $rawBodyDecoded = json_decode($rawBody, true);

        $params = [
            "id" => $rawBodyDecoded['guid'],
        ];

        $locationFindEntryDto = new EntryDto('location', 'get', $params);

        $providerResponse = ExternalDataFetcher::requestDataFromProvider($locationFindEntryDto);

        $items = $providerResponse->getItems();
        $searchResultDto = $items[0];
        $findResultLocationDTO = $this->makeLocationDto($searchResultDto);
        $findResultPhoneDTO = $this->makeLocationPhonesDto([]);
        $findResultDto = new FindResultDto($findResultLocationDTO, $findResultPhoneDTO);

        return ResponseRenderer::makeFindLocationResponse($findResultDto);
    }

    public function makeLocationDto(ProviderLocationItemDto $searchResultItem): FindResultLocationDTO
    {
        $hasTerminal = true;

        if (null !== $searchResultItem->getDefaultTerminal()) {
            if (null !== $searchResultItem->getDefaultTerminal()->getLocationGuid()) {
                $hasTerminal = false;
            }
        }

        return FindResultLocationDTO::fromArray([
            'guid' => $searchResultItem->getGuid(),
            'name' => $searchResultItem->getName(),
            'country' => $searchResultItem->getCountry(),
            'type' => $searchResultItem->getType(),
            'coordinates' => explode(',', $searchResultItem->getCoordinates()),
            'hasTerminal' => $hasTerminal,
        ]);
    }

    private function makeLocationPhonesDto(array $array)
    {
        return FindLocationPhoneDto::fromArray($array);
    }
}
