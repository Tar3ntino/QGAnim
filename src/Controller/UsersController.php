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

    /**
     * @Route("admin/users", name="admin_users_home")
     */
    public function adminUsersIndex(UsersRepository $usersRepo, Request $request)
    {
        $users = $usersRepo->findAll();

        $form = $this->createForm(SearchUserType::class);

        $search = $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // On recherche les Users correspondant aux mots clés
            $users = $usersRepo->search($search->get('mots')->getData());
        }

        return $this->render('admin/users/index.html.twig', [
            'users' => $users,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/users/ajout", name="admin_users_ajout")
     * Pour créer un formulaire, il est nécessaire d'avoir en paramètre l'objet Request
     * provenant de la classe HttpFoundation à importer use...
     */
    public function adminUsersAjout(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, UsersAuthenticator $authenticator)
    {
    /* Creation un nouvel utilisateur: */
    $user = new Users;
    /* Creation d'un formulaire pour pouvoir ajouter un nouvel utilisateur que l'on va renvoyer dans la vue pour la saisie : */
    $form = $this->createForm(RegistrationFormType::class, $user);
    /* Traitement de la request du formulaire une fois le bouton 'valider' cliqué : */
    $form->handleRequest($request);

    /* Dans le cas ou le formulaire est soumis ET valide : */
    if ($form->isSubmitted() && $form->isValid()){

        // encode the plain password
        $user->setPassword(
            $passwordEncoder->encodePassword(
                $user,
                $form->get('plainPassword')->getData()
            )
        );

        /* Entity manager = em */
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        // generate a signed url and email it to the user
        $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
        (new TemplatedEmail())
            ->from(new Address('contact@qganimations.fun', 'QG Animations'))
            ->to($user->getEmail())
            ->subject('Merci de confirmer votre adresse email')
            ->htmlTemplate('registration/confirmation_email.html.twig')
        );

        return $guardHandler->authenticateUserAndHandleSuccess(
            $user,
            $request,
            $authenticator,
            'main' // firewall name in security.yaml
        );

        return $this->redirectToRoute('admin_users_home'); // Redirection une fois l'utilisateur ajouté
    }
    // Page formulaire d'ajout utilisateur si non envoyé : 
    return $this->render('admin/users/ajout.html.twig', [ 
        'registrationForm' => $form->createView()
    ]);
    }

    /**
     * @Route("admin/users/modifier/{id}", name="admin_users_modifier")
     * Pour créer un formulaire, il est nécessaire d'avoir en paramètre l'objet Request
     * provenant de la classe HttpFoundation à importer use...
     */
    public function adminUsersEdit(Users $user, Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, UsersAuthenticator $authenticator)
    {

    /* Creation d'un formulaire pour pouvoir modifier l'utilisateur que l'on va renvoyer dans la vue pour la saisie : */
    $form = $this->createForm(RegistrationFormType::class, $user);
    /* Traitement de la request du formulaire une fois le bouton 'valider' cliqué : */
    $form->handleRequest($request);

    /* Dans le cas ou le formulaire est soumis ET valide : */
    if ($form->isSubmitted() && $form->isValid()){

        // encode the plain password
        $user->setPassword(
            $passwordEncoder->encodePassword(
                $user,
                $form->get('plainPassword')->getData()
            )
        );

        /* Entity manager = em */
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        // generate a signed url and email it to the user
        $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
        (new TemplatedEmail())
            ->from(new Address('contact@qganimations.fun', 'QG Animations'))
            ->to($user->getEmail())
            ->subject('Please Confirm your Email')
            ->htmlTemplate('registration/confirmation_email.html.twig')
        );

        return $guardHandler->authenticateUserAndHandleSuccess(
            $user,
            $request,
            $authenticator,
            'main' // firewall name in security.yaml
        );

        return $this->redirectToRoute('admin_users_home'); // Redirection une fois l'utilisateur ajouté
    }
    // Page formulaire d'ajout utilisateur si non envoyé : 
    return $this->render('admin/users/ajout.html.twig', [
        'user' => $user,
        'registrationForm' => $form->createView()
    ]);
    }

    /**
     * @Route("admin/users/supprimer/{id}", name="admin_users_supprimer")
     */
    public function adminUsersDelete(Users $user)
    {   
            /* Entity manager = em */
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();

            $this->addFlash('danger', 'Utilisateur supprimé avec succès');
            return $this->redirectToRoute('admin_users_home');
    }

}