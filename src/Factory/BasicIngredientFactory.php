<?php

namespace App\Factory;

use App\Entity\Ingredient;

class BasicIngredientFactory extends IngredientFactory
{
    public static function create(string $title, \DateTime $expiresAt, \DateTime $bestBefore, int $stock): Ingredient
    {
        $ingredient = new Ingredient();
        $ingredient->setTitle($title);
        $ingredient->setExpiresAt($expiresAt);
        $ingredient->setBestBefore($bestBefore);
        $ingredient->setStock($stock);
        return $ingredient;
    }
}