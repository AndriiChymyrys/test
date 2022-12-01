<?php

declare(strict_types=1);

namespace App\Service\Customer;

interface CustomerImporterInterface
{
    public function import(int $limit = 100): void;
}
