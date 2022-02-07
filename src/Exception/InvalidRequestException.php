<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Throwable;

class InvalidRequestException extends BadRequestException
{
    function __construct($message = "", $code = 0, Throwable $previous = null, protected ?array $errors)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}