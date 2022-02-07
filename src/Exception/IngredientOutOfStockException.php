<?php

namespace App\Exception;

use Throwable;

class IngredientOutOfStockException extends InvalidRequestException
{
    public function __construct($message = "Ingredients are out of stock", $code = 0, Throwable $previous = null, ?array $errors=['ingredients' => 'Out of stock'])
    {
        parent::__construct($message, $code, $previous, $errors);
    }
}