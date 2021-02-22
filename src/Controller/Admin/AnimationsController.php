<?php

namespace App\Controller\Admin;

use App\Entity\Animations;
use App\Form\AnimationsType;
use App\Form\CategoriesType;
use App\Repository\AnimationsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
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
         * Pour créer un formulaire, il est nécessaire d'avoir en paramètre l'objet Request
         * provenant de la classe HttpFoundation à importer use...
         */
        public function ajoutAnimation(Request $request)
        {

        /* Creation d'une nouvelle animation : */
        $animation = new Animations;
        /* Creation d'un formulaire pour pouvoir ajouter la nouvelle animation que l'on va renvoyer dans la vue pour la saisie : */
        $form = $this->createForm(AnimationsType::class, $animation);
        /* Traitement de la request du formulaire une fois le bouton 'valider' cliqué : */
        $form->handleRequest($request);

        /* Dans le cas ou le formulaire est soumis ET valide : */
        if ($form->isSubmitted() && $form->isValid()){
            /* Entity manager = em */
            $em = $this->getDoctrine()->getManager();
            $em->persist($animation);
            $em->flush();
            return $this->redirectToRoute('admin_animations_home'); // Redirection une fois l'animation ajoutée
        }
        // Page formulaire d'ajout d'animation si non envoyé : 
        return $this->render('admin/animations/ajout.html.twig', [ 
            'form' => $form->createView()
        ]);
        }

    /**
     * @Route("/modifier/{id}", name="modifier")
     * Pour créer un formulaire, il est nécessaire d'avoir en paramètre l'objet Request
     * provenant de la classe HttpFoundation à importer use...
     * On récupère l'objet $animation provenant de l'{id} dans la route /modifier
     * On ne fait pas de new (pas d'instanciation car l'objet existe déjà)
     */
    public function modifAnimation(Animations $animation, Request $request)
    {
        /* Creation d'un formulaire pour pouvoir ajouter la nouvelle animation que l'on va renvoyer dans la vue pour la saisie : */
        $form = $this->createForm(AnimationsType::class, $animation);

        /* Traitement de la request du formulaire une fois le bouton 'valider' cliqué : */
        $form->handleRequest($request);

        /* Dans le cas ou le formulaire est soumis ET valide : */
        if ($form->isSubmitted() && $form->isValid()){

            /* Entity manager = em */
            $em = $this->getDoctrine()->getManager();
            $em->persist($animation);
            $em->flush();

            return $this->redirectToRoute('admin_animations_home');
        }

        return $this->render('admin/animations/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/supprimer/{id}", name="supprimer")
     */
        public function supprimerAnimation(Animations $animation)
    {   
            /* Entity manager = em */
            $em = $this->getDoctrine()->getManager();
            $em->remove($animation);
            $em->flush();

            $this->addFlash('message', 'Animation supprimée avec succès');
            return $this->redirectToRoute('admin_animations_home');
    }

}