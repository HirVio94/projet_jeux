<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController

{
    /**
     * @Route("/login", name="login")
     */
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('user/index.html.twig', [
            'lastUsername' => $lastUsername,
            'error' => $error,
            'section' => 'client',
            'page' => 'login'
        ]);
    }
    /**
     *  @Route("/logout", name="logout")
     * @return void
     */
    public function deconnexion()
    {
    }
    /**
     * Undocumented function
     * @Route("/user/newUser", name="user.newUser")
     * @param Request $request
     * @return Response
     */
    public function newUser(Request $request, UserRepository $userRepository): Response
    {
        if ($request->getMethod() == 'POST') {
            $user = new User();
            $this->setUser($user, $request);
            $userRepository->newUser($user);

            return $this->redirectToRoute('home');
        }

        return $this->render('user/newUserForm.html.twig', [
            'section' => 'client',
            'page' => 'newUser'
        ]);
    }
    /**
     * 
     * @Route("/user/profil-{id}", name="user.profil")
     * @return Response
     */
    public function profilUser(User $user): Response{
        return $this->render('user/profil.html.twig', [
            'section' => 'client',
            'page' => 'profil'
        ]);
    }
    /**
     * Undocumented function
     * @Route("/user/modifProfil-{id}", name="user.modifProfil")
     * @param User $user
     * @return Response
     */
    public function modifProfil(User $user, Request $request, UserRepository $userRepository): Response{
        dump($request);
        if($request->getMethod() == 'POST'){
            $this->setUser($user, $request);
            $userRepository->updateUser($user);

            return $this->redirectToRoute('user.profil', ['id' => $user->getId()]);
        }
        return $this->render('user/modifProfil.html.twig', [
            'section' => 'client',
            'page' => 'modifProfil'
        ]);
    }

    private function setUser(User $user, Request $request){
        $userForm = $request->request;
        $username = $userForm->get('username');
        $password = password_hash($userForm->get('password'), PASSWORD_BCRYPT);
        $email = $userForm->get('email');
        $nom = $userForm->get('nom');
        $prenom = $userForm->get('prenom');

        if($userForm->get('date_naissance') != ''){
            $date = new DateTime($userForm->get('date_naissance'));
            $user->setDateNaissance($date);
        }

        $user->setUsername($username)->setEmail($email)->setPassword($password)->setNom($nom)->setPrenom($prenom)->setRoles(['ROLE_CLIENT']);
    }
}
