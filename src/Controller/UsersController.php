<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\SearchUserType;
use App\Form\EditProfileType;
use App\Security\EmailVerifier;
use App\Form\RegistrationFormType;
use App\Repository\UsersRepository;
use Symfony\Component\Mime\Address;
use App\Security\UsersAuthenticator;
use App\Repository\DemandeRepository;
use App\Repository\DevisRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersController extends AbstractController
{
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/users", name="users")
     */
    public function index(DemandeRepository $demandeRepo, DevisRepository $devisRepo): Response
    {
        $user = $this->getUser(); // On récupère l'utilisateur pour filtrer les demandes à renvoyer qui lui sont propre

        return $this->render('users/index.html.twig', [
            'demandes' => $demandeRepo->findBy(array('user' => $user)),
            'devis' => $devisRepo->findAll()
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

            $this->addFlash('success', 'Profil mis à jour !');
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
                $this->addFlash('success', 'Mot de passe mis à jour avec succès !');
                return $this->redirectToRoute('users');
            }else{
                $this->addFlash('danger', 'Les 2 mots de passe ne sont pas identiques');
            }
        } 
        return $this->render('users/editpassword.html.twig');
    }

    

}