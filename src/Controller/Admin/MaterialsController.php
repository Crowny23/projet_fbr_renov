<?php

namespace App\Controller\Admin;

use App\Entity\Materials;
use App\Form\MaterialsType;
use App\Repository\MaterialsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/materials')]
class MaterialsController extends AbstractController
{
    #[Route('/', name: 'app_materials_index', methods: ['GET'])]
    public function index(MaterialsRepository $materialsRepository): Response
    {
        return $this->render('materials/index.html.twig', [
            'materials' => $materialsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_materials_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MaterialsRepository $materialsRepository): Response
    {
        $material = new Materials();
        $form = $this->createForm(MaterialsType::class, $material);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $materialsRepository->save($material, true);

            return $this->redirectToRoute('app_materials_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('materials/new.html.twig', [
            'material' => $material,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_materials_show', methods: ['GET'])]
    public function show(Materials $material): Response
    {
        return $this->render('materials/show.html.twig', [
            'material' => $material,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_materials_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Materials $material, MaterialsRepository $materialsRepository): Response
    {
        $form = $this->createForm(MaterialsType::class, $material);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $materialsRepository->save($material, true);

            return $this->redirectToRoute('app_materials_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('materials/edit.html.twig', [
            'material' => $material,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_materials_delete', methods: ['POST'])]
    public function delete(Request $request, Materials $material, MaterialsRepository $materialsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$material->getId(), $request->request->get('_token'))) {
            $materialsRepository->remove($material, true);
        }

        return $this->redirectToRoute('app_materials_index', [], Response::HTTP_SEE_OTHER);
    }
}
