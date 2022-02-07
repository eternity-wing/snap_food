<?php

namespace App\Service\OrderProcessor;

use App\Entity\Ingredient;
use App\Exception\IngredientHasExpiredException;
use App\Exception\IngredientOutOfStockException;
use App\Exception\InvalidRequestException;

class IngredientConsumer implements IngredientConsumerInterface
{

    /**
     * @throws InvalidRequestException
     */
    public function consume(Ingredient $ingredient){
        $this->validateConsumption($ingredient);
        $ingredient->setStock($ingredient->getStock() - 1);
    }

    /**
     * @throws InvalidRequestException
     */
    public function validateConsumption(Ingredient $ingredient){
        if($ingredient->getStock() == 0){
            throw new IngredientOutOfStockException();
        }
        if($ingredient->getExpiresAt() < new \DateTime('now')){
            throw new IngredientHasExpiredException();
        }
    }

}