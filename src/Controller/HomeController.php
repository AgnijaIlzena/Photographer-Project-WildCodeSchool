<?php

namespace App\Controller;

use App\Entity\Photo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function createCarousel(): Response
    {
        $carousel = $this->getDoctrine()
            ->getRepository(Photo::class)
            ->findAll();

        return $this->render(
            'home/index.html.twig',
            ['carousel' => $carousel]
        );
    }
}
