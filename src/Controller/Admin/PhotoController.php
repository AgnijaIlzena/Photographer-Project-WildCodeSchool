<?php

namespace App\Controller\Admin;

use App\Entity\Photo;
use App\Form\PhotosType;
use App\Form\PhotoType;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/photo")
 */
class PhotoController extends AbstractController
{
    /**
     * @Route("/", name="photo_index", methods={"GET"})
     */
    public function index(PhotoRepository $photoRepository): Response
    {
        return $this->render('adminDashboard/photo/index.html.twig', [
            'photos' => $photoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="photo_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $photo = new Photo();
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //treatment of photos
            /** @var UploadedFile $image */
            $image = $form->get('image')->getData();

            //generate new name of file
            $file = md5(uniqid()) . '.' . $image->guessExtension();

            //copy the file in upload folder
            $image->move(
                $this->getParameter('images_directory'),
                $file
            );

            //stock the name in entity
            $photo->setPath($file);

            $entityManager->persist($photo);
            $entityManager->flush();

            return $this->redirectToRoute('photo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('adminDashboard/photo/new.html.twig', [
            'photo' => $photo,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/new2", name="photo_new2", methods={"GET", "POST"})
     */
    public function new2(Request $request, EntityManagerInterface $entityManager): Response
    {
        $photos = [
            'photos' => [
                new Photo(),
                new Photo(),
                new Photo(),
            ]
        ];

        $form = $this->createForm(PhotosType::class, $photos);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //treatment of photo
            foreach ($form->get('photos') as $index => $singleForm) {
                /** @var UploadedFile $image */
                $image = $singleForm->get('image')->getData();

                if ($image !== null) {
                    //generate new name of file
                    $file = md5(uniqid()) . '.' . $image->guessExtension();

                    //copy the file in upload folder
                    $image->move(
                        $this->getParameter('images_directory'),
                        $file
                    );

                    //stock the name in entity
                    $photos['photos'][$index]->setPath($file);

                    $entityManager->persist($photos['photos'][$index]);
                    $entityManager->flush();
                }
            }

            return $this->redirectToRoute('photo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('adminDashboard/photo/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="photo_show", methods={"GET"})
     */
    public function show(Photo $photo): Response
    {
        return $this->render('adminDashboard/photo/show.html.twig', [
            'photo' => $photo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="photo_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Photo $photo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('photo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('adminDashboard/photo/edit.html.twig', [
            'photo' => $photo,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="photo_delete", methods={"POST"})
     */
    public function delete(Request $request, Photo $photo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $photo->getId(), (string)$request->request->get('_token'))) {
            $entityManager->remove($photo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('photo_index', [], Response::HTTP_SEE_OTHER);
    }
}
