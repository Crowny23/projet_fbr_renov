<?php

namespace App\Controller;

use App\Entity\RepairsCategories;
use App\Form\RepairsCategoriesType;
use App\Repository\RepairsCategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/repairs-categories')]
class RepairsCategoriesController extends AbstractController
{
    #[Route('/', name: 'app_repairs_categories_index', methods: ['GET'])]
    public function index(RepairsCategoriesRepository $repairsCategoriesRepository): Response
    {
        return $this->render('repairs_categories/index.html.twig', [
            'repairs_categories' => $repairsCategoriesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_repairs_categories_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RepairsCategoriesRepository $repairsCategoriesRepository): Response
    {
        $repairsCategory = new RepairsCategories();
        $form = $this->createForm(RepairsCategoriesType::class, $repairsCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repairsCategoriesRepository->save($repairsCategory, true);

            return $this->redirectToRoute('app_repairs_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('repairs_categories/new.html.twig', [
            'repairs_category' => $repairsCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_repairs_categories_show', methods: ['GET'])]
    public function show(RepairsCategories $repairsCategory): Response
    {
        return $this->render('repairs_categories/show.html.twig', [
            'repairs_category' => $repairsCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_repairs_categories_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RepairsCategories $repairsCategory, RepairsCategoriesRepository $repairsCategoriesRepository): Response
    {
        $form = $this->createForm(RepairsCategoriesType::class, $repairsCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repairsCategoriesRepository->save($repairsCategory, true);

            return $this->redirectToRoute('app_repairs_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('repairs_categories/edit.html.twig', [
            'repairs_category' => $repairsCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_repairs_categories_delete', methods: ['POST'])]
    public function delete(Request $request, RepairsCategories $repairsCategory, RepairsCategoriesRepository $repairsCategoriesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$repairsCategory->getId(), $request->request->get('_token'))) {
            $repairsCategoriesRepository->remove($repairsCategory, true);
        }

        return $this->redirectToRoute('app_repairs_categories_index', [], Response::HTTP_SEE_OTHER);
    }
}
