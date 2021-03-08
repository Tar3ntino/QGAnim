<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\EditProfileType;
use App\Form\RegistrationFormType;
use App\Repository\DemandeRepository;
use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\User;

class UsersController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function index(DemandeRepository $demandeRepo): Response
    {
        $user = $this->getUser();
        return $this->render('users/index.html.twig', [
            'demandes' => $demandeRepo->findBy(array('user' => $user))
        ]);
    }

    /**
     * @Route("/users/profil/modifier", name="users_profil_modifier")
     * Pour créer un formulaire, il est nécessaire d'avoir en paramètre l'objet Request
     * provenant de la classe HttpFoundation à importer use...
     */
    public function editProfile(Request $request)
    {
        $user = $this->getUser();
        /* Creation d'un formulaire pour pouvoir modifier l'entité User : */
        $form = $this->createForm(EditProfileType::class, $user);
        /* Traitement de la request du formulaire une fois le bouton 'valider' cliqué : */
        $form->handleRequest($request);

        /* Dans le cas ou le formulaire est soumis ET valide : */
        if ($form->isSubmitted() && $form->isValid()){
            /* Entity manager = em */
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('message', 'Profil mis à jour');
            return $this->redirectToRoute('users');
        }

        return $this->render('users/editprofile.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/users/password/modifier", name="users_password_modifier")
     * Pour créer un formulaire, il est nécessaire d'avoir en paramètre l'objet Request
     * provenant de la classe HttpFoundation à importer use...
     * La classe UserPasswordEncoderInterface sera également nécessaire pour crypter le mdp s'il a été changé
     */
    public function editPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        if($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser(); // On recupère le User car il va falloir que l'on récupère le mot de passe à modifier

            // On vérifie si les 2 mots de passe sont identiques
            if ($request->request->get('pass') == $request->request->get('pass2')){
                $user->setPassword($passwordEncoder->encodePassword($user,$request->request->get('pass')));
                $em->flush(); // Pour MAJ dans la BDD
                $this->addFlash('message', 'Mot de passe MAJ avec succès');
                return $this->redirectToRoute('users');
            }else{
                $this->addFlash('error', 'Les 2 mots de passe ne sont pas identiques');
            }
        } 
        return $this->render('users/editpassword.html.twig');
    }

    /**
     * @Route("admin/users", name="admin_users_home")
     */
    public function adminUsersIndex(UsersRepository $usersRepo)
    {
        return $this->render('admin/users/index.html.twig', [
            'users' => $usersRepo->findAll()
        ]);
    }

    /**
     * @Route("admin/users/ajout", name="admin_users_ajout")
     * Pour créer un formulaire, il est nécessaire d'avoir en paramètre l'objet Request
     * provenant de la classe HttpFoundation à importer use...
     */
    public function adminUsersAjout(Request $request)
    {
    /* Creation un nouvel utilisateur: */
    $user = new Users;
    /* Creation d'un formulaire pour pouvoir ajouter un nouvel utilisateur que l'on va renvoyer dans la vue pour la saisie : */
    $form = $this->createForm(RegistrationFormType::class, $user);
    /* Traitement de la request du formulaire une fois le bouton 'valider' cliqué : */
    $form->handleRequest($request);

    /* Dans le cas ou le formulaire est soumis ET valide : */
    if ($form->isSubmitted() && $form->isValid()){
        /* Entity manager = em */
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('admin_users_home'); // Redirection une fois l'utilisateur ajouté
    }
    // Page formulaire d'ajout utilisateur si non envoyé : 
    return $this->render('admin/users/ajout.html.twig', [ 
        'form' => $form->createView()
    ]);
    }



}