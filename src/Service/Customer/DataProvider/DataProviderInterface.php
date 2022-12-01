<?php

declare(strict_types=1);

namespace App\Service\Customer\DataProvider;

use Generator;

interface DataProviderInterface
{
    /**
     * @param int $limit
     *
     * @return Generator
     */
    public function getData(int $limit = 100): Generator;
}
