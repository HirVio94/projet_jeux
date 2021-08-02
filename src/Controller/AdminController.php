<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\AvisRepository;
use App\Repository\ClassificationsRepository;
use App\Repository\DeveloppeursRepository;
use App\Repository\GenresRepository;
use App\Repository\JeuxRepository;
use App\Repository\PlateFormesRepository;
use App\Repository\UserRepository;
use DateTime;
use PhpParser\Node\Expr\FuncCall;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController

{   


    private UserRepository $userRepository;
    private JeuxRepository $jeuxRepository;
    private AvisRepository $avisRepository;
    private ClassificationsRepository $classificationRepository;
    private DeveloppeursRepository $developpeurRepository;
    private GenresRepository $genreRepository;
    private PlateFormesRepository $plateformesRepository;


    public function __construct(UserRepository $userRepository, JeuxRepository $jeuxRepository, AvisRepository $avisRepository, ClassificationsRepository $classificationsRepository, DeveloppeursRepository $developpeurRepository, GenresRepository $genresRepository, PlateFormesRepository $plateFormesRepository)
    {
        $this->userRepository = $userRepository;
        $this->jeuxRepository = $jeuxRepository;
        $this->avisRepository = $avisRepository;
        $this->classificationRepository = $classificationsRepository;
        $this->developpeurRepository = $developpeurRepository;
        $this->genreRepository = $genresRepository;
        $this->plateformesRepository = $plateFormesRepository;
    }
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $nbrUsers = count($this->userRepository->findAll());
        $user = [
            'libelle' => 'users',
            'nbr' => $nbrUsers
        ];
        $nbrJeux = count($this->jeuxRepository->findAll());
        $jeu = [
            'libelle' => 'jeux',
            'nbr' => $nbrJeux
        ];
        $nbrGenre = count($this->genreRepository->findAll());
        $genre = [
            'libelle' => 'genre',
            'nbr'=> $nbrGenre
        ];
        $nbrDev = count($this->developpeurRepository->findAll());
        $dev = [
            'libelle' => 'developpeur',
            'nbr' => $nbrDev
        ];
        $nbrClassification = count($this->classificationRepository->findAll());
        $classification = [
            'libelle' => 'classification',
            'nbr' => $nbrClassification
        ];
        $nbrPlateforme = count($this->plateformesRepository->findAll());
        $plateforme = [
            'libelle' => 'plateforme',
            'nbr' => $nbrPlateforme
        ];
        $nbrAvis = count($this->avisRepository->findAll());
        $avis = [
            'libelle' => 'avis',
            'nbr' => $nbrAvis
        ];
        $entities = [$user, $jeu, $genre, $dev, $classification, $plateforme, $avis];
        return $this->render('admin/index.html.twig', [
            'section' => 'administration',
            'entities' => $entities
        ]);

    }
    /**
     * @Route("/admin/user", name="admin.user")
     * @param UserRepository $userRepository
     * @return Response
     */
    public function gestionUtilisateur():Response{
        $tabUtilisateur = $this->userRepository->findAll();
        $updated = filter_input(INPUT_GET, 'updated');
        $deleted = filter_input(INPUT_GET, 'deleted');
        /* if ($updated == null){
            $updated = false;
        }
        if ($deleted == null){
            $updated = false;
        } */

        return $this->render('admin/users/gestionUtilisateur.html.twig', [
            'tabUsers' => $tabUtilisateur,
            'section' => 'administration',
            'updated' => $updated,
            'deleted' => $deleted
        ]);
    }
    /**
     * @Route("/admin/user/addUser", name="admin.user.addUser")
     *
     * @return Response
     */
    public function ajouterUtilisateur(RequestStack $requestStack): Response{
        $method = $requestStack->getMainRequest()->getMethod();
        $usernameExistant = false;
        $emailExistant = false;
        if($method === 'POST'){
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST,'email', FILTER_SANITIZE_EMAIL);
            $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);
            $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_SPECIAL_CHARS);
            $dateNaissance = filter_input(INPUT_POST,'date_naissance');

            $usernameExistant = $this->verifUser($username);
            $emailExistant = $this->verifEmail($email);
           /*  dump($usernameExistant);
            dump($emailExistant);
            die(); */
            if ($usernameExistant || $emailExistant){
                $this->redirectToRoute('admin.user.addUser', [
                    'usernameExistant' => $usernameExistant,
                    'emailExistant' => $emailExistant 
                ]);
            }

            $this->redirectToRoute('admin.user.addUser');

        }
        return $this->render('admin/users/ajouterUtilisateur.html.twig', [
            'section' => 'administration',
            'usernameExistant' => $usernameExistant,
            'emailExistant' => $emailExistant 
        ]);
    }
    /**
     * @Route("/admin/user/updateUser", name="admin.user.updateUser")
     * @return Response
     */
    public function updateUser(): Response{

        $idUser = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $user = $this->userRepository->findOneBy(['id' => $idUser]);

        return $this->render('admin/users/updateUtilisateur.html.twig', [
            'section' => 'administration',
            'user' => $user
        ]);
    }
    /**
     * @Route("admin/user/uptatedUser", name="admin.user.uptatedUser")
     * @return Response
     */
    public function updateUserDb() : Response{
        $userId = filter_input(INPUT_POST, 'id_user', FILTER_SANITIZE_NUMBER_INT);
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST,'email', FILTER_SANITIZE_EMAIL);
        $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);
        $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_SPECIAL_CHARS);
        $dateNaissance = filter_input(INPUT_POST,'date_naissance');
        if ($dateNaissance !== ''){
             $dateNaissance = new DateTime($dateNaissance);
            
        }else{
            $dateNaissance = null;
        }
        $user = $this->userRepository->findOneBy(['id' => $userId]);
        $user->setUsername($username)->setEmail($email)->setNom($nom)->setPrenom($prenom)->setDateNaissance($dateNaissance)->setId($userId);
        $this->userRepository->updateUser($user);
        

        return $this->redirectToRoute('admin.user', [
            'updated' => true
        ]);
    }
    /**
     * @Route("admin/user/deleteUser", name="admin.user.deleteUser")
     * @return Response
     */
    public function deleteUser(): Response{
        $userId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $user = $this->userRepository->findOneBy(['id' => $userId]);
        $this->userRepository->deleteUser($user);
        return $this->redirectToRoute('admin.user', [
            'deleted' => true
        ]);
    }


    private function verifUser($username){

        $user = $this->userRepository->findOneBy(['username' => $username]);

        if ($user){
            return true;
        }else{
            return false;
        }
    }

    private function verifEmail($email){
        $email = $this->userRepository->findOneBy(['email' => $email]);

        if ($email){
            return true;
        }else{
            return false;
        }
    }
}
