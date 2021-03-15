<?php

namespace App\Repository;

use App\Entity\Carousels;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Carousels|null find($id, $lockMode = null, $lockVersion = null)
 * @method Carousels|null findOneBy(array $criteria, array $orderBy = null)
 * @method Carousels[]    findAll()
 * @method Carousels[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarouselsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Carousels::class);
    }

    // /**
    //  * @return Carousels[] Returns an array of Carousels objects
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
    public function findOneBySomeField($value): ?Carousels
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
