<?php

namespace App\Controller\Admin;

use App\Entity\Demande;
use App\Entity\Devis;
use App\Form\DevisType;
use App\Repository\DemandeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/devis", name="admin_devis_")
 * @package App\Controller\Admin
 */
class DevisController extends AbstractController
{
    /**
     * @Route("/creer/{id}", name="creer") 
     * Pour créer un formulaire, il est nécessaire d'avoir en paramètre l'objet Request
     * provenant de la classe HttpFoundation à importer use...
     */
    public function creerDevis(Demande $demande, Request $request, $id, DemandeRepository $demandeRepository): Response
    {
        // Creation d'un nouveau devis :
        $devis = new Devis;
        $devis->setDemande($demandeRepository->findOneById($id)); // On MAJ le champ de la demande en allant chercher la demande qui contient l'identifiant passé en paramètre de la méthode

        // Si l'on a bien une demande en entrée d'url, alors
        // if ($demande){
        //     $devis->setDemande($demande); // On MAJ le champs Demande de l'entité "Devis" avant de l'envoyer en Base
        // }

        // Creation d'un formulaire
        $form = $this->createForm(DevisType::class, $devis); 
        
        /* Traitement de la request du formulaire une fois le bouton 'valider' cliqué : */
        $form->handleRequest($request);

        /* Dans le cas ou le formulaire est soumis ET valide : */
        /*  */
        if ($form->isSubmitted() && $form->isValid()){
            // $form->get('demande')->setData($demande);
            $em = $this->getDoctrine()->getManager();
            $em->persist($devis);
            $em->flush();

            // Message de succès pour la création du devis : 
            $this->addFlash('success', 'Devis créé avec succès');

            return $this->redirectToRoute('admin_demandes_home');
        }
        return $this->render('admin/devis/creer.html.twig', [
            "demande" => $demande,
            'DevisForm' => $form->createView()
        ]);
    }
}