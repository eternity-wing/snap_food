<?php

namespace App\Service\OrderProcessor;

use App\Entity\Order;

interface OrderProcessorInterface
{
    public function process(int $foodId, int $userId): Order;
}