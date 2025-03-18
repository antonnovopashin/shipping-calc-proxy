<?php

namespace app\Service;

class ProviderLocationItemsDtoCollection
{
    private array $items;

    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }
}