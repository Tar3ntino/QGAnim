<?php

namespace App\Controller\Admin;

use App\Entity\Images;
use App\Entity\Presentation;
use App\Form\PresentationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/presentation", name="admin_presentation_")
 */

class PresentationController extends AbstractController
{
/**
 * @Route("/ajout", name="ajout")
 * Pour créer un formulaire, il est nécessaire d'avoir en paramètre l'objet Request
 * provenant de la classe HttpFoundation à importer use...
 */
    public function ajoutPresentation(Request $request)
    {
    /* Creation d'une nouvelle animation : */
    $presentation = new Presentation;
    /* Creation d'un formulaire pour pouvoir ajouter un objet presentation qui contiendra les infos de notre page que l'on va renvoyer dans la vue pour la saisie : */
    $form = $this->createForm(PresentationType::class, $presentation);
    /* Traitement de la request du formulaire une fois le bouton 'valider' cliqué : */
    $form->handleRequest($request);

    /* Dans le cas ou le formulaire est soumis ET valide : */
    if ($form->isSubmitted() && $form->isValid()){

        // On récupère les images transmises: on déclare une variable $images, on lui affecte(=) la donnée qui se 
        // trouve dans le formulaire $form au niveau du paramètre du POST qui s'appelle 'images' et on va aller chercher les données getdata
        $images = $form->get('images')->getData();

        // Etant donnée que "Multiple" = true, on peut avoir plusieurs images de chargées
        // Pour "Animation", Il faut donc boucler sur les images: 
        foreach($images as $image){
            // on génére un nouveau nom de fichier
            $fichier = md5(uniqid()). '.' . $image->guessExtension();

            // On copie le fichier dans le dossier uploads
            $image->move(
                $this->getParameter('images_directory'),
                $fichier
            );

            // On stocke l'image dans la base de données (son nom)
            $img = new Images();
            $img->setName($fichier);
            $presentation->addImage($img);
        }

        /* Entity manager = em */
        $em = $this->getDoctrine()->getManager();
        $em->persist($presentation);
        $em->flush();
        $this->addFlash('success', 'Presentation ajoutée avec succès');
        return $this->redirectToRoute('admin_home'); // Redirection une fois l'animation ajoutée
    }
    // Page formulaire d'ajout d'une presentation si non envoyée : 
        return $this->render('admin/presentation/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

/**
 * @Route("/modifier/{id}", name="edit")
 */
    public function modifPresentation(Presentation $presentation, Request $request)
    {

    /* Creation d'un formulaire pour pouvoir modifier la présentation déjà existante que l'on va renvoyer dans la vue une fois éditée: */
    $form = $this->createForm(PresentationType::class, $presentation);

    /* Traitement de la request du formulaire une fois le bouton 'valider' cliqué : */
    $form->handleRequest($request);

    /* Dans le cas ou le formulaire est soumis ET valide : */
    if ($form->isSubmitted() && $form->isValid()){

        // On récupère les images transmises: on déclare une variable $images, on lui affecte(=) la donnée qui se trouve dans 
        //le formulaire $form au niveau du paramètre du POST qui s'appelle 'images' et on va aller chercher les données getdata
        $images = $form->get('images')->getData();

        // On boucle sur les images: 
        foreach($images as $image){
            // on génére un nouveau nom de fichier
            $fichier = md5(uniqid()). '.' . $image->guessExtension();

            // On copie le fichier dans le dossier uploads
            $image->move(
                $this->getParameter('images_directory'),
                $fichier
            );

            // On stocke l'image dans la base de données (son nom)
            $img = new Images();
            $img->setName($fichier);
            $presentation->addImage($img);
        }
        /* Entity manager = em */
        $em = $this->getDoctrine()->getManager();
        $em->persist($presentation);
        $em->flush();
        $this->addFlash('success', 'Presentation modifiée avec succès');

        return $this->redirectToRoute('admin_home');
    }

        return $this->render('admin/presentation/edit.html.twig', [
            'presentation' => $presentation,
            'form' => $form->createView()
        ]);
    }
}