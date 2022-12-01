<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\DataFixtures\CustomerFixtures;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class CustomerControllerTest extends WebTestCase
{
    protected AbstractDatabaseTool $databaseTool;

    public function setUp(): void
    {
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        self::ensureKernelShutdown();

        $this->databaseTool->loadFixtures([
            CustomerFixtures::class
        ]);
    }

    public function testGetAllCustomers()
    {
        $client = self::createClient();

        $client->request(Request::METHOD_GET, '/customers');

        $content = $client->getResponse()->getContent();
        self::assertResponseIsSuccessful();

        $data = json_decode($content, true);

        $this->assertNotEmpty($data);
        $this->assertEquals([
            [
                'id' => 1,
                'email' => 'daryl.lambert@example.com',
                'country' => 'Australia',
                'fullName' => 'Daryl Lambert',
            ],
            [
                'id' => 2,
                'email' => 'daryl.lambert@example.com',
                'country' => 'Australia',
                'fullName' => 'Daryl Lambert',
            ]
        ], $data);
    }

    public function testGetOneCustomer()
    {
        $client = self::createClient();

        $client->request(Request::METHOD_GET, '/customers');

        $content = $client->getResponse()->getContent();
        self::assertResponseIsSuccessful();

        $customers = json_decode($content, true);
        $this->assertNotEmpty($customers);

        $client->request(Request::METHOD_GET, '/customer/' . $customers[0]['id']);

        $content = $client->getResponse()->getContent();
        self::assertResponseIsSuccessful();

        $customer = json_decode($content, true);
        $this->assertNotEmpty($customer);

        $this->assertEquals([
            'id' => 1,
            'email' => 'daryl.lambert@example.com',
            'country' => 'Australia',
            'username' => 'ticklishbutterfly378',
            'gender' => 'male',
            'city' => 'Warragul',
            'phone' => '02-9453-3200',
            'fullName' => 'Daryl Lambert',
        ], $customer);
    }
}
