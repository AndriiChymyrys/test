<?php

declare(strict_types=1);

namespace App\Tests\Integration\Service;

use App\Service\Client\ApiClientInterface;
use App\Service\Customer\DataProvider\ApiDataProvider;
use App\Tests\CustomerDtoFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Serializer\SerializerInterface;

class ApiDataProviderTest extends KernelTestCase
{
    public function testCustomerDtoGeneration()
    {
        $apiClientMock = $this->createMock(ApiClientInterface::class);

        $apiClientMock->method('fetchData')
            ->willReturn([
                'results' => [
                    [
                        'gender' => 'female',
                        'name' => [
                            'first' => 'Jennie',
                            'last' => 'Nichols'
                        ],
                        'location' => [
                            'city' => 'Billings',
                            'country' => 'United States',
                        ],
                        'email' => 'jennie.nichols@example.com',
                        'login' => [
                            'username' => 'yellowpeacock117'
                        ],
                        'phone' => '(272) 790-0888',
                    ]
                ]
            ]);

        $dataProvider = new ApiDataProvider($apiClientMock, static::getContainer()->get(SerializerInterface::class));

        $generator = $dataProvider->getData();

        $this->assertEquals(CustomerDtoFactory::getExpectedCustomerDto(), $generator->current());
    }
}
