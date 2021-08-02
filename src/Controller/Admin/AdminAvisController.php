<?php

namespace App\Controller\Admin;

use App\Entity\Avis;
use App\Entity\User;
use App\Form\AvisType;
use App\Repository\AvisRepository;
use App\Repository\JeuxRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/avis")
 */
class AdminAvisController extends AbstractController
{
    private JeuxRepository $jeuxRepository;
    private UserRepository $userRepository;


    public function __construct(JeuxRepository $jeuxRepository, UserRepository $userRepository)
    {
        $this->jeuxRepository = $jeuxRepository;
        $this->userRepository = $userRepository;
    }
    /**
     * @Route("/", name="admin.avis", methods={"GET"})
     */
    public function index(AvisRepository $avisRepository): Response
    {
        return $this->render('admin/admin_avis/index.html.twig', [
            'avis' => $avisRepository->findAll(),
            'section' => 'administration'
        ]);
    }

    /**
     * @Route("/new", name="admin.avis.new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $avi = new Avis();
        $jeux = $this->jeuxRepository->findAll();
        $users = $this->userRepository->findAll();
        $notes = [];
        $note = 0;

        for ($i=0; $i <= 20 ; $i++) { 
            $notes [] = $note;
            $note++;
        }
        // $form = $this->createForm(AvisType::class, $avi);
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $entityManager = $this->getDoctrine()->getManager();
        //     $entityManager->persist($avi);
        //     $entityManager->flush();

        //     return $this->redirectToRoute('admin_avis_index', [], Response::HTTP_SEE_OTHER);
        // }

        return $this->renderForm('admin/admin_avis/new.html.twig', [
            'jeux' => $jeux,
            'users' => $users,
            'notes' => $notes,
            'section' => 'administration'
        ]);
    }
    /**
     * Undocumented function
     * @Route("/new/validation", name="admin.avis.new.validate")
     * @param Request $request
     * @return void
     */
    public function newValidation(Request $request){
        $newAvi = $this->valideForm($request);
        $avis = new Avis();
        $user = $this->userRepository->findOneBy(['id' => $newAvi['idUser']]);
        $jeu = $this->jeuxRepository->findOneBy(['id' => $newAvi['idJeu']]);
        $avis->setNote($newAvi['note'])->setMessage($newAvi['message'])->setJeux($jeu)->setUser($user);
        $em = $this->getDoctrine()->getManager();
        $em->persist($avis);
        $em->flush();
        return $this->redirectToRoute('admin.avis');
    }

    /**
     * @Route("/{id}", name="admin_avis_show", methods={"GET"})
     */
    public function show(Avis $avi): Response
    {
        return $this->render('admin/admin_avis/show.html.twig', [
            'avi' => $avi,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.avis.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Avis $avi): Response
    {
        $form = $this->createForm(AvisType::class, $avi);
        $jeux = $this->jeuxRepository->findAll();
        $users = $this->userRepository->findAll();
        $notes = [];
        $note = 0;

        for ($i=0; $i <= 20 ; $i++) { 
            $notes [] = $note;
            $note++;
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.avis', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_avis/edit.html.twig', [
            'avi' => $avi,
            'form' => $form,
            'jeux' => $jeux,
            'users' => $users,
            'notes' => $notes,
            'section' => 'administration'
        ]);
    }

    /**
     * @Route("/{id}", name="admin.avis.delete", methods={"POST"})
     */
    public function delete(Request $request, Avis $avi): Response
    {
        if ($this->isCsrfTokenValid('delete'.$avi->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($avi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.avis', [], Response::HTTP_SEE_OTHER);
    }

    private function valideForm($request){
        $data = $request->request->all();

        $avi = [
            'idJeu' => $data['jeu'],
            'idUser' => $data['user'],
            'message' => $data['message'],
            'note' => $data['note'],
        ];
        
        return $avi;
    }
}
