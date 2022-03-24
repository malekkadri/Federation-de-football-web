<?php

namespace App\Repository;

use App\Entity\Badge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Badge|null find($id, $lockMode = null, $lockVersion = null)
 * @method Badge|null findOneBy(array $criteria, array $orderBy = null)
 * @method Badge[]    findAll()
 * @method Badge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BadgeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Badge::class);
    }
    public function findEntitiesByString($str){
    return $this->getEntityManager()
        ->createQuery(
            'SELECT e
                FROM AppBundle:Entity e
                WHERE e.foo LIKE :str'
        )
        ->setParameter('str', '%'.$str.'%')
        ->getResult();
}
    public function findByResult($nbp)
    {

        $entityManager =$this ->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT b
            FROM  App\Entity\Badge b
            WHERE b.nb <= :nb  order by b.nb desc'
        )->setParameter('nb', $nbp)


        ;

        // returns an array of Product objects
        return $query->getResult();

    }
    public function findByResulta($nbp)
    {

        $entityManager =$this ->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT b
            FROM  App\Entity\Badge b
            WHERE b.nb >= :nb  order by b.nb asc'
        )->setParameter('nb', $nbp)


        ;

        // returns an array of Product objects
        return $query->getResult();

    }

    // /**
    //  * @return Badge[] Returns an array of Badge objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Badge
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
