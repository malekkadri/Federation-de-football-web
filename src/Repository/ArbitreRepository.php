<?php

namespace App\Repository;

use App\Entity\Arbitre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Arbitre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Arbitre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Arbitre[]    findAll()
 * @method Arbitre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArbitreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Arbitre::class);
    }

    // /**
    //  * @return Arbitre[] Returns an array of Arbitre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Arbitre
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
