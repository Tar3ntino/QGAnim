<?php

namespace App\Controller\Admin;

use App\Entity\Images;
use App\Entity\Animations;
use App\Form\AnimationsType;
use App\Repository\AnimationsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
     * @Route("/admin/animations", name="admin_animations_")
     * @package App\Controller\Admin
     */
    class AnimationsController extends AbstractController
    {
        /**
         * @Route("/", name="home")
         */
        public function index(AnimationsRepository $animationsRepo)
        {
            return $this->render('admin/animations/index.html.twig', [
                'animations' => $animationsRepo->findAll()
            ]);
        }

        /**
         * @Route("/ajout", name="ajout")
         * Pour créer un formulaire, il est nécessaire d'avoir en paramètre l'objet Request provenant de la classe HttpFoundation à importer use...
         */
        public function ajoutAnimation(Request $request, SluggerInterface $slugger)
        {
        /* Creation d'une nouvelle animation : */
        $animation = new Animations;
        /* Creation d'un formulaire pour pouvoir ajouter la nouvelle animation que l'on va renvoyer dans la vue pour la saisie : */
        $form = $this->createForm(AnimationsType::class, $animation);
        /* Traitement de la request du formulaire une fois le bouton 'valider' cliqué : */
        $form->handleRequest($request);

        /* Dans le cas ou le formulaire est soumis ET valide : */
        if ($form->isSubmitted() && $form->isValid()){
            // On récupère les images transmises: on déclare une variable $images, on lui affecte(=) la donnée qui se trouve dans le formulaire $form au niveau du paramètre du POST qui s'appelle 'images' et on va aller chercher les données getdata
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
                $animation->addImage($img);
            }

            /* Entity manager = em */
            $em = $this->getDoctrine()->getManager();
            $animation->setSlug($slugger->slug($animation->getTitle())->lower()); // pour qu'il soit en minuscule
            $em->persist($animation);
            $em->flush();
            $this->addFlash('success', 'Animation ajoutée avec succès');
            return $this->redirectToRoute('admin_animations_home'); // Redirection une fois l'animation ajoutée
        }
        // Page formulaire d'ajout d'animation si non envoyé : 
        return $this->render('admin/animations/ajout.html.twig', [ 
            'AnimationForm' => $form->createView()
        ]);
        }

    /**
     * @Route("/modifier/{slug}", name="modifier")
     * Pour créer un formulaire, il est nécessaire d'avoir en paramètre l'objet Request
     * provenant de la classe HttpFoundation à importer use...
     * On récupère l'objet $animation provenant du {slug} dans la route /modifier
     * On ne fait pas de new (pas d'instanciation car l'objet existe déjà)
     */
    public function modifAnimation(Animations $animation, Request $request, SluggerInterface $slugger)
    {
        /* Creation d'un formulaire pour pouvoir modifier l'animation déjà existante que l'on va renvoyer dans la vue une fois éditée: */
        $form = $this->createForm(AnimationsType::class, $animation);

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
                $animation->addImage($img);
            }
            /* Entity manager = em */
            $em = $this->getDoctrine()->getManager();
            $animation->setSlug($slugger->slug($animation->getTitle())->lower()); // pour qu'il soit en minuscule
            $em->persist($animation);
            $em->flush();
            $this->addFlash('success', 'Animation modifiée avec succès');

            return $this->redirectToRoute('admin_animations_home');
        }
        return $this->render('admin/animations/ajout.html.twig', [
            'animation' => $animation,
            'AnimationForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/supprimer/{slug}", name="supprimer")
     */
        public function supprimerAnimation(Animations $animation)
    {   
            /* Entity manager = em */
            $em = $this->getDoctrine()->getManager();
            $em->remove($animation);
            $em->flush();
            $this->addFlash('success', 'Animation supprimée avec succès');
            return $this->redirectToRoute('admin_animations_home');
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