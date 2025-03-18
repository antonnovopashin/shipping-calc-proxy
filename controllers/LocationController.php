<?php

namespace app\controllers;

use app\Service\ExternalDataFetcher;
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

        //todo занести в докер компоузе установку пакетов из композера
        //todo занести в докер компоузе установку расширений php docker-php-ext-install pdo pdo_mysql
        //todo занести в докер компоузе накатку миграций
        //todo сделать readme
        //todo сделать валидацию инпута
        //todo сделать swagger
        //todo отрефакторить в ddd
        //todo написать тесты
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
            $searchResultDto = [];
            $searchResultDto['guid'] = $searchResultItem['guid'];
            $searchResultDto['name'] = $searchResultItem['name'];
            $searchResultDto['country'] = $searchResultItem['country'];
            $searchResultDto['type'] = $searchResultItem['type'];
            $searchResultDto['coordinates'] = explode(',', $searchResultItem['coordinates']);
            $searchResultDto['hasTerminal'] = array_key_exists('location_guid', $searchResultItem['default_terminal']);
            $searchResultDtoCollection[] = $searchResultDto;
        }

        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $searchResultDtoCollection;

        return $response;
    }
}
