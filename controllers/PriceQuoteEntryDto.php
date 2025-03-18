<?php

namespace app\controllers;

class PriceQuoteEntryDto
{

    /**
     * @param SenderPlaceEntryDto $senderPlaceEntryDto
     * @param DestinationEntryDto $destinationEntryDto
     * @param float $volume
     * @param float $weight
     */
    public function __construct(\app\controllers\SenderPlaceEntryDto $senderPlaceEntryDto,
                                \app\controllers\DestinationEntryDto $destinationEntryDto,
                                $volume,
                                $weight)
    {
    }
}