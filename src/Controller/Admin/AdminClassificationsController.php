<?php

namespace App\Controller\Admin;

use App\Entity\Classifications;
use App\Form\ClassificationsType;
use App\Repository\ClassificationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/classifications")
 */
class AdminClassificationsController extends AbstractController
{
    /**
     * @Route("/", name="admin.classifications", methods={"GET"})
     */
    public function index(ClassificationsRepository $classificationsRepository): Response
    {
        return $this->render('admin/admin_classifications/index.html.twig', [
            'classifications' => $classificationsRepository->findAll(),
            'section' => 'administration'
        ]);
    }

    /**
     * @Route("/new", name="admin.classifications.new", methods={"GET","POST"})
     */
    public function new(Request $request, ClassificationsRepository $classificationsRepository): Response
    {
        $classification = new Classifications();
        $form = $this->createForm(ClassificationsType::class, $classification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $classificationDb = $classificationsRepository->findOneBy(['libelle_classification' => $classification->getLibelle()]);
            if(!$classificationDb){
                $entityManager->persist($classification);
                $entityManager->flush();
            }else{
                return $this->renderForm('admin/admin_classifications/new.html.twig', [
                    'classification' => $classification,
                    'form' => $form,
                    'secion' => 'administration',
                    'error' => true
                ]);
            }
            

            return $this->redirectToRoute('admin.classifications', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_classifications/new.html.twig', [
            'classification' => $classification,
            'form' => $form,
            'section' => 'administration',
            'error' => false
        ]);
    }

    /**
     * @Route("/{id}", name="admin.classifications.show", methods={"GET"})
     */
    public function show(Classifications $classification): Response
    {
        return $this->render('admin/admin_classifications/show.html.twig', [
            'classification' => $classification,
            'section' => 'administration'
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.classifications.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Classifications $classification): Response
    {
        $form = $this->createForm(ClassificationsType::class, $classification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.classifications', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_classifications/edit.html.twig', [
            'classification' => $classification,
            'form' => $form,
            'section' => 'administration'
        ]);
    }

    /**
     * @Route("/{id}", name="admin.classifications.delete", methods={"POST"})
     */
    public function delete(Request $request, Classifications $classification): Response
    {
        if ($this->isCsrfTokenValid('delete'.$classification->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($classification);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.classifications', [], Response::HTTP_SEE_OTHER);
    }
}
