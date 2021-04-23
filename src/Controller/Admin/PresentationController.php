<?php

namespace App\Controller\Admin;

use App\Entity\Images;
use App\Entity\Presentation;
use App\Form\PresentationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/presentation", name="admin_presentation_")
 */

class PresentationController extends AbstractController
{
/**
 * @Route("/ajout", name="ajout")
 * Pour créer un formulaire, il est nécessaire d'avoir en paramètre l'objet Request provenant de la classe HttpFoundation à importer use...
 */
    public function ajoutPresentation(Request $request)
    {
        $presentation = new Presentation;
        $form = $this->createForm(PresentationType::class, $presentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

        // RECUPERATION DES IMAGES TRANSMISES : 
        // On déclare une variable $imageTop et $imageBottom, on leur affecte(=) les données qui se trouvent dans le formulaire $form au niveau du paramètre du POST qui s'appelle 'imagePost' et 'imageBottom' et on va aller chercher les données getdata

        $imageTop = $form->get('imageTop')->getData();
        $imageBottom = $form->get('imageBottom')->getData();

        // on génére un nouveau nom de fichier : 
        // md5 (hashage d'un string) et uniqid sont 2 fonctions PHP
        // Le MD5, pour Message Digest 5, est une fonction de hachage cryptographique qui permet d'obtenir l'empreinte numérique d'un fichier (on parle souvent de message). Il a été inventé par Ronald Rivest en 1991.
        // Enfin on va lui rajouter une méthode guessextension qui va récupérer l'extension du fichier uploadé qui sera concaténée dans le nom du fichier

        $fichierTop = md5(uniqid()). '.' . $imageTop->guessExtension();
        $fichierBottom = md5(uniqid()). '.' . $imageBottom->guessExtension();

        $originImages = [
            1 => $imageTop,
            2 => $imageBottom
        ];
        
        $uploadedImages = [
            1 => $fichierTop,
            2 => $fichierBottom
        ];

        // COPIE PHYSIQUE DU FICHIER du dossier temporaire vers le dossier d'uploads 'images_directory'

        for ($i=1; $i<3; $i++) {
        $originImages[$i]->move(
            $this->getParameter('images_directory'),
            $uploadedImages[$i]
            );
        }
        
        // On stocke l'image dans la base de données (son nom)

        $presentation->setImageTop($fichierTop);
        $presentation->setImageBottom($fichierBottom);

        /* Entity manager = em */
        $em = $this->getDoctrine()->getManager();
        $em->persist($presentation);
        $em->flush();
        $this->addFlash('success', 'Présentation ajoutée avec succès');
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
        $form = $this->createForm(PresentationType::class, $presentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

        // RECUPERATION DES IMAGES TRANSMISES : 
        // On déclare une variable $imageTop et $imageBottom, on leur affecte(=) les données qui se trouvent dans le formulaire $form au niveau du paramètre du POST qui s'appelle 'imagePost' et 'imageBottom' et on va aller chercher les données getdata
        
        $imageTop = $form->get('imageTop')->getData();
        $imageBottom = $form->get('imageBottom')->getData();

        // on génére un nouveau nom de fichier : 
        // md5 (hashage d'un string) et uniqid sont 2 fonctions PHP
        // Le MD5, pour Message Digest 5, est une fonction de hachage cryptographique qui permet d'obtenir l'empreinte numérique d'un fichier (on parle souvent de message). Il a été inventé par Ronald Rivest en 1991.
        // Enfin on va lui rajouter une méthode guessextension qui va récupérer l'extension du fichier uploadé qui sera concaténée dans le nom du fichier

        $fichierTop = md5(uniqid()). '.' . $imageTop->guessExtension();
        $fichierBottom = md5(uniqid()). '.' . $imageBottom->guessExtension();
        
        $originImages = [
            1 => $imageTop,
            2 => $imageBottom
        ];
        
        $uploadedImages = [
            1 => $fichierTop,
            2 => $fichierBottom
        ];

        // COPIE PHYSIQUE DU FICHIER du dossier temporaire vers le dossier d'uploads 'images_directory'

        for ($i=1; $i<3; $i++) {
        $originImages[$i]->move(
            $this->getParameter('images_directory'),
            $uploadedImages[$i]
            );
        }
        
        // On stocke l'image dans la base de données (son nom)

        $presentation->setImageTop($fichierTop);
        $presentation->setImageBottom($fichierBottom);

        /* Entity manager = em */
        $em = $this->getDoctrine()->getManager();
        $em->persist($presentation);
        $em->flush();
        $this->addFlash('success', 'Présentation modifiée avec succès');
        return $this->redirectToRoute('admin_home'); // Redirection une fois l'animation modifiée
        }

        // Page formulaire d'ajout d'une presentation si non envoyée : 
        return $this->render('admin/presentation/edit.html.twig', [
            'presentation' => $presentation,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/supprime/image/{id}", name="delete_image", methods={"DELETE"})
     */
    public function deleteImage(Images $image, Request $request){
        $data = json_decode($request->getContent(), true);
        
        // On vérifie si le token est valide
        if($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token'])){

            // On récupère le nom de l'image
            $nom = $image->getName();

            // On supprime le fichier du dossier Uploads
            unlink($this->getParameter('images_directory').'/'.$nom);
            
            // On supprime l'entrée de la base
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }
}