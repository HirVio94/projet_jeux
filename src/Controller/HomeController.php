<?php

namespace App\Controller;

use App\Entity\Genres;
use App\Repository\ClassificationsRepository;
use App\Repository\DeveloppeursRepository;
use App\Repository\GenresRepository;
use App\Repository\JeuxRepository;
use App\Repository\PlateFormesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(JeuxRepository $jeuxRepository): Response
    {
        $tabJeux = $jeuxRepository->findAll();

        foreach ($tabJeux as $jeux) {
           /*  $devId = $jeux->getDeveloppeur()->getId();
            $dev = $developpeursRepository->findOneBy(['id' => $devId]);
            $classificationId = $jeux->getClassification()->getId();
            $classification = $classificationsRepository->findOneBy(['id' => $classificationId]);
            $tabGenre = $genresRepository->findAllByIdJeu($jeux->getId());
            foreach($tabGenre as $genre){
                
                $jeux->addGenre($genre);
            }
            $genre = new Genres();
            $jeux->addGenre($genre);
            dump($jeux->getGenre());
            die();
            $jeux->setDeveloppeur($dev)->setClassification($classification); */

            $classification = $jeux->getClassification()->getLibelle();
            $dev = $jeux->getDeveloppeur()->getLibelle();
            $genres = $jeux->getGenre();
            foreach($genres as $genre){
                $genre->getLibelle();
            }
            $plateFormes = $jeux->getPlateForme();
            foreach($plateFormes as $plateForme){
                $plateForme->getLibelle();
            }
        }

        return $this->render('home/index.html.twig', [
            'tabJeux' => $tabJeux,
        ]);
    }
}
