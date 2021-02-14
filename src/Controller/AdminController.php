<?php

namespace App\Controller;

use App\Entity\Animations;
use App\Entity\Categories;
use App\Form\AnimationsType;
use App\Form\CategoriesType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/admin", name="admin_")
 * @package App\Controller
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/categories/ajout", name="categories_ajout")
     * Pour créer un formulaire, il est nécessaire d'avoir en paramètre l'objet Request
     * provenant de la classe HttpFoundation à importer use...
     */
    public function ajoutCategorie(Request $request)
    {
        /* Creation d'une nouvelle catégorie : */
        $categorie = new Categories;

        /* Creation d'un formulaire pour pouvoir ajouter la nouvelle catégorie que l'on va renvoyer dans la vue pour la saisie : */
        $form = $this->createForm(CategoriesType::class, $categorie);

        /* Traitement de la request du formulaire une fois le bouton 'valider' cliqué : */

        $form->handleRequest($request);

        /* Dans le cas ou le formulaire est soumis ET valide : */
        if ($form->isSubmitted() && $form->isValid()){

            /* Entity manager = em */
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute('admin_home');

        }

        return $this->render('admin/categories/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/animations/ajout", name="animations_ajout")
     * Pour créer un formulaire, il est nécessaire d'avoir en paramètre l'objet Request
     * provenant de la classe HttpFoundation à importer use...
     */
    public function ajoutAnimation(Request $request)
    {
        /* Creation d'une nouvelle catégorie : */
        $animation = new Animations;
        /* Creation d'un formulaire pour pouvoir ajouter la nouvelle catégorie que l'on va renvoyer dans la vue pour la saisie : */
        $form = $this->createForm(AnimationsType::class, $animation);
        /* Traitement de la request du formulaire une fois le bouton 'valider' cliqué : */
        $form->handleRequest($request);

        /* Dans le cas ou le formulaire est soumis ET valide : */
        if ($form->isSubmitted() && $form->isValid()){
            /* Entity manager = em */
            $em = $this->getDoctrine()->getManager();
            $em->persist($animation);
            $em->flush();
            return $this->redirectToRoute('admin_home');
        }

        return $this->render('admin/animations/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
