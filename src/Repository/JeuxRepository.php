<?php

namespace App\Repository;

use App\Entity\Jeux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Jeux|null find($id, $lockMode = null, $lockVersion = null)
 * @method Jeux|null findOneBy(array $criteria, array $orderBy = null)
 * @method Jeux[]    findAll()
 * @method Jeux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JeuxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Jeux::class);
    }
    public function findAllAndAllFields()
    {

        $tabJeux = $this->findAll();

        foreach ($tabJeux as $jeux) {


            $classification = $jeux->getClassification()->getLibelle();
            $dev = $jeux->getDeveloppeur()->getLibelle();
            $genres = $jeux->getGenre();
            foreach ($genres as $genre) {
                $genre->getLibelle();
            }
            $plateFormes = $jeux->getPlateForme();
            foreach ($plateFormes as $plateForme) {
                $plateForme->getLibelle();
            }
            $avis = $jeux->getAvis();
            $moyenneNotes = 0;

            foreach ($avis as $avi) {
                $note = $avi->getNote();
                $message = $avi->getMessage();
                $moyenneNotes += $note;
            }
            if (count($avis) > 0) {
                $nbrNotes = count($avis);
                $moyenneNotes = $moyenneNotes / $nbrNotes;
                $jeux->setNoteMoyenne($moyenneNotes);
            }else{
                $jeux->setNoteMoyenne(0); 
            }
        }
        return $tabJeux;
    }

    // /**
    //  * @return Jeux[] Returns an array of Jeux objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Jeux
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
