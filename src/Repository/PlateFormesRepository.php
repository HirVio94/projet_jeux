<?php

namespace App\Repository;

use App\Entity\PlateFormes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlateFormes|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlateFormes|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlateFormes[]    findAll()
 * @method PlateFormes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlateFormesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlateFormes::class);
    }

    // /**
    //  * @return PlateFormes[] Returns an array of PlateFormes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PlateFormes
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
