<?php

namespace App\Exception;

use Throwable;

class IngredientHasExpiredException extends InvalidRequestException
{
    public function __construct($message = "Ingredients are expired", $code = 0, Throwable $previous = null, ?array $errors=['ingredients' => 'expired ingredients'])
    {
        parent::__construct($message, $code, $previous, $errors);
    }
}