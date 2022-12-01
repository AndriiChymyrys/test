<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Service\Client\RandomUserApiClient;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RandomUserApiClientTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testUrlGeneration(array $query, string $expected)
    {
        $clientMock = $this->createMock(HttpClientInterface::class);

        $clientMock
            ->expects($this->once())
            ->method('request')
            ->with('GET', $this->equalTo($expected));

        $apiClient = new RandomUserApiClient($clientMock, 'http://test/');

        $apiClient->fetchData($query);
    }

    public function dataProvider(): array
    {
        return [
            [[], 'http://test/'],
            [['param1' => 'value'], 'http://test/?param1=value'],
        ];
    }
}
