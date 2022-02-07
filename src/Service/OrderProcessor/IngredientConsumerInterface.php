<?php

namespace App\Service\OrderProcessor;

use App\Entity\Ingredient;

interface IngredientConsumerInterface
{
    public function consume(Ingredient $ingredient);
}