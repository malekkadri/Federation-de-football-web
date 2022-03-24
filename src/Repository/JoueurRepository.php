<?php

namespace App\Repository;

use App\Entity\Joueur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Joueur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Joueur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Joueur[]    findAll()
 * @method Joueur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JoueurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Joueur::class);
    }

        public function countEtat()
    {

        $qb = $this->createQueryBuilder('v')
            ->select('COUNT(v.cin) AS joueur, SUBSTRING(v.nbm, 1, 10) AS g')
            ->groupBy('g');
        return $qb->getQuery()
            ->getResult();

    }
    public function findByExampleFieldj($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.nom  like :val')

            ->orWhere('j.nom like :val')
            ->orWhere('j.prenom like :val')
            ->orWhere('j.age like :val')
            ->orWhere('j.nbm like :val')
            ->orWhere('j.nba like :val')
            ->orWhere('j.poste like :val')
            ->orWhere('j.numt like :val')

            ->setParameter('val', '%'.$value.'%')
            ->orderBy('j.cin', 'ASC')

            ->getQuery()
            ->getResult()
            ;
    }
    public function findByResultam()
    {

        $entityManager =$this ->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT j
            FROM  App\Entity\Joueur j
            order by j.nbm desc');

        // returns an array of Product objects
        return $query->getResult();

    }
    public function findByResultaa()
    {

        $entityManager =$this ->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT j
            FROM  App\Entity\Joueur j
            order by j.nba desc'
        )

        ;

        // returns an array of Product objects
        return $query->getResult();

    }

    // /**
    //  * @return Joueur[] Returns an array of Joueur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Joueur
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
