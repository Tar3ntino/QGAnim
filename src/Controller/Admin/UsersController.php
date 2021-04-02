<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Form\SearchUserType;
use App\Repository\UsersRepository;
use Symfony\Component\Mime\Address;
use App\Security\UsersAuthenticator;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersController extends AbstractController
{
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
