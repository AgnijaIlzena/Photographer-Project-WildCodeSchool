<?php

namespace App\Controller\Admin;

use App\Entity\Galery;
use App\Entity\Photo;
use App\Form\AdminLoginType;
use App\Repository\GaleryRepository;
use App\Repository\PhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_")
     */
    public function index(): Response
    {
        return $this->redirectToRoute('admin_galery_index');
    }

    /**
     * @Route ("/connect", name="connect")
     */
    public function connectAdmin(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('connect/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * @Route ("/logout", name="app_logout")
     */
    public function logout(): void
    {
    }
}
