<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Entity\Customer;
use App\Service\Customer\CustomerImporter;
use App\Service\Customer\DataProvider\DataProviderInterface;
use App\Tests\CustomerDtoFactory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;

class CustomerImporterTest extends TestCase
{
    protected $entityManagerMock;
    protected $dataProviderMock;
    protected $entityRepositoryMock;

    public function setUp(): void
    {
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $this->dataProviderMock = $this->createMock(DataProviderInterface::class);
        $this->entityRepositoryMock = $this->createMock(EntityRepository::class);

        $this->entityManagerMock
            ->expects($this->once())
            ->method('getRepository')
            ->with(Customer::class)
            ->willReturn($this->entityRepositoryMock);

        $this->entityManagerMock
            ->expects($this->once())
            ->method('flush');

        $this->entityManagerMock
            ->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(Customer::class));

        $this->dataProviderMock
            ->method('getData')
            ->with($this->equalTo(200))
            ->willReturnCallback(fn() => yield CustomerDtoFactory::getExpectedCustomerDto());
    }

    public function testAddExistCustomer()
    {
        $this->entityRepositoryMock
            ->expects($this->once())
            ->method('findOneBy')
            ->willReturn(new Customer());

        $importer = new CustomerImporter($this->dataProviderMock, $this->entityManagerMock);

        $importer->import(200);
    }

    public function testAddNotExistCustomer()
    {
        $this->entityRepositoryMock
            ->expects($this->once())
            ->method('findOneBy')
            ->willReturn(null);

        $importer = new CustomerImporter($this->dataProviderMock, $this->entityManagerMock);

        $importer->import(200);
    }
}
