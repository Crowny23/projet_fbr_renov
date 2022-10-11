<?php

namespace App\Controller;

use App\Entity\RawMaterials;
use App\Form\RawMaterialsType;
use App\Form\SearchFormType;
use App\Repository\RawMaterialsRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/materiaux')]
class RawMaterialsController extends AbstractController
{
    #[Route('/', name: 'app_raw_materials_index', methods: ['GET'])]
    public function index(RawMaterialsRepository $rawMaterialsRepository, Request $request): Response
    {
        $rawMaterial = new RawMaterials();
        $searchForm = $this->createForm(SearchFormType::class, $rawMaterial, ['method' => 'GET']);
        $searchForm->handleRequest($request);

        $list = $rawMaterialsRepository->findAll();

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $search = $searchForm->getViewData()->getNameRawMaterial();
            $category = $searchForm->getViewData()->getCategory();
            $list = $rawMaterialsRepository->findByNameAndCategory($search, $category);
        }

        return $this->renderForm('raw_materials/index.html.twig', [
            'raw_materials' => $list,
            'searchForm' => $searchForm
        ]);
    }

    #[Route('/new', name: 'app_raw_materials_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RawMaterialsRepository $rawMaterialsRepository): Response
    {
        $rawMaterial = new RawMaterials();
        $form = $this->createForm(RawMaterialsType::class, $rawMaterial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rawMaterialsRepository->save($rawMaterial, true);

            return $this->redirectToRoute('app_raw_materials_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('raw_materials/new.html.twig', [
            'raw_material' => $rawMaterial,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_raw_materials_show', methods: ['GET'])]
    public function show(RawMaterials $rawMaterial): Response
    {
        return $this->render('raw_materials/show.html.twig', [
            'raw_material' => $rawMaterial,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_raw_materials_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RawMaterials $rawMaterial, RawMaterialsRepository $rawMaterialsRepository): Response
    {
        $form = $this->createForm(RawMaterialsType::class, $rawMaterial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rawMaterialsRepository->save($rawMaterial, true);

            return $this->redirectToRoute('app_raw_materials_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('raw_materials/edit.html.twig', [
            'raw_material' => $rawMaterial,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_raw_materials_delete', methods: ['POST'])]
    public function delete(Request $request, RawMaterials $rawMaterial, RawMaterialsRepository $rawMaterialsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rawMaterial->getId(), $request->request->get('_token'))) {
            $rawMaterialsRepository->remove($rawMaterial, true);
        }

        return $this->redirectToRoute('app_raw_materials_index', [], Response::HTTP_SEE_OTHER);
    }
}
