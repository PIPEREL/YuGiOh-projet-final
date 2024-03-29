<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Categorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorie[]    findAll()
 * @method Categorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    // /**
    //  * @return Categorie[] Returns an array of Categorie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Categorie
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findSoon()
    {
        return $this->createQueryBuilder('soon')
        ->andWhere('soon.date_parution > :today')
        ->setParameter('today', date("Y-m-d"))
        ->orderBy("soon.date_parution", 'ASC')
        ->setMaxResults(2)
        ->getQuery()
        ->getResult()
        ;
    }

    public function findNouveau()
    {
        return $this->createQueryBuilder('nouveau')
        ->andWhere('nouveau.date_parution <= :today')
        ->setParameter('today', date("Y-m-d"))
        ->orderBy("nouveau.date_parution", 'Desc')
        ->setMaxResults(2)
        ->getQuery()
        ->getResult()
        ;
    }

    public function findByWord($value){
        return $this->createQueryBuilder('word')
        ->andWhere('word.nom LIKE :value')
        ->setParameter('value', '%'.$value.'%')
        ->orderBy('word.id', 'DESC')
        ->getQuery()
        ->getResult()
        ;
    }

}
