<?php

declare(strict_types=1);

namespace App\Dto;

class CustomerDto
{
    public CustomerNameDto $name;
    public CustomerLocationDto $location;
    public CustomerLoginDto $login;

    public string $email;
    public string $gender;
    public string $phone;
}
