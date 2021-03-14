<?php

namespace App\Repository;

use App\Entity\ImagesCarouselAccueil;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImagesCarouselAccueil|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImagesCarouselAccueil|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImagesCarouselAccueil[]    findAll()
 * @method ImagesCarouselAccueil[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImagesCarouselAccueilRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImagesCarouselAccueil::class);
    }

    // /**
    //  * @return ImagesCarouselAccueil[] Returns an array of ImagesCarouselAccueil objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ImagesCarouselAccueil
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
