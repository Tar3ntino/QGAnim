<?php

namespace App\Controller\Admin;

use App\Entity\Animations;
use App\Entity\Categories;
use App\Form\AnimationsType;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
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
    public function index(CategoriesRepository $categoryRepository)
    {
        return $this->render('admin/categories/index.html.twig', [
            'categories'=>$categoryRepository->findBy(['isActived'=>true],['name'=>'ASC']),
        ]);
    }

    /**
     * @Route("/ajout", name="ajout")
     * Pour créer un formulaire, il est nécessaire d'avoir en paramètre l'objet Request
     * provenant de la classe HttpFoundation à importer use...
     */
    public function ajoutCategorie(Request $request, SluggerInterface $slugger)
    {
        /* Creation d'une nouvelle catégorie : */
        $categorie = new Categories;

        /* Creation d'un formulaire pour pouvoir ajouter la nouvelle catégorie que l'on va renvoyer dans la vue pour la saisie : */
        $form = $this->createForm(CategoriesType::class, $categorie);

        /* Traitement de la request du formulaire une fois le bouton 'valider' cliqué : */

        $form->handleRequest($request);

        /* Dans le cas ou le formulaire est soumis ET valide : */
        if ($form->isSubmitted() && $form->isValid()){

            //methode 3 en passant l'objet dans createForm pour qu'il hydrate l'objet Category
            //dd($category);

            //methode 2 via request
            //dd($request->request->get('category_form')['name']);
            //$name=$request->request->get('category_form')['name'];
            //$content=$request->request->get('category_form')['content'];
            //dd($request->server->get('HTTP_HOST'));

            //methode 1 via formType
            //$name=$form->getData()->getName();
            //$content=$form->getData()->getContent();
            //$category->setName($name);
            //$category->setContent($content);
            //$em= $this->getDoctrine()->getManager(); //sans EntityManagerInterface $em uniquement dans un controller extends AbstractController

            /* Entity manager = em */
            $em = $this->getDoctrine()->getManager();
            $categorie->setSlug($slugger->slug($categorie->getName())->lower()); // pour qu'il soit en minuscule
            $em->persist($categorie);
            $em->flush();
            $this->addFlash('success', 'Catégorie ajoutée avec succès');
            return $this->redirectToRoute('admin_categories_home');
        }

        return $this->render('admin/categories/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }

/**
     * @Route("/modifier/{slug}", name="modifier")
     * Pour créer un formulaire, il est nécessaire d'avoir en paramètre l'objet Request
     * provenant de la classe HttpFoundation à importer use...
     */
    public function modifCategorie(Categories $categorie, Request $request, SluggerInterface $slugger)
    {
        /* Creation d'un formulaire pour pouvoir ajouter la nouvelle catégorie que l'on va renvoyer dans la vue pour la saisie : */
        $form = $this->createForm(CategoriesType::class, $categorie);

        /* Traitement de la request du formulaire une fois le bouton 'valider' cliqué : */

        $form->handleRequest($request);

        /* Dans le cas ou le formulaire est soumis ET valide : */
        if ($form->isSubmitted() && $form->isValid()){

            $categorie->setSlug($slugger->slug($categorie->getName())->lower()); // pour qu'il soit en minuscule
            $categorie->setUpdateAt(new \DateTime()); // le backslash (\) evite d'importer la classe
            /* Entity manager = em */
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();
            $this->addFlash('success', 'Catégorie modifiée avec succès');
            return $this->redirectToRoute('admin_categories_home');
        }

        return $this->render('admin/categories/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/supprimer/{slug}", name="supprimer")
     */
    public function supprimerCategorie(Categories $categorie)
    {   
            /* Entity manager = em */
            $em = $this->getDoctrine()->getManager();
            $em->remove($categorie);
            $em->flush();
            $this->addFlash('success', 'Catégorie supprimée avec succès');
            return $this->redirectToRoute('admin_categories_home');
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