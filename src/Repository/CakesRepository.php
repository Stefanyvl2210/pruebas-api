<?php

namespace App\Repository;

use App\Entity\Cakes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cakes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cakes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cakes[]    findAll()
 * @method Cakes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CakesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cakes::class);
    }

    // /**
    //  * @return Cakes[] Returns an array of Cakes objects
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
    public function findOneBySomeField($value): ?Cakes
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
