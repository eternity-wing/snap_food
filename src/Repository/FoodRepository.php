<?php

namespace App\Repository;

use App\Entity\Food;
use App\Entity\Ingredient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Food|null find($id, $lockMode = null, $lockVersion = null)
 * @method Food|null findOneBy(array $criteria, array $orderBy = null)
 * @method Food[]    findAll()
 * @method Food[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FoodRepository extends ServiceEntityRepository
{
    use PurgerTrait;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Food::class);
    }

    // /**
    //  * @return Food[] Returns an array of Food objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Food
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    /**
     * @param int|null $limit
     * @return Food[]
     */
    public function findAvailableFoods(?int $limit=20): array
    {
        $qb = $this->createQueryBuilder('f');
        $qb->innerJoin('f.ingredients', 'fi');
        $qb->addSelect('MIN(i.stock) AS stock , MIN(i.expiresAt) AS expiresAt, MIN(i.bestBefore) AS bestBefore')
            ->from(Ingredient::class, 'i');
        $qb->where('fi.id = i.id');
        $qb->groupBy('f.id');
        $qb->having('stock > 0');
        $qb->andHaving('expiresAt > CURRENT_TIMESTAMP()');
        $qb->orderBy('bestBefore', 'DESC');
        return $qb->getQuery()->setMaxResults($limit)->getResult();
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    public function findNumberOfUnavailableIngredients(int $foodId): int{
        $parameters = ['foodId' => $foodId, 'zero' => 0];
        $qb = $this->createQueryBuilder('f');
        $qb->select('COUNT(fi.id)');
        $qb->where('f.id = :foodId');
        $qb->innerJoin('f.ingredients', 'fi');
        $qb->andWhere('fi.stock = :zero');
        $qb->andWhere('fi.expiresAt < CURRENT_TIMESTAMP()');
        $qb->setParameters($parameters);
        return $qb->getQuery()->getSingleScalarResult();
    }

}
