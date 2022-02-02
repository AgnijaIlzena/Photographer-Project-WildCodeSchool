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
     * @Route("/", name="admin_galery_index", methods={"GET"})
     */
    public function index(GaleryRepository $galeryRepository): Response
    {
        return $this->render('/adminDashboard/galery/index.html.twig', [
            'galeries' => $galeryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_galery_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $galery = new Galery();
        $form = $this->createForm(GaleryType::class, $galery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($galery);
            $entityManager->flush();
            return $this->redirectToRoute('admin_galery_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('adminDashboard/galery/new.html.twig', [
            'galery' => $galery,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_galery_show", methods={"GET"})
     */
    public function show(Galery $galery): Response
    {
        return $this->render('adminDashboard/galery/show.html.twig', [
            'galery' => $galery,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_galery_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Galery $galery, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GaleryType::class, $galery);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('galery_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('adminDashboard/galery/edit.html.twig', [
            'galery' => $galery,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_galery_delete", methods={"POST"})
     ,*/
    public function delete(Request $request, Galery $galery, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $galery->getId(), (string) $request->request->get('_token'))) {
            $entityManager->remove($galery);
            $entityManager->flush();
        }
        return $this->redirectToRoute('admin_galery_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
    * @Route ("/photo/{id}", name="admin_galery_photo_delete")
    */
    public function deletePhoto(Photo $photo, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $photo->getId(), (string) $request->request->get('_token'))) {
            $entityManager->remove($photo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_galery_index', [], Response::HTTP_SEE_OTHER);
    }
}
