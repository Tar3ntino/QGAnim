<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Form\DemandeType;
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

        // Création du formulaire :
        $form = $this->createForm(DemandeType::class, $demande);

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
}