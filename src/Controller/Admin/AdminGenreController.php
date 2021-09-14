<?php

namespace App\Controller\Admin;

use App\Entity\Genres;
use App\Form\GenresType;
use App\Repository\GenresRepository;
use App\Repository\JeuxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/genre")
 */
class AdminGenreController extends AbstractController
{
    /**
     * @Route("/", name="admin.genre", methods={"GET"})
     */
    public function index(GenresRepository $genresRepository): Response
    {
        return $this->render('admin/admin_genre/index.html.twig', [
            'genres' => $genresRepository->findAll(),
            'section' => 'administration',
            'errorDelete' => false
        ]);
    }

    /**
     * @Route("/new", name="admin.genre.new", methods={"GET","POST"})
     */
    public function new(Request $request, GenresRepository $genresRepository): Response
    {
        $genre = new Genres();
        $form = $this->createForm(GenresType::class, $genre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $genreDb = $genresRepository->findOneBy(['libelle_genre' => $genre->getLibelle()]);
            if (!$genreDb) {
                $entityManager->persist($genre);
                $entityManager->flush();
                return $this->redirectToRoute('admin.genre', [], Response::HTTP_SEE_OTHER);
            } else {
                return $this->renderForm('admin/admin_genre/new.html.twig', [
                    'genre' => $genre,
                    'form' => $form,
                    'section' => 'administration',
                    'error' => true
                ]);
            }
        }

        return $this->renderForm('admin/admin_genre/new.html.twig', [
            'genre' => $genre,
            'form' => $form,
            'section' => 'administration',
            'error' => false
        ]);
    }

    /**
     * @Route("/{id}", name="admin.genre.show", methods={"GET"})
     */
    public function show(Genres $genre): Response
    {
        return $this->render('admin/admin_genre/show.html.twig', [
            'genre' => $genre,
            'section' => 'administration'
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.genre.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Genres $genre): Response
    {
        $form = $this->createForm(GenresType::class, $genre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.genre', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_genre/edit.html.twig', [
            'genre' => $genre,
            'form' => $form,
            'section' => 'administration'
        ]);
    }

    /**
     * @Route("/{id}", name="admin.genre.delete", methods={"POST"})
     */
    public function delete(Request $request, Genres $genre, JeuxRepository $jeuxRepository, GenresRepository $genresRepository): Response
    {
        $genreToDelete = $genre;
        $jeux = $jeuxRepository->findAllAndAllFields();
        $genresUsed = [];
        foreach ($jeux as $jeu) {
            $genres = $jeu->getGenre();
            foreach ($genres as $genre) {
                if (!in_array($genre->getLibelle(), $genresUsed)) {
                    $genresUsed[] = $genre->getLibelle();
                }
            }
        }
        if (!in_array($genreToDelete->getLibelle(), $genresUsed)) {
            if ($this->isCsrfTokenValid('delete' . $genreToDelete->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($genreToDelete);
                $entityManager->flush(); 
                return $this->redirectToRoute('admin.genre', [], Response::HTTP_SEE_OTHER);
            }
        }else{
            return $this->render('admin/admin_genre/index.html.twig', [
                'genres' => $genresRepository->findAll(),
                'section' => 'administration',
                'errorDelete' => true
            ]);
        }


       
    }
}
