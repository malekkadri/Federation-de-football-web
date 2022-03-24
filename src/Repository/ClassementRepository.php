<?php

namespace App\Repository;

use App\Entity\Classement;
use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Classement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Classement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Classement[]    findAll()
 * @method Classement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Classement::class);
    }


    public function findByResultatc($id)
    {

        $entityManager =$this ->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT club
            FROM  App\Entity\Classement classement
             join App\Entity\Club club 
            with club.id = classement.club
            WHERE classement.tournoi = :id'
            /*
            'SELECT c
            FROM  App\Entity\Classement g
            inner join App\Entity\Club c
            on c.id = g.id
            WHERE g.tournoi = :id '
            */
            /*

            */
        )->setParameter('id', $id);


        return $query->getResult();

    }
    /**
    //  * @return Game[] Returns an array of Game objects
    //  */

    public function findByResultat($idc,$idt)
    {
        /*
        $entityManager =$this ->getEntityManager();
        $query=$entityManager->createQueryBuilder('g* ')
            ->Where('g.club1_id = :val ')
            ->andWhere('and r1 > r2')
            ->setParameter('val', 1)
            ->getQuery()
            ->getResult();
        return $query;
*/
        $entityManager =$this ->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT g
            FROM  App\Entity\Game g
            WHERE g.club1 = :idc and g.r1 > g.r2
            and  g.tournoi = :idt')
        ->setParameter('idc', $idc)
        ->setParameter('idt', $idt);


        // returns an array of Product objects
        return $query->getResult();;

    }
    public function findByResultatn($idt)
    {

        $entityManager =$this ->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT id
            FROM  App\Entity\Tournoi 
            WHERE tournoi.id= :idc '
        )->setParameter('idc', $idt);

        // returns an array of Product objects
        return $query->getResult();;

    }
    public function findByResultat1($idc,$idt)
    {

        $entityManager =$this ->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT g
            FROM  App\Entity\Game g
            WHERE g.club2 = :idc and g.r2 > g.r1
            and  g.tournoi = :idt')
            ->setParameter('idc', $idc)
            ->setParameter('idt', $idt);

        // returns an array of Product objects
        return $query->getResult();

    }
    public function findByResultat2($idc,$idt)
    {
        /*
        $entityManager =$this ->getEntityManager();
        $query=$entityManager->createQueryBuilder('g* ')
            ->Where('g.club1_id = :val ')
            ->andWhere('and r1 > r2')
            ->setParameter('val', 1)
            ->getQuery()
            ->getResult();
        return $query;
*/
        $entityManager =$this ->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT g
            FROM  App\Entity\Game g
            WHERE (g.club2 = :idc or g.club1 = :idc ) and g.r2 = g.r1 
            and  g.tournoi = :idt')
            ->setParameter('idc', $idc)
            ->setParameter('idt', $idt);

        // returns an array of Product objects
        return $query->getResult();;

    }
     /**
    //  * @return Classement[] Returns an array of Classement objects
    //  */

    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id = :val')
            ->setParameter('val', '%'.$value.'%')
            ->orderBy('c.id', 'ASC')

            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Classement
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
