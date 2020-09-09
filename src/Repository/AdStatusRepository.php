<?php

namespace App\Repository;

use App\Entity\AdStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AdStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdStatus[]    findAll()
 * @method AdStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdStatus::class);
    }

    // /**
    //  * @return AdStatus[] Returns an array of AdStatus objects
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
    public function findOneBySomeField($value): ?AdStatus
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
