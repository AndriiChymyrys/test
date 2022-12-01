<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\SerializedName;

class CustomerNameDto
{
    #[SerializedName('first')]
    public string $firstName;

    #[SerializedName('last')]
    public string $lastName;
}