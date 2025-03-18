<?php

namespace app\Service;

class FindResultLocationDTO
{
    private string $guid;
    private string $name;
    private string $country;
    private string $type;
    private array $coordinates;
    private bool $hasTerminal;

    public function getGuid(): string
    {
        return $this->guid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getCoordinates(): array
    {
        return $this->coordinates;
    }

    public function isHasTerminal(): bool
    {
        return $this->hasTerminal;
    }

    private function __construct($array) {
        $this->guid = $array['guid'];
        $this->name = $array['name'];
        $this->country = $array['country'];
        $this->type = $array['type'];
        $this->coordinates = $array['coordinates'];
        $this->hasTerminal = $array['hasTerminal'];
    }

    public static function fromArray(array $array): FindResultLocationDTO
    {
        return new self($array);
    }

    public function toArray(): array
    {
        return [
            'guid' => $this->guid,
            'name' => $this->name,
            'country' => $this->country,
            'type' => $this->type,
            'coordinates' => $this->coordinates,
            'hasTerminal' => $this->hasTerminal,
        ];
    }
}