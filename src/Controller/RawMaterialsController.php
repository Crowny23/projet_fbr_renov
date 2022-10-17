<?php

namespace App\Controller;

use App\Entity\RawMaterials;
use App\Form\RawMaterialsType;
use App\Form\SearchFormType;
use App\Repository\OrdersRepository;
use App\Repository\RawMaterialsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/materiaux')]
class RawMaterialsController extends AbstractController
{
    #[Route('/', name: 'app_raw_materials_index', methods: ['GET', 'POST'])]
    public function index(RawMaterialsRepository $rawMaterialsRepository, Request $request, OrdersRepository $ordersRepository): Response
    {
        $rawMaterial = new RawMaterials();
        $searchForm = $this->createForm(SearchFormType::class, $rawMaterial, ['method' => 'POST']);
        $searchForm->handleRequest($request);

        $list = $rawMaterialsRepository->findAll();

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $search = $searchForm->getViewData()->getNameRawMaterial();
            $category = $searchForm->getViewData()->getCategory();
            $list = $rawMaterialsRepository->findByNameAndCategory($search, $category);
        }
        
        $lastOrders = $ordersRepository->findBy([], ['id' => 'DESC'], 10, 0);

        return $this->renderForm('raw_materials/index.html.twig', [
            'raw_materials' => $list,
            'searchForm' => $searchForm,
            'orders' => $lastOrders
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
            'form' => $form
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

    #[Route('/ajax/orders/{searchOrder<\d*[a-zA-Z][a-zA-Z0-9]*>?}', name: 'app_last_10_orders', methods: ['GET'])]
    public function getLastOrders($searchOrder = null, OrdersRepository $ordersRepository)
    {
        if($searchOrder === null || $searchOrder === ''){
            $lastOrders = $ordersRepository->findBy([], ['id' => 'DESC'], 10, 0);
        } else {
            $lastOrders = $ordersRepository->findByName($searchOrder);
        }

        $lastOrdersNames = [];

        foreach ($lastOrders as $key => $order) {
            $orderName = $order->getNameOrder();
            $orderId = $order->getId();
            $tmpArray['id'] = $orderId;
            $tmpArray['name'] = $orderName;
            $lastOrdersNames[$orderName] = $tmpArray;
        }

        $lastOrdersNamesJson = json_encode($lastOrdersNames);
        // dd($lastOrdersNamesJson);

        return $this->render('orders/last10.html.twig', [
            'lastOrders' => $lastOrdersNamesJson
        ]);
    }
}
