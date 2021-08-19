<?php

namespace App\Repository;

use App\Entity\Carroussel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Carroussel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Carroussel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Carroussel[]    findAll()
 * @method Carroussel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarrousselRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Carroussel::class);
    }

    // /**
    //  * @return Carroussel[] Returns an array of Carroussel objects
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
    public function findOneBySomeField($value): ?Carroussel
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
