<?php

namespace App\Controller;

use App\Entity\Galery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GaleryController extends AbstractController
{
    /**
     * @Route("/galery", name="galery_index")
     */
    public function index(): Response
    {
        return $this->render('galery/index.html.twig', [
            'galeries' => $this->getDoctrine()
                ->getRepository(Galery::class)
                ->findAll()
        ]);
    }

    /**
     * @Route("/galery/{id}", requirements={"id"="\d+"}, methods={"GET"}, name="galery_show")
     */
    public function show(int $id): Response
    {
        $galery = $this->getDoctrine()
            ->getRepository(Galery::class)
            ->findOneBy(['id' => $id]);

        if (!$galery) {
            throw $this->createNotFoundException(
                'No galery with id : ' . $id . ' found in galeries table.'
            );
        }

        $photos = $galery->getPhotos();


        return $this->render('galery/show.html.twig', [
            'galery' => $galery, 'photos' => $photos
        ]);
    }
}
