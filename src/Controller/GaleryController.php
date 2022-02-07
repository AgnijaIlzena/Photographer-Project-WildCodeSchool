<?php

namespace App\Controller;

use App\Entity\Galery;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\DownloadManager;
use ZipArchive;

class GaleryController extends AbstractController
{
    /**
     * @Route("/galery", name="galery_index")
     */
    public function index(): Response
    {
        $password = $_GET['password'] ?? null;

        $galeries = $this->getDoctrine()
            ->getRepository(Galery::class)
            ->findBy(['password' => $password]);

        return $this->render('galery/index.html.twig', [
            'galeries' => $galeries,
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
                'No galery found in galeries table.'
            );
        }

        return $this->render('galery/show.html.twig', [
            'galery' => $galery,
        ]);
    }

    /**
     * Create and download some zip documents.
     * @Route("/galery/{id}/download", requirements={"id"="\d+"}, methods={"GET"}, name="galery_show_download")
     *
     * */

    public function downloadPhotos(DownloadManager $downloadManager, EntityManagerInterface $em): Response
    {

        $galery = $em->getRepository(Galery::class)->findOneBy([]);

       /*$documents = $galery->getPhotos()->getValues();
         foreach ($documents as $document)
         {
             $files = $document->getPath();
         }*/
        $documents = ['0af93550b8fb169c59c54b81497dd35c.jpg',''];
        $download = $downloadManager->zipDownload($documents);

        return $this->render('galery/show.html.twig', [
            'galery' => $galery, 'download' => $download ]);
    }
}
