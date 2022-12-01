<?php

declare(strict_types=1);

namespace App\Service\Customer\DataProvider;

use Generator;
use App\Dto\CustomerDto;
use App\Service\Client\ApiClientInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ApiDataProvider implements DataProviderInterface
{
    /**
     * @param ApiClientInterface $apiClient
     * @param SerializerInterface $serializer
     */
    public function __construct(protected ApiClientInterface $apiClient, protected SerializerInterface $serializer)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getData(int $limit = 100): Generator
    {
        $items = $this->apiClient->fetchData(['results' => $limit, 'nat' => 'AU']);

        foreach ($items['results'] as $item) {
            yield $this->serializer->deserialize(json_encode($item), CustomerDto::class, 'json');
        }
    }
}
