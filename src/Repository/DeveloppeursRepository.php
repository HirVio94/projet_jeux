<?php

namespace App\Repository;

use App\Entity\Developpeurs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Developpeurs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Developpeurs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Developpeurs[]    findAll()
 * @method Developpeurs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeveloppeursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Developpeurs::class);
    }

    // /**
    //  * @return Developpeurs[] Returns an array of Developpeurs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Developpeurs
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
