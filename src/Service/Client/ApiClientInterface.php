<?php

declare(strict_types=1);

namespace App\Service\Client;

interface ApiClientInterface
{
    public function fetchData(array $query = []): array;
}
