<?php

declare(strict_types=1);

namespace App\Service\Customer;

use App\Dto\CustomerDto;
use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\Customer\DataProvider\DataProviderInterface;

class CustomerImporter implements CustomerImporterInterface
{
    public function __construct(
        protected DataProviderInterface $dataProvider,
        protected EntityManagerInterface $entityManager
    ) {
    }

    public function import(int $limit = 100): void
    {
        foreach ($this->dataProvider->getData($limit) as $customer) {
            $this->saveCustomer($customer);
        }

        $this->entityManager->flush();
    }

    protected function saveCustomer(CustomerDto $customerDto): void
    {
        $existsCustomer = $this->entityManager->getRepository(Customer::class)->findOneBy(
            ['email' => $customerDto->email]
        );

        $customerEntity = $existsCustomer ?: new Customer();

        $customerEntity
            ->setFirstName($customerDto->name->firstName)
            ->setLastName($customerDto->name->lastName)
            ->setCity($customerDto->location->city)
            ->setCountry($customerDto->location->country)
            ->setEmail($customerDto->email)
            ->setPhone($customerDto->phone)
            ->setGender($customerDto->gender)
            ->setUsername($customerDto->login->username);

        $this->entityManager->persist($customerEntity);
    }
}
