<?php

namespace App\Tests;

use App\Dto\CustomerDto;
use App\Dto\CustomerLocationDto;
use App\Dto\CustomerLoginDto;
use App\Dto\CustomerNameDto;

class CustomerDtoFactory
{
    public static function getExpectedCustomerDto(): CustomerDto
    {
        $dto = new CustomerDto();
        $dto->gender = 'female';
        $dto->email = 'jennie.nichols@example.com';
        $dto->phone = '(272) 790-0888';

        $login = new CustomerLoginDto();
        $login->username = 'yellowpeacock117';

        $dto->login = $login;

        $location = new CustomerLocationDto();
        $location->country = 'United States';
        $location->city = 'Billings';

        $dto->location = $location;

        $name = new CustomerNameDto();
        $name->firstName = 'Jennie';
        $name->lastName = 'Nichols';

        $dto->name = $name;

        return $dto;
    }
}
