<?php

namespace App\Repository;

use App\Entity\Produit;
use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\AST\Functions\DateDiffFunction;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    public function searchProduit()
    {
        $query= $this->getEntityManager()->createQuery('select p from App\Entity\Produit p where p.qte=0');
        return $query->getResult();
    }


    public function counts()
    {
        $query= $this->getEntityManager()->createQuery('select count(p) from App\Entity\Produit p   ');
        return $query->getResult();
    }

    public function searchProduit_categorie($id)
    {
        $query= $this->getEntityManager()->createQuery(
            'select p from App\Entity\Produit p  join p.categorie c   where c.id=:id')
            ->setParameter('id',$id);
        return $query->getResult();
    }

    public function filter($id)
    {
        $query= $this->getEntityManager()->createQuery('select p from App\Entity\Produit p join p.categorie c  where c.id=:id order by p.prix ')
        ->setParameter('id',$id);
        return $query->getResult();
    }

    public function filter2($id)
    {
        $query= $this->getEntityManager()->createQuery('select p from App\Entity\Produit p join p.categorie c  where c.id=:id order by p.prix desc')
        ->setParameter('id',$id);
        return $query->getResult();
    }

    public function filter3($id,$c)
    {
        $query= $this->getEntityManager()->createQuery('select p from App\Entity\Produit p join p.categorie c  where c.id=:id and p.couleur=:couleur')
            ->setParameter('id',$id)
            ->setParameters('couleur',$c);

        return $query->getResult();
    }

    public function filter4($id,$c)
    {
        $query= $this->getEntityManager()->createQuery('select p from App\Entity\Produit p join p.categorie c  where c.id=:id and p.couleur=:couleur')
            ->setParameter('id',$id)
        ->setParameter('couleur',$c);
        return $query->getResult();
    }

    public function filter5($id,$c)
    {
        $query= $this->getEntityManager()->createQuery('select p from App\Entity\Produit p join p.categorie c  where c.id=:id and p.couleur=:couleur')
            ->setParameter('id',$id)
            ->setParameter('couleur',$c);
        return $query->getResult();
    }


    public function filter6($id,$c)
    {
        $query= $this->getEntityManager()->createQuery('select p from App\Entity\Produit p join p.categorie c  where c.id=:id and p.couleur=:couleur order by p.prix')
            ->setParameter('id',$id)
            ->setParameter('couleur',$c);
        return $query->getResult();
    }

    public function filter7($id,$c)
    {
        $query= $this->getEntityManager()->createQuery('select p from App\Entity\Produit p join p.categorie c  where c.id=:id and p.couleur=:couleur order by p.prix desc')
            ->setParameter('id',$id)
            ->setParameter('couleur',$c);
        return $query->getResult();
    }

    public function filter8($id,$c)
    {
        $query= $this->getEntityManager()->createQuery('select p from App\Entity\Produit p join p.categorie c  where c.id=:id and p.couleur=:couleur order by p.prix')
            ->setParameter('id',$id)
            ->setParameter('couleur',$c);
        return $query->getResult();
    }

    public function filter9($id,$c)
    {
        $query= $this->getEntityManager()->createQuery('select p from App\Entity\Produit p join p.categorie c  where c.id=:id and p.couleur=:couleur order by p.prix desc')
            ->setParameter('id',$id)
            ->setParameter('couleur',$c);
        return $query->getResult();
    }


    public function dates($now){


        $query= $this->getEntityManager()->createQuery('select p from App\Entity\Produit p ');


        return $query->getResult();

    }


    public function tests($id){

            $query = $this->getEntityManager()->createQuery('select p from App\Entity\Produit p where p.id =:id ')
                ->setParameter('id', $id);

        return $query->getResult();

    }

    /**
     * @return Article[] Returns an array of Article objects
     */

    public function findByExampleField($value)
    {



        return $this->createQueryBuilder('p')
            ->andWhere('p.id  like :val')
            ->orWhere('p.nomP like :val')
            ->setParameter('val', '%'.$value.'%')
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }


    // /**
    //  * @return Produit[] Returns an array of Produit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
