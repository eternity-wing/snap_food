<?php

namespace App\Service\OrderProcessor;

use App\Entity\Food;
use App\Entity\Ingredient;
use App\Entity\Order;
use App\Exception\InvalidRequestException;
use App\Factory\BasicOrderFactory;
use Doctrine\Persistence\ManagerRegistry;

class OrderProcessor implements OrderProcessorInterface
{

    public function __construct(private ManagerRegistry $registry, private IngredientConsumer $ingredientConsumer)
    {
    }

    /**
     * @throws \Exception
     */
    public function process(int $foodId, int $userId): Order
    {
        $em = $this->registry->getManager();
        $em->getConnection()->beginTransaction();
        try {
            $food = $this->registry->getRepository(Food::class)->find($foodId);
            $order = BasicOrderFactory::create($food, $userId);
            $em->persist($order);
            $this->consumeIngredients($food);
            $em->flush();
            $em->getConnection()->commit();
            $em->refresh($order);
            return $order;
        } catch (\Exception $e) {
            $em->getConnection()->rollBack();
            throw $e;
        }
    }

    /**
     * @throws InvalidRequestException
     */
    private function consumeIngredients(Food $food)
    {
        foreach ($this->registry->getRepository(Ingredient::class)->findByFoodId($food->getId()) as $ingredient) {
            $this->ingredientConsumer->consume($ingredient);
        }
    }
}