<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // dump($this->getUser());
        // die;
        // Si l'utilisateur s'est authentifié, il est redirigé sur son espace personnel pour l'inciter à MAJ son profil.
        if ($this->getUser()){  // si l'on trouve un User dans l'envoi de la requete 
    
            return $this->redirectToRoute('users');  // alors on autorise la connexion et on le redirige vers son espace personnel
        
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/delete_user/{id}", name="delete_user")
     */
    public function deleteUser($id)
    {
        $em = $this->getDoctrine()->getManager();
        $usrRepo = $em->getRepository(Users::class); // Récupération de la liste de tous les utilisateurs
        $user = $usrRepo->find($id); // on cherche le user id parmi cette liste

        // Si cet utilisateur existe
        if (isset($user)){
            // Si son compte est toujours actif
            if($user->getEnabled()){
                // Si son compte n'a pas été "Supprimé"
                if (is_null($user->getDeletedAt())){
                    $user->setDeleted('true'); // Alors on change la valeur du champ à "DELETED"
                    $user->setDeletedAt(new \DateTime('NOW')); // Mettre un newDate \NOW puis redirect Route à LogOut avec un message flash
                    $em->flush();
                }
            }
        }
        else {
            throw $this->createNotFoundException(
                'L\'utilisateur'.$user.'n\'existe pas');
        }
    return $this->redirectToRoute('users');

    }
}
