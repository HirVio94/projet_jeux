<?php

namespace App\Controller\Admin;

use App\Entity\Jeux;
use App\Form\JeuxType;
use App\Repository\ClassificationsRepository;
use App\Repository\DeveloppeursRepository;
use App\Repository\GenresRepository;
use App\Repository\JeuxRepository;
use App\Repository\PlateFormesRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/jeux")
 */
class AdminJeuxController extends AbstractController
{
    private $genresRepository;
    private $developpeursRepository;
    private $plateFormesRepository;
    private $jeuxRepository;
    private $classificationsRepository;

    public function __construct(GenresRepository $genresRepository, DeveloppeursRepository $developpeursRepository, PlateFormesRepository $plateFormesRepository, JeuxRepository $jeuxRepository, ClassificationsRepository $classificationsRepository)
    {
        $this->genresRepository = $genresRepository;
        $this->developpeursRepository = $developpeursRepository;
        $this->plateFormesRepository = $plateFormesRepository;
        $this->jeuxRepository = $jeuxRepository;
        $this->classificationsRepository = $classificationsRepository;
    }

    /**
     * @Route("/", name="admin.jeux", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin/admin_jeux/index.html.twig', [
            'jeux' => $this->jeuxRepository->findAllAndAllFields(),
            'section' => 'administration'
        ]);
    }

    /**
     * @Route("/new", name="admin.jeux.new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $jeux = new Jeux();
        $form = $this->createForm(JeuxType::class, $jeux);
        // $form->handleRequest($request);
        $genres = $this->genresRepository->findAll();
        $plateformes = $this->plateFormesRepository->findAll();
        $devs = $this->developpeursRepository->findAll();
        $classifications = $this->classificationsRepository->findAll();
        // if ($form->isSubmitted() && $form->isValid()) {
        //     $entityManager = $this->getDoctrine()->getManager();
        //     $entityManager->persist($jeux);
        //     $entityManager->flush();

        //     return $this->redirectToRoute('admin.jeux', [], Response::HTTP_SEE_OTHER);
        // }
        $error = false;
        if(filter_input(INPUT_GET, 'error')){
            $error = filter_input(INPUT_GET, 'error');
        }
        return $this->renderForm('admin/admin_jeux/new.html.twig', [
            'form' => $form,
            'genres' => $genres,
            'devs' => $devs,
            'plateformes' => $plateformes,
            'classifications' => $classifications,
            'section' => 'administration',
            'error' => $error
        ]);
    }
    /**
     * Undocumented function
     * @Route("new/validation", name="admin.jeux.newValidate")
     * @param Request $request
     * @return Response
     */
    public function newValidation(Request $request): Response
    {
        $newJeux = $this->validationForm($request);

        $jeux = new Jeux();
        $jeux = $this->setJeux($newJeux, $jeux);
        $jeuxDb = $this->jeuxRepository->findOneBy(['titre' => $jeux->getTitre()]);
        if (!$jeuxDb) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($jeux);
            $em->flush();

            return $this->redirectToRoute('admin.jeux');
        }else{
            return $this->redirectToRoute('admin.jeux.new', ['error' => true]);
        }
    }

    /**
     * @Route("/{id}", name="admin.jeux.show", methods={"GET"})
     */
    public function show(Jeux $jeux): Response
    {
        return $this->render('admin/admin_jeux/show.html.twig', [
            'jeux' => $jeux,
            'section' => 'administration'
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.jeux.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Jeux $jeux): Response
    {
        $genres = $this->genresRepository->findAll();
        $plateformes = $this->plateFormesRepository->findAll();
        $devs = $this->developpeursRepository->findAll();
        $classifications = $this->classificationsRepository->findAll();
        $form = $this->createForm(JeuxType::class, $jeux);
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     // $this->getDoctrine()->getManager()->flush();
        //     $titre = filter_input(INPUT_POST, 'jeux[titre]', FILTER_SANITIZE_STRING);
        //     dump($titre);
        //     die();
        //     // return $this->redirectToRoute('admin.jeux', [], Response::HTTP_SEE_OTHER);
        // }

        return $this->renderForm('admin/admin_jeux/edit.html.twig', [
            'jeux' => $jeux,
            'form' => $form,
            'genres' => $genres,
            'plateformes' => $plateformes,
            'devs' => $devs,
            'section' => 'administration',
            'classifications' => $classifications
        ]);
    }
    /**
     * Undocumented function
     * @Route("/{id}/edit/validation", name="admin.jeux.edit.validate")
     * @return Response
     */
    public function editValidation(Request $request, Jeux $jeux): Response
    {
        // dump($jeux);
        $jeuxEdit = $this->validationForm($request);


        $genres = $jeux->getGenre();
        foreach ($genres as $genre) {
            $jeux->removeGenre($genre);
        }

        $plateformes = $jeux->getPlateForme();
        foreach ($plateformes as $plateforme) {
            $jeux->removePlateForme($plateforme);
        }
        $this->setJeux($jeuxEdit, $jeux);

        $this->getDoctrine()->getManager()->persist($jeux);
        $this->getDoctrine()->getManager()->flush();
        // dump($plateformes);
        // die();






        return $this->redirectToRoute('admin.jeux', []);
    }
    /**
     * @Route("/{id}", name="admin.jeux.delete", methods={"POST"})
     */
    public function delete(Request $request, Jeux $jeux): Response
    {
        if ($this->isCsrfTokenValid('delete' . $jeux->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($jeux);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.jeux', [], Response::HTTP_SEE_OTHER);
    }

    public function validationForm($request)
    {

        $data  = $request->request->all();
        // $titre = filter_input(INPUT_POST, 'titre');
        // $description = filter_input(INPUT_POST, 'description');
        // $video = filter_input(INPUT_POST, 'video');
        // $date = filter_input(INPUT_POST, 'date');
        // $genre = filter_input(INPUT_POST, 'genre', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        // $plateforme = filter_input(INPUT_POST, 'plateforme');
        // $dev = filter_input(INPUT_POST, 'dev');
        $titre = $data['titre'];
        $description  = $data['description'];
        $video = $data['video'];
        $date = $data['date'];
        $genre = $data['genre'];
        $plateforme = $data['plateforme'];
        $dev = $data['dev'];
        $couverturePath = '';
        $classification = $data['classification'];
        // if ($_FILES['image']['name'] != '') {
        //     $fichierImage = $_FILES['image'];
        //     $nameFile = $fichierImage['tmp_name'];
        //     $needle = [' ', "'", ':'];
        //     $newTitre = str_ireplace($needle, '-', $titre);
        //     switch ($fichierImage['type']) {
        //         case 'image/jpeg':

        //             $chemin = "images/couvertures/" . $newTitre . ".jpeg";
        //             move_uploaded_file($nameFile, $chemin);
        //             break;
        //         case 'image/png':
        //             $chemin = 'images/couvertures/' . $newTitre . '.png';
        //             move_uploaded_file($nameFile, $chemin);
        //             break;
        //     }
        //     dump($_FILES);
        //     die();
        // }

        if ($request->files->get('image')) {
            $imageFile = $request->files->get('image');
            $pathFile = $imageFile->getPathname();
            $needle = [' ', "'", ':'];
            $newTitre = str_ireplace($needle, '-', $titre);


            switch ($imageFile->getClientMimeType()) {
                case 'image/jpeg':
                    $chemin = "images/couvertures/" . $newTitre . ".jpeg";

                    break;

                case 'image/png':
                    $chemin = "images/couvertures/" . $newTitre . ".png";

                    break;
            }
            // unlink($chemin);
            move_uploaded_file($pathFile, $chemin);
            $couverturePath = '/' . $chemin;
            // dump($imageFile->getClientMimeType(), $chemin, $imageFile->getPathname());
            // die();

        }

        return $jeuxEdit = [
            'titre' => $titre,
            'description' => $description,
            'video' => $video,
            'date' => $date,
            'genre' => $genre,
            'plateforme' => $plateforme,
            'dev' => $dev,
            'couverture' => $couverturePath,
            'classification' => $classification
        ];
    }

    private function setJeux(array $tabJeux, Jeux $jeux)
    {
        $dev = $this->developpeursRepository->findOneBy(['id' => $tabJeux['dev']]);
        $classification = $this->classificationsRepository->findOneBy(['id' => $tabJeux['classification']]);

        $date = new DateTime($tabJeux['date']);
        $jeux->setTitre($tabJeux['titre'])->setVideoPath($tabJeux['video'])->setDescription($tabJeux['description'])->setDateSortie($date)->setDeveloppeur($dev)->setClassification($classification);

        if ($tabJeux['couverture'] != '') {
            $jeux->setCouverturePath($tabJeux['couverture']);
        }
        foreach ($tabJeux['genre'] as $genreId) {
            $genre = $this->genresRepository->findOneBy(['id' => $genreId]);
            $jeux->addGenre($genre);
        }
        foreach ($tabJeux['plateforme'] as $plateformeId) {

            $plateforme = $this->plateFormesRepository->findOneBy(['id' => $plateformeId]);
            $jeux->addPlateForme($plateforme);
        }

        return $jeux;
    }
}
