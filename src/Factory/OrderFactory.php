<?php

namespace App\Factory;

use App\Entity\Food;
use App\Entity\Order;

abstract class OrderFactory
{
    abstract public static function create(Food $food, int $userId): Order;
}