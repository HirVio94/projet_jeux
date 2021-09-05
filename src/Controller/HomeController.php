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
        $tabJeux = $jeuxRepository->findAllAndAllFields();

        return $this->render('home/index.html.twig', [
            'tabJeux' => $tabJeux,
            'section' => 'client',
            'page' => 'accueil'
        ]);
    }
}
