<?php

namespace App\Repository;

use App\Entity\Tournoi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tournoi|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tournoi|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tournoi[]    findAll()
 * @method Tournoi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TournoiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tournoi::class);
    }
    public function findByResultat($idc)
    {

        $entityManager =$this ->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT g
            FROM  App\Entity\Classement g
            WHERE g.club = :idc '
        )->setParameter('idc', $idc);

        // returns an array of Product objects
        return $query->getResult();;

    }

     /**
    //  * @return Tournoi[] Returns an array of Tournoi objects
    //  */

    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.id  like :val')
            ->orWhere('t.nomt like :val')
            ->setParameter('val', '%'.$value.'%')
            ->orderBy('t.id', 'ASC')

            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Tournoi
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
