<?php

namespace app\controllers;

use app\Service\ExternalDataFetcher;
use Yii;
use yii\web\Controller;

class PriceController extends Controller
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
        $fromType = null;
        $toType = null;

        if (array_key_exists('type', $rawBodyDecoded['from'])) {
            if ('terminal' === $rawBodyDecoded['from']['type']) {
                $fromType = 'default';
            }
        }

        if (array_key_exists('type', $rawBodyDecoded['to'])) {
            if ('terminal' === $rawBodyDecoded['to']['type']) {
                $toType = 'default';
            }
        }

        $params = [
            "cargo" => [
                'dimension' => [
                    "volume" => $rawBodyDecoded['volume'],
                    "quantity" => 1,
                    "weight" => $rawBodyDecoded['weight'],
                ]
            ],
            "gateway" => [
                "dispatch" => [
                    "point" => [
                        "location" => $rawBodyDecoded['from']['guid'],
                        "terminal" => $fromType,
                    ],
                ],
                "destination" => [
                    "point" => [
                        "location" => $rawBodyDecoded['to']['guid'],
                        "terminal" => $toType,
                    ],
                ],
            ],
        ];

        $response = ExternalDataFetcher::requestPriceDataFromProvider('price', 'get', $params);

        $basePriceResults = $response['response']['basePrice'];
        $priceResults = $response['response']['price'];
        $deliveryString = 'от ' . $response['response']['deliveryTime']['from'] . ' до ' . $response['response']['deliveryTime']['to'] . ' дней';

        $searchResultDto['base'] = $basePriceResults;
        $searchResultDto['total'] = $priceResults;
        $searchResultDto['cost'] = [
            'currency' => [
                'list' => [
                    'RU' => true,
                ],
                'RU' => true,
        ]];

        $searchResultDto['delivery'] = $deliveryString;
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $searchResultDto;

        return $response;
    }
}
