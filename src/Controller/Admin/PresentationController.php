<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/presentation", name="admin_presentation_")
 */

class PresentationController extends AbstractController
{
/**
 * @Route("/modifier", name="edit")
 */
    public function index(): Response
    {
        return $this->render('admin/presentation/edit.html.twig');
    }
}
