<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route ("/animations", name="animations")
     * Cette route renvoie sur la page des animations du site
     */

    public function animations()
    {
         // on affiche notre template (plus tard on pourra lui passer des variables et autres 
        return $this->render('main/animations.html.twig');
    }



}
