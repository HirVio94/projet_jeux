<?php

namespace App\Controller;

use App\Entity\Jeux;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JeuxController extends AbstractController
{
    /**
     * @Route("/jeux-{id}", name="jeux.focus")
     */
    public function index(Jeux $jeux): Response
    {
        $jeuxId = $jeux->getId();
        $page = 'jeuxFocus';
        return $this->render('jeux/index.html.twig', [
            'controller_name' => 'JeuxController',
            'section' => 'client',
            'jeux' => $jeux, 
            'jeuxId' => $jeuxId,
            'page' => $page
        ]);
    }
}
