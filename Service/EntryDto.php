<?php

namespace app\Service;

class EntryDto
{
    private string $providerObject;

    public function getProviderObject(): string
    {
        return $this->providerObject;
    }

    public function getProviderAction(): string
    {
        return $this->providerAction;
    }

    public function getRequestParams(): array
    {
        return $this->requestParams;
    }

    private string $providerAction;
    private array $requestParams;

    /**
     * @param string $providerObject
     * @param string $providerAction
     * @param array $requestParams
     */
    public function __construct(string $providerObject, string $providerAction, array $requestParams)
    {
        $this->providerObject = $providerObject;
        $this->providerAction = $providerAction;
        $this->requestParams = $requestParams;
    }
}