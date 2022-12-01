<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CustomerRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CustomerController extends AbstractController
{
    #[Route('/customers', name: 'api:customer:all')]
    public function getCustomers(CustomerRepository $customerRepository): JsonResponse
    {
        return $this->json(data: $customerRepository->findAll(), context: ['groups' => ['list']]);
    }

    #[Route('/customer/{customerId}', name: 'api:customer')]
    public function getCustomer(
        int $customerId,
        CustomerRepository $customerRepository
    ): JsonResponse {
        return $this->json(data: $customerRepository->find($customerId), context: ['groups' => ['one']]);
    }
}
