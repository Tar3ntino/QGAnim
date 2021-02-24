<?php

namespace App\Controller;

use App\Repository\AnimationsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(AnimationsRepository $animationsRepo): Response
    {
        return $this->render('main/index.html.twig', [
            'animations' => $animationsRepo->findAll(),
        ]);
    }

    /**
     * @Route ("/animations", name="app_animations")
     * @param AnimationsRepository $animationsRepository
     * Cette route renvoie sur la page des animations du site
     */

    public function animations(AnimationsRepository $animationsRepository)
    {
         // on affiche notre template (plus tard on pourra lui passer des variables et autres 
        return $this->render('main/animations.html.twig', [
            "animations" => $animationsRepository->findAll()
        ]);
    }



}
