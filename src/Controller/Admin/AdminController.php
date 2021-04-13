<?php

namespace App\Controller\Admin;

use App\Repository\PresentationRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/admin", name="admin_")
 * @package App\Controller\Admin
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PresentationRepository $presentationRepo)
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'presentations' => $presentationRepo->findAll()
        ]);
    }
}