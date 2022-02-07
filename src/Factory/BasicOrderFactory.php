<?php

namespace App\Factory;

use App\Entity\Food;
use App\Entity\Order;

class BasicOrderFactory extends OrderFactory
{
    public static function create(Food $food, int $userId): Order{
        $order = new Order();
        $order->setFood($food);
        $order->setUserId($userId);
        $order->setCreatedAt(new \DateTimeImmutable('now'));
        return $order;
    }
}