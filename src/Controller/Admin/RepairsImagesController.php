<?php

namespace App\Controller\Admin;

use App\Entity\Repairs;
use App\Entity\RepairsImages;
use App\Form\RepairsImagesType;
use App\Repository\RepairsImagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/depannages-images')]
class RepairsImagesController extends AbstractController
{
    #[Route('/', name: 'app_repairs_images_index', methods: ['GET'])]
    public function index(RepairsImagesRepository $repairsImagesRepository): Response
    {
        return $this->render('repairs_images/index.html.twig', [
            'repairs_images' => $repairsImagesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_repairs_images_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RepairsImagesRepository $repairsImagesRepository): Response
    {
        $repairsImage = new RepairsImages();
        $form = $this->createForm(RepairsImagesType::class, $repairsImage);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $repairsImagesRepository->save($repairsImage, true);
            $repairsImage->setFile($request->files->get('repairs_images')['file']);

            return $this->redirectToRoute('app_repairs_images_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('repairs_images/new.html.twig', [
            'repairs_image' => $repairsImage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_repairs_images_show', methods: ['GET'])]
    public function show(RepairsImages $repairsImage): Response
    {
        return $this->render('repairs_images/show.html.twig', [
            'repairs_image' => $repairsImage,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_repairs_images_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RepairsImages $repairsImage, RepairsImagesRepository $repairsImagesRepository): Response
    {
        $form = $this->createForm(RepairsImagesType::class, $repairsImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repairsImagesRepository->save($repairsImage, true);
            $repairsImage->setFile($request->files->get('repairs_images')['file']);

            return $this->redirectToRoute('app_repairs_images_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('repairs_images/edit.html.twig', [
            'repairs_image' => $repairsImage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_repairs_images_delete', methods: ['POST'])]
    public function delete(Request $request, RepairsImages $repairsImage, RepairsImagesRepository $repairsImagesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$repairsImage->getId(), $request->request->get('_token'))) {
            $repairsImagesRepository->remove($repairsImage, true);
        }

        return $this->redirectToRoute('app_repairs_images_index', [], Response::HTTP_SEE_OTHER);
    }
}
