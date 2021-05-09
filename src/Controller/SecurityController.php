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
    public function deleteUser(Users $users)
    {
        $em = $this->getDoctrine()->getManager();
        $usrRepo = $em->getRepository(Users::class); // Récupération de la liste de tous les utilisateurs
        $user = $usrRepo->find($users->getId()); // on cherche le user id parmi cette liste
        
        // Si l'identifiant de notre utilisateur actuel est égale à l'identifiant de l'utilisateur en paramètre de la fonction (s'il s'agit bien du même utilisateur... Exemple: un utilisateur avec pour Id 5 ne doit pas pouvoir supprimer un compte (en soft delete) en appelant l'url (/delete_user/37))
        
        if ($this->getUser()->getId() === (int)$users->getId()){
            // Si son compte est toujours actif (il peut avoir demandé la désactivation provisoire sans pour autant supprimer son compte)
            if($user->getEnabled()){
                // Si son compte n'a pas été "Supprimé"
                if (is_null($user->getDeletedAt())){
                    $user->setDeletedAt(new \DateTime('NOW')); // On marque le compte comme supprimé en indiquant la date à laquelle la suppression a été faite. Il faudrait pouvoir maintenant déconnecter l'utilisateur en le redirigeant vers une Route LogOut.
                    $em->flush();

                // Message de succès pour la suppression du compte utilisateur : 
                $this->addFlash('success', 'Suppression de votre compte enregistrée. Nous regrettons de vous voir partir.');
                }
            }
        }
        else {
             // On renvoie un message Flash plutôt qu'une exception pour une meilleure User Experience
                $this->addFlash('danger', 'L\'utilisateur'.$user.'n\'existe pas OU vous n\'avez pas la permission pour effectuer cette action');
        }
    return $this->redirectToRoute('users');
    }
}