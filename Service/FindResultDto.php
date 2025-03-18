<?php

namespace app\Service;

class FindResultDto
{

    private FindResultLocationDTO $findResultLocationDTO;

    private FindLocationPhoneDto $findResultPhoneDTO;

    public function getFindResultLocationDTO(): FindResultLocationDTO
    {
        return $this->findResultLocationDTO;
    }

    public function getFindResultPhoneDTO(): FindLocationPhoneDto
    {
        return $this->findResultPhoneDTO;
    }

    public function __construct(
        FindResultLocationDTO $findResultLocationDTO,
        FindLocationPhoneDto $findResultPhoneDTO
    ) {
        $this->findResultLocationDTO = $findResultLocationDTO;
        $this->findResultPhoneDTO = $findResultPhoneDTO;
    }
}