<?php

namespace app\Service;

use Yii;

class ResponseRenderer
{
    public static function makeFindLocationResponse(FindResultDto $findLocationResultDto)
    {
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $findResult['location'] = $findLocationResultDto->getFindResultLocationDTO()->toArray();
        $findResult['phones'] = $findLocationResultDto->getFindResultPhoneDTO()->toArray();
        $response->data = $findResult;

        return $response;
    }

    public static function makeSearchLocationResponse(array $searchLocationResultDtoCollection)
    {
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;

        $result = [];

        foreach ($searchLocationResultDtoCollection as $searchLocationResultDto) {
            $searchResultDto = [];
            $searchResultDto['guid'] = $searchLocationResultDto->getGuid();
            $searchResultDto['name'] = $searchLocationResultDto->getName();
            $searchResultDto['country'] = $searchLocationResultDto->getCountry();
            $searchResultDto['type'] = $searchLocationResultDto->getType();
            $searchResultDto['coordinates'] = $searchLocationResultDto->getCoordinates();
            $searchResultDto['hasTerminal'] = $searchLocationResultDto->isHasTerminal();
            $result[] = $searchResultDto;
        }

        $response->data = $result;

        return $response;
    }

}