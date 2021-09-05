<?php

namespace App\Controller\Admin;

use App\Entity\Developpeurs;
use App\Form\DeveloppeursType;
use App\Repository\DeveloppeursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/admin/developpeurs")
 */
class AdminDeveloppeursController extends AbstractController
{
    /**
     * @Route("/", name="admin.developpeurs", methods={"GET"})
     */
    public function index(DeveloppeursRepository $developpeursRepository): Response
    {
        return $this->render('admin/admin_developpeurs/index.html.twig', [
            'developpeurs' => $developpeursRepository->findAll(),
            'section' => 'administration'
        ]);
    }

    /**
     * @Route("/new", name="admin.developpeurs.new", methods={"GET","POST"})
     */
    public function new(Request $request, DeveloppeursRepository $developpeursRepository): Response
    {
        $developpeur = new Developpeurs();
        $form = $this->createForm(DeveloppeursType::class, $developpeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $developpeurDb = $developpeursRepository->findOneBy(['libelle_developpeur' => $developpeur->getLibelle()]);
            if(!$developpeurDb){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($developpeur);
                $entityManager->flush();

                return $this->redirectToRoute('admin.developpeurs', [], Response::HTTP_SEE_OTHER);
            }else{
                return $this->renderForm('admin/admin_developpeurs/new.html.twig', [
                    'developpeur' => $developpeur,
                    'form' => $form,
                    'section' => 'administration',
                    'error' => true
                ]);
            }
            
        }

        return $this->renderForm('admin/admin_developpeurs/new.html.twig', [
            'developpeur' => $developpeur,
            'form' => $form,
            'section' => 'administration',
            'error' => false
        ]);
    }

    /**
     * @Route("/{id}", name="admin.developpeurs.show", methods={"GET"})
     */
    public function show(Developpeurs $developpeur): Response
    {
        return $this->render('admin/admin_developpeurs/show.html.twig', [
            'developpeur' => $developpeur,
            'section' => 'administration'
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.developpeurs.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Developpeurs $developpeur): Response
    {
        $form = $this->createForm(DeveloppeursType::class, $developpeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.developpeurs', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_developpeurs/edit.html.twig', [
            'developpeur' => $developpeur,
            'form' => $form,
            'section' => 'administration'
        ]);
    }

    /**
     * @Route("/delete-{id}", name="admin.developpeurs.delete", methods={"POST"})
     */
    public function delete(Request $request, Developpeurs $developpeur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$developpeur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($developpeur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.developpeurs', [], Response::HTTP_SEE_OTHER);
    }
}
