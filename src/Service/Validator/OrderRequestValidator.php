<?php

namespace App\Service\Validator;


use App\Entity\Food;
use App\Exception\InvalidRequestException;
use Doctrine\Persistence\ManagerRegistry;

class OrderRequestValidator implements OrderRequestValidatorInterface
{
    public function __construct(private ManagerRegistry $registry)
    {
    }

    public function validate(int $foodId, int $userId)
    {
        $this->validateFoodAvailable($foodId);
    }

    private function validateFoodAvailable(int $foodId)
    {
        $this->validateFoodExist($foodId);
        $this->validateFoodIngredients($foodId);
    }

    private function validateFoodExist(int $foodId)
    {
        $food = $this->registry->getRepository(Food::class)->find($foodId);
        if (!$food) {
            throw new InvalidRequestException(code: 404, errors: ['food_id' => 'Invalid foodId']);
        }
    }

    private function validateFoodIngredients(int $foodId)
    {
        $unavailableIngredientsCount = $this->registry->getRepository(Food::class)->findNumberOfUnavailableIngredients($foodId);
        if ($unavailableIngredientsCount > 0) {
            throw new InvalidRequestException(code: 400, errors: ['ingredients' => 'ingredients are not available']);
        }
    }
}