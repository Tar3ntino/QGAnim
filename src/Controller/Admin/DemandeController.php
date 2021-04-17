<?php

namespace App\Controller\Admin;

use App\Entity\Demande;
use App\Form\DemandeType;
use App\Repository\DemandeRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/admin/demandes", name="admin_demandes_")
 * @package App\Controller\Admin
 */
class DemandeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function adminDemandesIndex(DemandeRepository $demandesRepo, Request $request)
    {
        return $this->render('admin/demandes/index.html.twig', [
            'demandes' => $demandesRepo->findAll()
        ]);
    }

    /**
     * @Route("/modifier/{id}", name="modifier")
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