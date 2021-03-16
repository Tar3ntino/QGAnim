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
            $em->persist($demande);
            $em->flush();

            // Message de succès pour l'utilisateur : 
            $this->addFlash('message', 'Votre demande a bien été enregistrée. Nous reviendrons vers vous sous peu');

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('main/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("admin/demandes", name="admin_demandes_home")
     */
    public function adminDemandesIndex(DemandeRepository $demandesRepo, Request $request)
    {
        return $this->render('admin/demandes/index.html.twig', [
            'demandes' => $demandesRepo->findAll()
        ]);
    }

    /**
     * @Route("admin/demandes/modifier/{id}", name="admin_demandes_modifier")
     * Pour créer un formulaire, il est nécessaire d'avoir en paramètre l'objet Request
     * provenant de la classe HttpFoundation à importer use...
     */
    public function modifDemande(Demande $demande, Request $request)
    {
        /* Creation d'un formulaire pour pouvoir modifier la demande déjà existante que l'on va renvoyer dans la vue une fois éditée: */
        $form = $this->createForm(DemandeType::class, $demande);
        $form->remove('eventLocation');
        $form->remove('numberPeople');
        $form->remove('eventType');
        $form->remove('eventDate');
        $form->remove('animationSchedules');
        $form->remove('budgetClient');
        $form->remove('otherComments');
        $form->remove('nameRequester');
        $form->remove('firstNameRequester');
        $form->remove('nameCompanyOrAssociation');
        $form->remove('emailRequester');
        $form->remove('phoneRequester');

        /* Traitement de la request du formulaire une fois le bouton 'valider' cliqué : */
        $form->handleRequest($request);

        /* Dans le cas ou le formulaire est soumis ET valide : */
        /*  */
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($demande);
            $em->flush();
            return $this->redirectToRoute('admin_demandes_home');
        }
        return $this->render('admin/demandes/edit.html.twig', [
            'demande' => $demande,
            'form' => $form->createView()
        ]);
    }
}