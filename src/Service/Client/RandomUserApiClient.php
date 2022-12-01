<?php

declare(strict_types=1);

namespace App\Service\Client;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RandomUserApiClient implements ApiClientInterface
{
    public function __construct(protected HttpClientInterface $client, protected string $apiUrl)
    {
    }

    public function fetchData(array $query = []): array
    {
        $url = $query ? sprintf('%s?%s', $this->apiUrl, http_build_query($query)) : $this->apiUrl;

        return $this->client->request(Request::METHOD_GET, $url)->toArray();
    }
}
