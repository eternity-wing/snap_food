<?php

namespace App\Service\DataInitializer;

use App\Entity\Food;
use App\Entity\Ingredient;
use App\Entity\Order;
use App\Service\FixtureLoader\FoodFixture;
use App\Service\FixtureLoader\IngredientFixture;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Lock\Store\SemaphoreStore;

class BasicDataInitializer implements DataInitializerInterface
{

    const LOCK_KEY = 'data-initializer-lock';

    private SemaphoreStore $store;
    private LockFactory $factory;

    public function __construct(private ManagerRegistry $registry, private FoodFixture $foodFixture, private IngredientFixture $ingredientFixture)
    {
        $this->store = new SemaphoreStore();
        $this->factory = new LockFactory($this->store);
    }


    public function initialize(): void
    {
        $lock = $this->factory->createLock(self::LOCK_KEY);

        if ($lock->acquire()) {
            $this->purgeTables();
            $this->loadFixtures();
            $lock->release();
        }
    }
    public function purgeTables(){
        $this->registry->getRepository(Order::class)->clearAll();
        $this->registry->getRepository(Food::class)->clearAll();
        $this->registry->getRepository(Ingredient::class)->clearAll();
    }

    public function loadFixtures(){
        $this->ingredientFixture->load();
        $this->foodFixture->load();
    }
}