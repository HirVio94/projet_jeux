<?php

namespace App\Repository;

use App\Entity\Classifications;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Classifications|null find($id, $lockMode = null, $lockVersion = null)
 * @method Classifications|null findOneBy(array $criteria, array $orderBy = null)
 * @method Classifications[]    findAll()
 * @method Classifications[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassificationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Classifications::class);
    }

    // /**
    //  * @return Classifications[] Returns an array of Classifications objects
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
    public function findOneBySomeField($value): ?Classifications
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
