<?php

namespace App\Controller\Admin;

use App\Entity\Genres;
use App\Form\GenresType;
use App\Repository\GenresRepository;
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
            'section' => 'administration'
        ]);
    }

    /**
     * @Route("/new", name="admin.genre.new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $genre = new Genres();
        $form = $this->createForm(GenresType::class, $genre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($genre);
            $entityManager->flush();

            return $this->redirectToRoute('admin.genre', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_genre/new.html.twig', [
            'genre' => $genre,
            'form' => $form,
            'section' => 'administration'
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
    public function delete(Request $request, Genres $genre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$genre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($genre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.genre', [], Response::HTTP_SEE_OTHER);
    }
}
