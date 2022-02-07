<?php

namespace App\Service\Validator;

interface OrderRequestValidatorInterface
{
    public function validate(int $foodId, int $userId);
}