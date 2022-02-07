<?php

namespace App\Repository;

use App\Entity\Ingredient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ingredient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ingredient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ingredient[]    findAll()
 * @method Ingredient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngredientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ingredient::class);
    }

    // /**
    //  * @return Ingredient[] Returns an array of Ingredient objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ingredient
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @param int|null $limit
     * @return Ingredient[]
     */
    public function findOutOfStockIngredients(?int $limit=20): array {
        $parameters = ['now' => new \DateTime('now'), 'zero' => 0];
        $qb = $this->createQueryBuilder('i');
        $qb->where('i.expiresAt > :now');
        $qb->andWhere('i.stock = :zero');
        $qb->setParameters($parameters);
        return $qb->getQuery()->setMaxResults($limit)->getResult();
    }
    /**
     * @return Ingredient[]
     */
    public function findByFoodId(int $foodId): array {
        $qb = $this->createQueryBuilder('i');
        $qb->innerJoin('i.foods', 'f');
        $qb->where('f.id = :foodId');
        $qb->setParameters(['foodId' => $foodId]);
        return $qb->getQuery()->getResult();
    }
}
