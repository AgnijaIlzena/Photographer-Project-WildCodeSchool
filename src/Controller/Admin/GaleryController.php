<?php

namespace App\Controller\Admin;

use App\Entity\Galery;
use App\Entity\Photo;
use App\Form\GaleryType;
use App\Repository\GaleryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/galery")
 */
class GaleryController extends AbstractController
{
    /**
     * @Route("/", name="galery_index", methods={"GET"})
     */
    public function index(GaleryRepository $galeryRepository): Response
    {
        return $this->render('/adminDashboard/galery/index.html.twig', [
            'galeries' => $galeryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="galery_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $galery = new Galery();
        $form = $this->createForm(GaleryType::class, $galery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //treatement of photos
            $photos = $form->get('photo')->getData();

            //loop through photos
            foreach ($photos as $photo) {
                //generate new name of file
                $file = md5(uniqid()) . '.' . $photo->guessExtension();

                //copy the file in upload folder
                $photo->move(
                    $this->getParameter('images_directory'),
                    $file
                );

                //stock image in data base (stock the name)
                $img = new Photo();
                $img->setPath($file);
                $galery->addPhoto($img);
            }

            $entityManager->persist($galery);
            $entityManager->flush();

            return $this->redirectToRoute('galery_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('adminDashboard/galery/new.html.twig', [
            'galery' => $galery,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="galery_show", methods={"GET"})
     */
    public function show(Galery $galery): Response
    {
        return $this->render('adminDashboard/galery/show.html.twig', [
            'galery' => $galery,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="galery_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Galery $galery, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GaleryType::class, $galery);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //treatment of photos
            $photos = $form->get('photo')->getData();
            //loop through photos
            foreach ($photos as $photo) {
                //generate new name of folder
                $file = md5(uniqid()) . '.' . $photo -> guessExtension();
                //copy the file in upload folder
                $photo->move(
                    $this->getParameter('images_directory'),
                    $file
                );
                //stock image in data base (stock the name)
                $img = new Photo();
                $img->setPath($file);
                $galery->addPhoto($img);
            }
            $entityManager->flush();
            return $this->redirectToRoute('galery_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('adminDashboard/galery/edit.html.twig', [
            'galery' => $galery,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="galery_delete", methods={"POST"})
     */
    public function delete(Request $request, Galery $galery, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $galery->getId(), (string) $request->request->get('_token'))) {
            $entityManager->remove($galery);
            $entityManager->flush();
        }
        return $this->redirectToRoute('galery_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
    * @Route ("/photo/{id}", name="galery_photo_delete")
    */
    public function deletePhoto(Photo $photo, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $photo->getId(), (string) $request->request->get('_token'))) {
            $entityManager->remove($photo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('galery_index', [], Response::HTTP_SEE_OTHER);
    }
}
