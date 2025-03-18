<?php

namespace app\Service;

class FindLocationPhoneDto
{
    private $phones;

    public function getPhones()
    {
        return $this->phones;
    }

    private function __construct($array) {
        $this->phones = $array['phones'];
    }

    public static function fromArray(array $array)
    {
        return new self($array);
    }

    public function toArray(): array
    {
        return [
            'phones' => $this->phones,
        ];
    }
}