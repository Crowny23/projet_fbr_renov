<?php

namespace App\Controller\Admin;

use App\Entity\RawMaterialsCategories;
use App\Form\RawMaterialsCategoriesType;
use App\Repository\RawMaterialsCategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/materiaux-categories')]
class RawMaterialsCategoriesController extends AbstractController
{
    #[Route('/', name: 'app_raw_materials_categories_index', methods: ['GET'])]
    public function index(RawMaterialsCategoriesRepository $rawMaterialsCategoriesRepository): Response
    {
        return $this->render('raw_materials_categories/index.html.twig', [
            'raw_materials_categories' => $rawMaterialsCategoriesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_raw_materials_categories_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RawMaterialsCategoriesRepository $rawMaterialsCategoriesRepository): Response
    {
        $rawMaterialsCategory = new RawMaterialsCategories();
        $form = $this->createForm(RawMaterialsCategoriesType::class, $rawMaterialsCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rawMaterialsCategoriesRepository->save($rawMaterialsCategory, true);

            return $this->redirectToRoute('app_raw_materials_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('raw_materials_categories/new.html.twig', [
            'raw_materials_category' => $rawMaterialsCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_raw_materials_categories_show', methods: ['GET'])]
    public function show(RawMaterialsCategories $rawMaterialsCategory): Response
    {
        return $this->render('raw_materials_categories/show.html.twig', [
            'raw_materials_category' => $rawMaterialsCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_raw_materials_categories_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RawMaterialsCategories $rawMaterialsCategory, RawMaterialsCategoriesRepository $rawMaterialsCategoriesRepository): Response
    {
        $form = $this->createForm(RawMaterialsCategoriesType::class, $rawMaterialsCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rawMaterialsCategoriesRepository->save($rawMaterialsCategory, true);

            return $this->redirectToRoute('app_raw_materials_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('raw_materials_categories/edit.html.twig', [
            'raw_materials_category' => $rawMaterialsCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_raw_materials_categories_delete', methods: ['POST'])]
    public function delete(Request $request, RawMaterialsCategories $rawMaterialsCategory, RawMaterialsCategoriesRepository $rawMaterialsCategoriesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rawMaterialsCategory->getId(), $request->request->get('_token'))) {
            $rawMaterialsCategoriesRepository->remove($rawMaterialsCategory, true);
        }

        return $this->redirectToRoute('app_raw_materials_categories_index', [], Response::HTTP_SEE_OTHER);
    }
}
