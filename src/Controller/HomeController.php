<?php

namespace App\Controller;

use App\Entity\Galery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $publicGaleries = $this->getDoctrine()
            ->getRepository(Galery::class)
            ->findBy(
                ['password' => null],
            );

        shuffle($publicGaleries);

        $galery = $publicGaleries[0];

        return $this->render(
            'home/index.html.twig',
            ['galery' => $galery]
        );
    }
}
