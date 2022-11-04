<?php

namespace App\Controller\Admin;

use App\Entity\WorksiteImages;
use App\Form\WorksiteImagesType;
use App\Repository\WorksiteImagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/chantiers-images')]
class WorksiteImagesController extends AbstractController
{
    #[Route('/', name: 'app_worksite_images_index', methods: ['GET'])]
    public function index(WorksiteImagesRepository $worksiteImagesRepository): Response
    {
        return $this->render('worksite_images/index.html.twig', [
            'worksite_images' => $worksiteImagesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_worksite_images_new', methods: ['GET', 'POST'])]
    public function new(Request $request, WorksiteImagesRepository $worksiteImagesRepository): Response
    {
        $worksiteImage = new WorksiteImages();
        $form = $this->createForm(WorksiteImagesType::class, $worksiteImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $worksiteImagesRepository->save($worksiteImage, true);
            $worksiteImage->setFile($request->files->get('worksite_images')['file']);

            return $this->redirectToRoute('app_worksite_images_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('worksite_images/new.html.twig', [
            'worksite_image' => $worksiteImage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_worksite_images_show', methods: ['GET'])]
    public function show(WorksiteImages $worksiteImage): Response
    {
        return $this->render('worksite_images/show.html.twig', [
            'worksite_image' => $worksiteImage,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_worksite_images_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, WorksiteImages $worksiteImage, WorksiteImagesRepository $worksiteImagesRepository): Response
    {
        $form = $this->createForm(WorksiteImagesType::class, $worksiteImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $worksiteImagesRepository->save($worksiteImage, true);

            return $this->redirectToRoute('app_worksite_images_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('worksite_images/edit.html.twig', [
            'worksite_image' => $worksiteImage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_worksite_images_delete', methods: ['POST'])]
    public function delete(Request $request, WorksiteImages $worksiteImage, WorksiteImagesRepository $worksiteImagesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$worksiteImage->getId(), $request->request->get('_token'))) {
            $worksiteImagesRepository->remove($worksiteImage, true);
        }

        return $this->redirectToRoute('app_worksite_images_index', [], Response::HTTP_SEE_OTHER);
    }
}
