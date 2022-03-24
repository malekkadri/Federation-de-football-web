<?php

namespace App\Repository;

use App\Entity\Rewards;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Rewards|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rewards|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rewards[]    findAll()
 * @method Rewards[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RewardsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rewards::class);
    }

    // /**
    //  * @return Rewards[] Returns an array of Rewards objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Rewards
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
