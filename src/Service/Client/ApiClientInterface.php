<?php

declare(strict_types=1);

namespace App\Service\Client;

interface ApiClientInterface
{
    /**
     * @param array<string, string> $query
     *
     * @return array<array<string, string>>
     */
    public function fetchData(array $query = []): array;
}
