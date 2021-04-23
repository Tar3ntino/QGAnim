<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Form\DemandeType;
use App\Repository\DemandeRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DemandeController extends AbstractController
{
    /**
    * @Route("/contact", name="app_contact")
    */
    public function envoiDemande(Request $request)
    {
        // Création d'une demande. Les parenthèses sont nécessaires si tu as un constructeur dans ta classe. Ici non.
        $demande = new Demande;

        // Vérification si utilisateur authentifié
        // Si oui -> get le user Id pour pouvoir MAJ dans l'entité "Demande" et identifier son auteur
        // Sinon, on ne fait rien et l'on renvoie simplement la vue avec un utilisateur "Null" pour l'entité "Demande"
        // et l'on enregistre la requête en base
        // Si l'utilisateur existe... autrement dit, un user est connecté
        $user = $this->getUser();
        if ($user){
            $demande->setUser($user); // On MAJ le champs User de l'entité "Demande" avant de l'envoyer en Base
        }

        // Création du formulaire :
        $form = $this->createForm(DemandeType::class, $demande);
        $form -> remove('status');
        $demande ->setStatus('Demande : Reçue'); // On initialise la demande qui va être envoyée en BDD

        // Traitement du formulaire :
        $form->handleRequest($request);

        // Si mon formulaire est envoyé(soumis) et valide
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($demande); // persist() -> you are telling the entity manager to track changes to the object. 
            $em->flush(); // flush() -> the em will push the changes of the entity objects the em tracks to the database in single transaction

            // Message de succès pour l'utilisateur : 
            $this->addFlash('message', 'Votre demande a bien été enregistrée. Nous reviendrons vers vous sous peu');

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('main/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}