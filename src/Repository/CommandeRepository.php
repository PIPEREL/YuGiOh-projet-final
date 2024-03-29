<?php

namespace App\Repository;

use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    // /**
    //  * @return Commande[] Returns an array of Commande objects
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

    
    // public function findOneBySomeField($id): ?Commande
    // {
    //     return $this->createQueryBuilder('c')   // SELECT * FROM commande AS c
    //         ->andWhere('c.id = :val')           // WHERE c.id = :val
    //         ->setParameter('val', $id)          // $req->bindValue(':val', $id)
    //         ->getQuery()                        // construit la requête
    //         ->getOneOrNullResult()              // $req->execute()
    //     ;
    // }
    

    
    public function findNouveau()
    {
        return $this->createQueryBuilder('nouveau')
        ->orderBy("nouveau.Date_creation", 'Desc')
        ->setMaxResults(5)
        ->getQuery()
        ->getResult()
        ;
    }


}
