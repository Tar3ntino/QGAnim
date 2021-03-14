<?php

namespace App\Controller;

use App\Entity\ImagesCarouselAccueil;
use App\Form\ImagesCarouselAccueilType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ImagesCarouselAccueilRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ImagesCarouselAccueilController extends AbstractController
{
    /**
     * @Route("/admin/images/carousel/accueil", name="admin_images_carousel_accueil_home")
     */
    public function index(ImagesCarouselAccueilRepository $imagesCarouselAccueil, Request $request): Response
    {
        return $this->render('admin/images_carousel_accueil/index.html.twig', [
            'imagesCarouselAccueil' => $imagesCarouselAccueil->findAll(),
        ]);
    }

    /**
     * @Route("/admin/images/carousel/accueil/ajout", name="admin_images_carousel_accueil_ajout")
     */
    public function addImageCarouselAccueil(Request $request): Response
    {
        /* Creation d'une nouvelle Image Carousel Accueil : */
        $newImageCarousel = new ImagesCarouselAccueil;
        /* Creation d'un formulaire pour pouvoir ajouter le nouveau slide que l'on va renvoyer dans la vue pour la saisie : */
        $form = $this->createForm(ImagesCarouselAccueilType::class, $newImageCarousel);
        /* Traitement de la request du formulaire une fois le bouton 'valider' cliqué : */
        $form->handleRequest($request);

        /* Traitement du formulaire - Slide envoyé
        Dans le cas ou le formulaire est soumis ET valide : */
        if ($form->isSubmitted() && $form->isValid()){

            /* A l'intérieur du traitement du formulaire, on va devoir gérer l'image chargée précédemment avec le bouton "Parcourir"
            On récupère pour cela l'image transmise: on déclare une variable $imageTransmise
            Cette variable va contenir : 
            - ce qui est dans le formulaire ($form)
            - au niveau du paramètre du post/champ qui s'appelle'images' (->get('images))
            - on va aller chercher les données ( ->getData() )
            */
            $imageTransmise = $form->get('images')->getData();

            // Creation d'un nouveau nom de fichier stocké dans $fichier
            // md5 et uniqid sont 2 fonctions PHP qui vont nous permettre d'avoir un nom de fichier
            // avec une chaine de caractère un peu aléatoire
            // md5 : Message Digest 5, est une fonction de hachage cryptographique qui permet d'obtenir l'empreinte numérique d'un fichier
            // uniqid() : est basée sur le temps ! 
            // guessExtension : récupére l'extension de l'image envoyée en 'Upload'(Requet)
            $fichier = md5(uniqid()). '.' . $imageTransmise->guessExtension();

            // COPIE du fichier dans "uploads" avec fonction PHP 'move()'
            $imageTransmise->move(
                $this->getParameter('images_directory'),
                $fichier
            );

            // On stocke l'image dans la base de données (son nom)
            $newImageCarousel->setName($fichier);    // on met à jour le nom également dans la table ImagesCarouselAccueil

            /* Entity manager = em */
            $em = $this->getDoctrine()->getManager();
            $em->persist($newImageCarousel);
            $em->flush();

            return $this->redirectToRoute('admin_images_carousel_accueil_home'); // Redirection une fois le nouveau slide carousel créé
        }
        // Page formulaire d'ajout d'une slide si non envoyé : 
        return $this->render('admin/images_carousel_accueil/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }

/**
     * @Route("/admin/images_carousel_accueil/modifier/{id}", name="admin_images_carousel_accueil_modifier")
     */
    public function editImageCarouselAccueil(ImagesCarouselAccueil $imagesCarouselAccueil, Request $request): Response
    {
        /* Creation d'un formulaire pour pouvoir modifier la photo de la slide carousel déjà existante que l'on va renvoyer dans la vue une fois éditée: */        
        $form = $this->createForm(ImagesCarouselAccueilType::class, $imagesCarouselAccueil);
        /* Traitement de la request du formulaire une fois le bouton 'valider' cliqué : */
        $form->handleRequest($request);

        //Traitement du formulaire - Slide envoyé
        if ($form->isSubmitted() && $form->isValid()){

            /* A l'intérieur du traitement du formulaire, on va devoir gérer l'image chargée précédemment avec le bouton "Parcourir"
            On récupère pour cela l'image transmise: on déclare une variable $imageTransmise
            Cette variable va contenir : 
            - ce qui est dans le formulaire ($form)
            - au niveau du paramètre du post/champ qui s'appelle'images' (->get('images))
            - on va aller chercher les données ( ->getData() )
            */

            $imageTransmise = $form->get('images')->getData();

            // on génére un nouveau nom de fichier
            $fichier = md5(uniqid()). '.' . $imageTransmise->guessExtension();

            // On copie la nouvelle image du slide carousel dans le dossier uploads à l'aide la fonction PHP move()
            $imageTransmise->move(
                $this->getParameter('images_directory'),
                $fichier
            );

            // RAJOUT***************************
            // Si l'on a précédémment une image (ce qui est notre cas vu que l'on modifie le slide), alors on va supprimer l'image qui a été stockée physiquement dans le dossier "uploads"
            if (null!==($imagesCarouselAccueil->getName())){
                // On récupère le nom de l'image
                $nom = $imagesCarouselAccueil->getName();

                // On supprime le fichier du dossier Uploads
                unlink($this->getParameter('images_directory').'/'.$nom);
            }
            // ********************************


            // on met ensuite à jour le nom de l'objet ImagesCarouselAccueil (notre slide) dans la BDD
            $imagesCarouselAccueil->setName($fichier);    

            // On stocke ensuite l'image dans la base de données (simplement son nom) :
            /* Entity manager = em */
            $em = $this->getDoctrine()->getManager();
            $em->persist($imagesCarouselAccueil);
            $em->flush();

            return $this->redirectToRoute('admin_images_carousel_accueil_home'); // Redirection une fois le nouveau slide carousel créé
        }
        // Page formulaire d'ajout d'une slide si non envoyé : 
        return $this->render('admin/images_carousel_accueil/ajout.html.twig', [
            'imageCarousel' => $imagesCarouselAccueil,
            'form' => $form->createView()
        ]);
    }


}
