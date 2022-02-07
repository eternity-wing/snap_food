<?php

namespace App\Repository;

trait PurgerTrait
{
    public function clearAll(){
        $qb = $this->createQueryBuilder('d');
        $qb->delete()->getQuery()->execute();
    }
}