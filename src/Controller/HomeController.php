<?php

namespace App\Controller;

use App\Entity\Photo;
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
        $publicgaleries = $this->getDoctrine()
            ->getRepository(Galery::class)
            ->findBy(
                ['password' => ''],
            );

        shuffle($publicgaleries);
        $galery = $publicgaleries[0];

        return $this->render(
            'home/index.html.twig',
            ['galery' => $galery]
        );
    }
}
