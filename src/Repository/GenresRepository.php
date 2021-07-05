<?php

namespace App\Repository;

use App\Entity\Genres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Genres|null find($id, $lockMode = null, $lockVersion = null)
 * @method Genres|null findOneBy(array $criteria, array $orderBy = null)
 * @method Genres[]    findAll()
 * @method Genres[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GenresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Genres::class);
    }

    public function findAllByIdJeu($idJeu){
        $connect = $this->getEntityManager()->getConnection();

        $requete = 'SELECT DISTINCT libelle_genre, id FROM genres NATURAL JOIN jeux_genres WHERE jeux_id = :idJeu ';
        $statement = $connect->prepare($requete);
        // $statement->bindParam('idJeu', $idJeu);
        $genres = $statement->executeQuery(['idJeu' => $idJeu])->fetchAllAssociative();
        $tabGenre = [];
        foreach($genres as $genre){
            $Genre = new Genres();
            $Genre->setId($genre['id'])->setLibelle($genre['libelle_genre']);
            $tabGenre[] = $Genre;
        }
        return $tabGenre;
        
    }

    // /**
    //  * @return Genres[] Returns an array of Genres objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Genres
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
