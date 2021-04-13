<?php

namespace App\Controller;

use App\Entity\Animations;
use App\Repository\AnimationsRepository;
use App\Repository\ImagesCarouselAccueilRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(AnimationsRepository $animationsRepo, ImagesCarouselAccueilRepository $imagesCarouselRepo): Response
    {
        return $this->render('main/index.html.twig', [
            'imagesCarousel' => $imagesCarouselRepo->findAll(),
            'animations' => $animationsRepo->findAll()
        ]);
    }

    /**
     * @Route ("/animations", name="app_animations")
     * @param AnimationsRepository $animationsRepository
     * Cette route renvoie sur la page des animations du site
     */

    public function animations(AnimationsRepository $animationsRepository)
    {
         // A l'appel de la route, nous renvoyons l'utilisateur vers la vue twig. La méthode findAll va rechercher toutes les animations enregistrées en BDD qui seront stockées dans la variable "animations" qui pourra être exploitée dans notre vue
        return $this->render('main/animations.html.twig', [
            "animations" => $animationsRepository->findAll()
        ]);
    }

    /**
     * @Route ("/animations/{slug}", name="app_animations_details")
     * @param AnimationsRepository $animationsRepository
     */

    public function show(Animations $animations)
    {
        // dd($animations);
        // A l'appel de la route, nous renvoyons l'utilisateur vers la vue twig. La méthode findAll va rechercher toutes les animations enregistrées en BDD qui seront stockées dans la variable "animations" qui pourra être exploitée dans notre vue
        return $this->render('main/animations-show.html.twig', [
            "animations" => $animations
        ]);
    }

    /**
     * @Route ("/presentation", name="app_presentation")
     * @param AnimationsRepository $animationsRepository
     * Cette route renvoie sur la page de presentation du site
     */

    public function presentation()
    {
         // on affiche notre template (plus tard on pourra lui passer des variables et autres 
        return $this->render('main/presentation.html.twig');
    }

    /**
     * @Route("/cgu", name="app_cgu")
     */
    public function cgu()
    {
        return $this->render('main/conditions-generales-utilisation.html.twig');
    }




}