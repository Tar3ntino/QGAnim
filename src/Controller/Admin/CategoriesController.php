<?php

namespace App\Controller\Admin;

use App\Entity\Animations;
use App\Entity\Categories;
use App\Form\AnimationsType;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/admin/categories", name="admin_categories_")
 * @package App\Controller\Admin
 */
class CategoriesController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(CategoriesRepository $catsrepo)
    {
        return $this->render('admin/categories/index.html.twig', [
            'categories' => $catsrepo->findAll()
        ]);
    }

    /**
     * @Route("/ajout", name="ajout")
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

            return $this->redirectToRoute('admin_categories_home');

        }

        return $this->render('admin/categories/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }

/**
     * @Route("/modifier/{id}", name="modifier")
     * Pour créer un formulaire, il est nécessaire d'avoir en paramètre l'objet Request
     * provenant de la classe HttpFoundation à importer use...
     */
    public function modifCategorie(Categories $categorie, Request $request)
    {
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

            return $this->redirectToRoute('admin_categories_home');

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
