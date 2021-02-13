<?php

namespace App\Repository;

use App\Entity\Animations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Animations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Animations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Animations[]    findAll()
 * @method Animations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animations::class);
    }

    // /**
    //  * @return Animations[] Returns an array of Animations objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Animations
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
