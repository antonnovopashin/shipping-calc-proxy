<?php

namespace app\controllers;

use app\Service\ExternalDataFetcher;
use app\Service\FindLocationPhoneDto;
use app\Service\FindResultDto;
use app\Service\FindResultLocationDTO;
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
        $request = Yii::$app->request;
        $rawBody = $request->getRawBody();
        $rawBodyDecoded = json_decode($rawBody, true);

        $params = [
            'offset' => 0,
            'limit' => 80,
        ];

        $response = ExternalDataFetcher::requestDataFromProvider('location', 'get', $params);
        $searchResults = $response['response']['data'];
        $searchResultDtoCollection = [];

        foreach ($searchResults as $searchResultItem) {
            $searchResultDto = [];
            $hasTerminal = true;

            if (null !== $searchResultItem['default_terminal']) {
                if (array_key_exists('location_guid', $searchResultItem['default_terminal'])) {
                    $hasTerminal = false;
                }
            }

            $searchResultDto['guid'] = $searchResultItem['guid'];
            $searchResultDto['name'] = $searchResultItem['name'];
            $searchResultDto['type'] = $searchResultItem['type'];
            $searchResultDto['coordinates'] = explode(',', $searchResultItem['coordinates']);
            $searchResultDto['country'] = $searchResultItem['country'];
            $searchResultDto['hasTerminal'] = $hasTerminal;
            $searchResultDtoCollection[] = $searchResultDto;
        }

        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $searchResultDtoCollection;

        return $response;
    }

    public function actionSearch()
    {
        $request = Yii::$app->request;
        $rawBody = $request->getRawBody();
        $rawBodyDecoded = json_decode($rawBody, true);

        $params = [
            "search" => $rawBodyDecoded['search'],
        ];

        $response = ExternalDataFetcher::requestDataFromProvider(
            'location',
            'get',
            $params
        );

        $searchResults = $response['response']['data'];
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

        $response = ExternalDataFetcher::requestDataFromProvider(
            'location',
            'get',
            $params
        );

        $searchResults = $response['response']['data'][0];
        $findResultLocationDTO = $this->makeLocationDto($searchResults);
        $findResultPhoneDTO = $this->makeLocationPhonesDto([]);
        $findResultDto = new FindResultDto($findResultLocationDTO, $findResultPhoneDTO);

        return ResponseRenderer::makeFindLocationResponse($findResultDto);
    }

    public function makeLocationDto($searchResultItem): FindResultLocationDTO
    {
        $hasTerminal = true;

        if (null !== $searchResultItem['default_terminal']) {
            if (array_key_exists('location_guid', $searchResultItem['default_terminal'])) {
                $hasTerminal = false;
            }
        }

        return FindResultLocationDTO::fromArray([
            'guid' => $searchResultItem['guid'],
            'name' => $searchResultItem['name'],
            'country' => $searchResultItem['country'],
            'type' => $searchResultItem['type'],
            'coordinates' => explode(',', $searchResultItem['coordinates']),
            'hasTerminal' => $hasTerminal,
        ]);
    }

    private function makeLocationPhonesDto(array $array)
    {
        return FindLocationPhoneDto::fromArray($array);
    }
}
