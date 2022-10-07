<?php

namespace App\Controller;

use App\Entity\Repairs;
use App\Form\RepairsType;
use App\Repository\RepairsImagesRepository;
use App\Repository\RepairsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/repairs')]
class RepairsController extends AbstractController
{
    #[Route('/', name: 'app_repairs_index', methods: ['GET'])]
    public function index(RepairsRepository $repairsRepository): Response
    {
        return $this->render('repairs/index.html.twig', [
            'repairs' => $repairsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_repairs_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RepairsRepository $repairsRepository): Response
    {
        $repair = new Repairs();
        $form = $this->createForm(RepairsType::class, $repair);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repairsRepository->save($repair, true);

            return $this->redirectToRoute('app_repairs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('repairs/new.html.twig', [
            'repair' => $repair,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_repairs_show', methods: ['GET'])]
    public function show(Repairs $repair, RepairsImagesRepository $repairsImagesRepository): Response
    {
        $repairImages = $repairsImagesRepository->findByRepair($repair->getId());
        return $this->render('repairs/show.html.twig', [
            'repair' => $repair,
            'images' => $repairImages,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_repairs_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Repairs $repair, RepairsRepository $repairsRepository): Response
    {
        $form = $this->createForm(RepairsType::class, $repair);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repairsRepository->save($repair, true);

            return $this->redirectToRoute('app_repairs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('repairs/edit.html.twig', [
            'repair' => $repair,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_repairs_delete', methods: ['POST'])]
    public function delete(Request $request, Repairs $repair, RepairsRepository $repairsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$repair->getId(), $request->request->get('_token'))) {
            $repairsRepository->remove($repair, true);
        }

        return $this->redirectToRoute('app_repairs_index', [], Response::HTTP_SEE_OTHER);
    }
}
