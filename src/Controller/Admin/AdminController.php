<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_")
     */
    public function index(): Response
    {
        return $this->render('adminDashboard/admin/index.html.twig', [
            'dashboard' => 'Admin dashboard',
        ]);
    }
}
