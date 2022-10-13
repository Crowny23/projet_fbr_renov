<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\RawMaterials;
use App\Entity\RawMaterialsOrdered;
use App\Form\RawMaterialsOrderedType;
use App\Repository\OrdersRepository;
use App\Repository\RawMaterialsOrderedRepository;
use App\Repository\RawMaterialsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/materiaux-commande')]
class RawMaterialsOrderedController extends AbstractController
{
    #[Route('/', name: 'app_raw_materials_ordered_index', methods: ['GET'])]
    public function index(RawMaterialsOrderedRepository $rawMaterialsOrderedRepository): Response
    {
        return $this->render('raw_materials_ordered/index.html.twig', [
            'raw_materials_ordereds' => $rawMaterialsOrderedRepository->findAll(),
        ]);
    }

    #[Route('/new/{idOrder}/{idRawMaterial}/{qtty}', name: 'app_raw_materials_ordered_new', methods: ['GET', 'POST'])]
    public function new($idOrder, $idRawMaterial, $qtty, Request $request, RawMaterialsOrderedRepository $rawMaterialsOrderedRepository, OrdersRepository $ordersRepository, RawMaterialsRepository $rawMaterialsRepository): Response
    {
        // Find order et rawMaterial by ID with url params
        $order =  $ordersRepository->find($idOrder);
        $rawMaterial = $rawMaterialsRepository->find($idRawMaterial);

        $rawMaterialsOrdered = $rawMaterialsOrderedRepository->findOneBy(['orders' => $order, 'raw_material' => $rawMaterial]);

        // dd($rawMaterialsOrdered, $order, $rawMaterial);

        if($rawMaterialsOrdered === null){
            $rawMaterialsOrdered = new RawMaterialsOrdered();

            // Get rawMaterial price and set rawMaterialOrdered total price 
            $rawMaterialPrice = $rawMaterial->getPrice();
            $rawMaterialTotalPrice = $rawMaterialPrice * $qtty;

            // Set all rawMaterialsOrdered property
            $rawMaterialsOrdered->setOrders($order);
            $rawMaterialsOrdered->setRawMaterial($rawMaterial);
            $rawMaterialsOrdered->setQuantity($qtty);
            $rawMaterialsOrdered->setTotalPriceRawMaterial($rawMaterialTotalPrice);

            // Set new total price for order
            $orderTotalPrice = $order->getTotalPrice();
            if($orderTotalPrice === null) {
                $orderTotalPrice = 0;
            }
            $orderNewTotalPrice = $orderTotalPrice + $rawMaterialTotalPrice;

            $order->setTotalPrice($orderNewTotalPrice);
        } else {
            // Set new rawMaterialOrdered quantity
            $oldQtty = $rawMaterialsOrdered->getQuantity();
            $newQtty = $oldQtty + $qtty;

            $rawMaterialsOrdered->setQuantity($newQtty);

            // Get old rawMaterialOrdered total price
            $oldRawMaterialOrderedPrice = $rawMaterialsOrdered->getTotalPriceRawMaterial();
            
            // Get old Order total price
            $oldOrderPrice = $order->getTotalPrice();

            // Set new rawMaterialOrdered total price
            $rawMaterialPrice = $rawMaterial->getPrice();
            $newRawMaterialOrderedPrice = $newQtty * $rawMaterialPrice;

            $rawMaterialsOrdered->setTotalPriceRawMaterial($newRawMaterialOrderedPrice);

            // Set new Orders total price
            $newOrderTotalPrice = $oldOrderPrice + ($newRawMaterialOrderedPrice - $oldRawMaterialOrderedPrice);

            $order->setTotalPrice($newOrderTotalPrice);
        }

        // Insert modification into DB
        $ordersRepository->save($order, true);
        $rawMaterialsOrderedRepository->save($rawMaterialsOrdered, true);

        // dd($order, $rawMaterial, $rawMaterialsOrdered);

        return $this->redirectToRoute('app_raw_materials_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_raw_materials_ordered_show', methods: ['GET'])]
    public function show(RawMaterialsOrdered $rawMaterialsOrdered): Response
    {
        return $this->render('raw_materials_ordered/show.html.twig', [
            'raw_materials_ordered' => $rawMaterialsOrdered,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_raw_materials_ordered_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RawMaterialsOrdered $rawMaterialsOrdered, RawMaterialsRepository $rawMaterialsRepository, RawMaterialsOrderedRepository $rawMaterialsOrderedRepository): Response
    {
        $order = $rawMaterialsOrdered->getOrders();
        $orderId = $order->getId();

        $rawMaterial = $rawMaterialsOrdered->getRawMaterial();
        $rawMaterialPrice = $rawMaterial->getPrice();

        // dd($rawMaterialPrice);

        $form = $this->createForm(RawMaterialsOrderedType::class, $rawMaterialsOrdered);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $qtty = $rawMaterialsOrdered->getQuantity();
            $rawMaterialsOrderedPrice = $qtty * $rawMaterialPrice;

            $rawMaterialsOrdered->setTotalPriceRawMaterial($rawMaterialsOrderedPrice);

            $rawMaterialsOrderedRepository->save($rawMaterialsOrdered, true);

            return $this->redirectToRoute('app_orders_show', ['id' => $orderId], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('raw_materials_ordered/edit.html.twig', [
            'raw_materials_ordered' => $rawMaterialsOrdered,
            'form' => $form,
            'orderId' => $orderId
        ]);
    }

    #[Route('/{id}', name: 'app_raw_materials_ordered_delete', methods: ['POST'])]
    public function delete(Request $request, RawMaterialsOrdered $rawMaterialsOrdered, RawMaterialsOrderedRepository $rawMaterialsOrderedRepository): Response
    {
        $order = $rawMaterialsOrdered->getOrders();
        $orderId = $order->getId();

        if ($this->isCsrfTokenValid('delete'.$rawMaterialsOrdered->getId(), $request->request->get('_token'))) {
            $rawMaterialsOrderedRepository->remove($rawMaterialsOrdered, true);
        }

        return $this->redirectToRoute('app_orders_show', ['id' => $orderId], Response::HTTP_SEE_OTHER);
    }
}
