<?php

namespace App\Controller\Admin;

use App\Entity\PlateFormes;
use App\Form\PlateFormesType;
use App\Repository\PlateFormesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/plate/forme")
 */
class AdminPlateFormeController extends AbstractController
{
    /**
     * @Route("/", name="admin.plateforme", methods={"GET"})
     */
    public function index(PlateFormesRepository $plateFormesRepository): Response
    {
        return $this->render('admin/admin_plate_forme/index.html.twig', [
            'plate_formes' => $plateFormesRepository->findAll(),
            'section' => 'administration'
        ]);
    }

    /**
     * @Route("/new", name="admin.plateforme.new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $plateForme = new PlateFormes();
        $form = $this->createForm(PlateFormesType::class, $plateForme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($plateForme);
            $entityManager->flush();

            return $this->redirectToRoute('admin.plateforme', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_plate_forme/new.html.twig', [
            'plate_forme' => $plateForme,
            'form' => $form,
            'section' => 'administration'
        ]);
    }

    /**
     * @Route("/{id}", name="admin.plateforme.show", methods={"GET"})
     */
    public function show(PlateFormes $plateForme): Response
    {
        return $this->render('admin/admin_plate_forme/show.html.twig', [
            'plate_forme' => $plateForme,
            'section' => 'administration'
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.plateforme.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PlateFormes $plateForme): Response
    {
        $form = $this->createForm(PlateFormesType::class, $plateForme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.plateforme', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_plate_forme/edit.html.twig', [
            'plate_forme' => $plateForme,
            'form' => $form,
            'section' => 'administration'
        ]);
    }

    /**
     * @Route("/{id}", name="admin.plateforme.delete", methods={"POST"})
     */
    public function delete(Request $request, PlateFormes $plateForme): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plateForme->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($plateForme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.plateforme', [], Response::HTTP_SEE_OTHER);
    }
}
