<?php

declare(strict_types=1);

namespace App\Service\Client;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RandomUserApiClient implements ApiClientInterface
{
    /**
     * @param HttpClientInterface $client
     * @param string $apiUrl
     */
    public function __construct(protected HttpClientInterface $client, protected string $apiUrl)
    {
    }

    /**
     * {@inheritDoc}
     *
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function fetchData(array $query = []): array
    {
        $url = $query ? sprintf('%s?%s', $this->apiUrl, http_build_query($query)) : $this->apiUrl;

        return $this->client->request(Request::METHOD_GET, $url)->toArray();
    }
}
