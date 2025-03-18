<?php

namespace app\Service;

class ProviderDefaultTerminalDto
{
    /**
     * @var string
     */
    private $guid;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string|null
     */
    private $location_guid;
    /**
     * @var string|null
     */
    private $location_country;
    /**
     * @var string|null
     */
    private $location_name;

    /**
     * @return mixed|string
     */
    public function getGuid()
    {
        return $this->guid;
    }

    /**
     * @return mixed|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed|string|null
     */
    public function getLocationGuid()
    {
        return $this->location_guid;
    }

    /**
     * @return mixed|string|null
     */
    public function getLocationCountry()
    {
        return $this->location_country;
    }

    /**
     * @return mixed|string|null
     */
    public function getLocationName()
    {
        return $this->location_name;
    }


    /**
     * @param mixed $default_terminal
     */
    public function __construct($default_terminal)
    {
        $this->guid = $default_terminal['guid'];
        $this->name = $default_terminal['name'];
        $this->location_guid = array_key_exists('location_guid', $default_terminal) ?$default_terminal['location_guid'] : null;
        $this->location_country = array_key_exists('location_country', $default_terminal) ?$default_terminal['location_country'] : null;
        $this->location_name = array_key_exists('location_name', $default_terminal) ?$default_terminal['location_name'] : null;
    }
}