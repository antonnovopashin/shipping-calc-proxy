<?php

namespace app\Service;

class ProviderLocationItemDto
{

    /**
     * @var mixed
     */
    private $guid;
    /**
     * @var mixed
     */
    private $name;
    /**
     * @var mixed
     */
    private $type;
    /**
     * @var mixed
     */
    private $coordinates;
    /**
     * @var mixed
     */
    private $country;
    /**
     * @var mixed
     */
    private $fias;
    /**
     * @var mixed
     */
    private $region_str;
    private ?ProviderDefaultTerminalDto $default_terminal;

    /**
     * @return mixed
     */
    public function getGuid()
    {
        return $this->guid;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return mixed
     */
    public function getFias()
    {
        return $this->fias;
    }

    /**
     * @return mixed
     */
    public function getRegionStr()
    {
        return $this->region_str;
    }

    public function getDefaultTerminal(): ?ProviderDefaultTerminalDto
    {
        return $this->default_terminal;
    }

    public function __construct($location)
    {
        $default_terminal = null;

        if (null !== $location['default_terminal']) {
            $default_terminal = new ProviderDefaultTerminalDto($location['default_terminal']);
        }

        $this->guid = $location['guid'];
        $this->name = $location['name'];
        $this->type = $location['type'];
        $this->coordinates = $location['coordinates'];
        $this->country = $location['country'];
        $this->fias = $location['fias'];
        $this->region_str = $location['region_str'];
        $this->default_terminal = $default_terminal;

    }
}