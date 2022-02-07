<?php

namespace App\Factory;

use App\Entity\Ingredient;

abstract class IngredientFactory
{
    abstract public static function create(string $title, \DateTime $expiresAt, \DateTime $bestBefore, int $stock): Ingredient;
}