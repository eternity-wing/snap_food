<?php

namespace App\Service\StockSupplier;

use App\Entity\Ingredient;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Lock\Store\SemaphoreStore;


class StockSupplier implements StockSupplierInterface
{
    const OUT_OF_STOCK_CHUNK_SIZE = 1000;
    const LOCK_KEY = 'stock-supplier-lock';
    const RESTOCK_AMOUNT = 4;

    private SemaphoreStore $store;
    private LockFactory $factory;

    public function __construct(private ManagerRegistry $registry)
    {
        $this->store = new SemaphoreStore();
        $this->factory = new LockFactory($this->store);
    }

    public function restock()
    {
        $lock = $this->factory->createLock(self::LOCK_KEY);

        if ($lock->acquire()) {
            $this->restockIngredients();
            $lock->release();
        }
    }

    private function restockIngredients()
    {
        $em = $this->registry->getManager();
        while (count($outOfStockIngredients = $em->getRepository(Ingredient::class)->findOutOfStockIngredients(self::OUT_OF_STOCK_CHUNK_SIZE)) > 0){
            foreach ($outOfStockIngredients as $outOfStockIngredient){
                $outOfStockIngredient->setStock(self::RESTOCK_AMOUNT);
            }
            $em->flush();
        }
    }
}