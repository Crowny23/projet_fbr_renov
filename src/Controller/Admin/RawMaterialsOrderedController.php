<?php

namespace App\Controller\Admin;

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

#[Route('/admin/materiaux-commande')]
class RawMaterialsOrderedController extends AbstractController
{
    #[Route('/', name: 'app_raw_materials_ordered_index', methods: ['GET'])]
    public function index(RawMaterialsOrderedRepository $rawMaterialsOrderedRepository, OrdersRepository $ordersRepository): Response
    {
        return $this->render('raw_materials_ordered/index.html.twig', [
            'raw_materials_ordereds' => $rawMaterialsOrderedRepository->findAll(),
        ]);
    }

    #[Route('/new/{idOrder}/{idRawMaterial}/{qtty}', name: 'app_raw_materials_ordered_new', methods: ['GET', 'POST'])]
    public function new($idOrder, $idRawMaterial, $qtty, RawMaterialsOrderedRepository $rawMaterialsOrderedRepository, OrdersRepository $ordersRepository, RawMaterialsRepository $rawMaterialsRepository): Response
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

        // Count rawMaterilasOrdered for current order
        $count = count($rawMaterialsOrderedRepository->findBy(['orders' => $order]));
        $order->setNumberRawMaterialOrdered($count);
        
        $ordersRepository->save($order, true);

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
        // Get Order & Order id
        $order = $rawMaterialsOrdered->getOrders();
        $orderId = $order->getId();

        // Get rawMaterialsOrdered & rawMaterialOrdered price
        $rawMaterial = $rawMaterialsOrdered->getRawMaterial();
        $rawMaterialPrice = $rawMaterial->getPrice();

        $form = $this->createForm(RawMaterialsOrderedType::class, $rawMaterialsOrdered);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Get new quantity
            $qtty = $rawMaterialsOrdered->getQuantity();

            // Get old rawMaterialOrdered total price
            $oldRawMaterialOrderedPrice = $rawMaterialsOrdered->getTotalPriceRawMaterial();

            // Calculate & Set rawMaterialsOrdered new price
            $newRawMaterialsOrderedPrice = $qtty * $rawMaterialPrice;
            $rawMaterialsOrdered->setTotalPriceRawMaterial($newRawMaterialsOrderedPrice);

            // Get old Order total price
            $oldOrderPrice = $order->getTotalPrice();

            // Calculate & Set new Orders total price
            $newOrderTotalPrice = $oldOrderPrice + ($newRawMaterialsOrderedPrice - $oldRawMaterialOrderedPrice);
            $order->setTotalPrice($newOrderTotalPrice);

            // Update in DB
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
    public function delete(Request $request,OrdersRepository $ordersRepository, RawMaterialsOrdered $rawMaterialsOrdered, RawMaterialsOrderedRepository $rawMaterialsOrderedRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rawMaterialsOrdered->getId(), $request->request->get('_token'))) {
            // Get order & orderId
            $order = $rawMaterialsOrdered->getOrders();
            $orderId = $order->getId();

            // Get rawMaterialsOrdered & Order price
            $rawMaterialsOrderedPrice = $rawMaterialsOrdered->getTotalPriceRawMaterial();
            $orderPrice = $order->getTotalPrice();
            
            // Set Order new price
            $newPrice = $orderPrice - $rawMaterialsOrderedPrice;
            $order->setTotalPrice($newPrice);

            // Update in DB (Order price & rawMaterialsOrdered delete)
            $ordersRepository->save($order, true);
            $rawMaterialsOrderedRepository->remove($rawMaterialsOrdered, true);

            // Count rawMaterilasOrdered for current order
            $count = count($rawMaterialsOrderedRepository->findBy(['orders' => $order]));
            $order->setNumberRawMaterialOrdered($count);
            
            $ordersRepository->save($order, true);
        }

        return $this->redirectToRoute('app_orders_show', ['id' => $orderId], Response::HTTP_SEE_OTHER);
    }

    #[Route('/multiple/{orderId}', name: 'app_raw_materials_ordered_delete_multiple', methods: ['POST'])]
    public function deleteMultiple($orderId, RawMaterialsOrderedRepository $rawMaterialsOrderedRepository, Request $request, OrdersRepository $ordersRepository): Response
    {
        // dd($orderId);
        $order = $ordersRepository->find($orderId);

        if(isset($_POST['submit']) && isset($_POST['checkbox-delete'])){
            $checkboxes = $_POST['checkbox-delete'];

            foreach ($checkboxes as $rawMaterialOrderedId) {
                // Get rawMaterialsOrdered
                $rawMaterialsOrdered = $rawMaterialsOrderedRepository->find($rawMaterialOrderedId);

                // Get rawMaterialsOrdered & Order price
                $rawMaterialsOrderedPrice = $rawMaterialsOrdered->getTotalPriceRawMaterial();
                $orderPrice = $order->getTotalPrice();
                
                // Set Order new price
                $newPrice = $orderPrice - $rawMaterialsOrderedPrice;
                $order->setTotalPrice($newPrice);

                // Update in DB (Order price & rawMaterialsOrdered delete)
                $ordersRepository->save($order, true);
                $rawMaterialsOrderedRepository->remove($rawMaterialsOrdered, true);

                // Count rawMaterilasOrdered for current order
                $count = count($rawMaterialsOrderedRepository->findBy(['orders' => $order]));
                $order->setNumberRawMaterialOrdered($count);
                
                $ordersRepository->save($order, true);
            }
        }

        return $this->redirectToRoute('app_orders_show', ['id' => $orderId], Response::HTTP_SEE_OTHER);
    }

    #[Route('/ajax/plus/{id}', name: 'app_raw_materials_ordered_plus', methods: ['GET'])]
    public function plus($id, RawMaterialsOrderedRepository $rawMaterialsOrderedRepository): Response
    {
        // Get rawMaterialOrdered
        $rawMaterialOrdered = $rawMaterialsOrderedRepository->find($id);
        // Set new quantity
        $qtty = $rawMaterialOrdered->getQuantity();
        $qtty ++;
        $rawMaterialOrdered->setQuantity($qtty);
        // Get rawMaterial unit price
        $rawMaterial = $rawMaterialOrdered->getRawMaterial();
        $rawMaterialPrice = $rawMaterial->getPrice();
        // Get rawMaterialOrdered price
        $rawMaterialsOrderedPrice = $rawMaterialOrdered->getTotalPriceRawMaterial();
        // Get order price
        $order = $rawMaterialOrdered->getOrders();
        $orderPrice = $order->getTotalPrice();
        // Set new price for order and rawMaterialOrdered
        $orderNewPrice = $orderPrice + $rawMaterialPrice;
        $order->setTotalPrice($orderNewPrice);
        $rawMaterialsOrderedNewPrice = $rawMaterialsOrderedPrice + $rawMaterialPrice;
        $rawMaterialOrdered->setTotalPriceRawMaterial($rawMaterialsOrderedNewPrice);

        $rawMaterialsOrderedRepository->save($rawMaterialOrdered, true);

        // $orderId = $order->getId();

        $datas = [$qtty, $orderNewPrice, $rawMaterialsOrderedNewPrice];

        $datasJson = json_encode($datas);

        // dd($datasJson);

        // return $this->redirectToRoute('app_orders_show', ['id' => $orderId], Response::HTTP_SEE_OTHER);
        return $this->render('raw_materials_ordered/plus.html.twig', [
            'datas' => $datasJson
        ]);
    }

    #[Route('/ajax/minus/{id}', name: 'app_raw_materials_ordered_minus', methods: ['GET'])]
    public function minus($id, RawMaterialsOrderedRepository $rawMaterialsOrderedRepository): Response
    {
        // Get rawMaterialOrdered
        $rawMaterialOrdered = $rawMaterialsOrderedRepository->find($id);
        // Set new quantity
        $qtty = $rawMaterialOrdered->getQuantity();
        $qtty --;
        $rawMaterialOrdered->setQuantity($qtty);
        // Get rawMaterial unit price
        $rawMaterial = $rawMaterialOrdered->getRawMaterial();
        $rawMaterialPrice = $rawMaterial->getPrice();
        // Get rawMaterialOrdered price
        $rawMaterialsOrderedPrice = $rawMaterialOrdered->getTotalPriceRawMaterial();
        // Get order price
        $order = $rawMaterialOrdered->getOrders();
        $orderPrice = $order->getTotalPrice();
        // Set new price for order and rawMaterialOrdered
        $orderNewPrice = $orderPrice - $rawMaterialPrice;
        $order->setTotalPrice($orderNewPrice);
        $rawMaterialsOrderedNewPrice = $rawMaterialsOrderedPrice - $rawMaterialPrice;
        $rawMaterialOrdered->setTotalPriceRawMaterial($rawMaterialsOrderedNewPrice);

        $rawMaterialsOrderedRepository->save($rawMaterialOrdered, true);

        // $orderId = $rawMaterialOrdered->getOrders()->getId();

        $datas = [$qtty, $orderNewPrice, $rawMaterialsOrderedNewPrice];

        $datasJson = json_encode($datas);

        // return $this->redirectToRoute('app_orders_show', ['id' => $orderId], Response::HTTP_SEE_OTHER);
        return $this->render('raw_materials_ordered/plus.html.twig', [
            'datas' => $datasJson
        ]);
    }

    #[Route('/ajax/{id}/edit-quantity/{inputQtty}', name: 'app_raw_materials_ordered_quick_edit', methods: ['GET', 'POST'])]
    public function quickEditQuantity($inputQtty = 0, RawMaterialsOrdered $rawMaterialsOrdered, RawMaterialsOrderedRepository $rawMaterialsOrderedRepository): Response
    {
        // Get order id
        $order = $rawMaterialsOrdered->getOrders();
        // $orderId = $order->getId();
        // Get rawMaterialOrdered quantity
        $qtty = $rawMaterialsOrdered->getQuantity();
        $inputQtty = intval($inputQtty);

        // Check if quantity change
        if($qtty === $inputQtty) {
            // Get order total price
            $orderPrice = $order->getTotalPrice();
            // Get rawMaterialsOrdered price
            $rawMaterialsOrderedPrice = $rawMaterialsOrdered->getTotalPriceRawMaterial();

            $datas = [$qtty, $orderPrice, $rawMaterialsOrderedPrice];

            $datasJson = json_encode($datas);

            // return $this->redirectToRoute('app_orders_show', ['id' => $orderId], Response::HTTP_SEE_OTHER);
            return $this->render('raw_materials_ordered/quick-edit.html.twig', [
                'datas' => $datasJson
            ]);
        } else {
            // Get order total price
            $orderPrice = $order->getTotalPrice();
            // Get rawMaterialsOrdered old price
            $rawMaterialsOrderedOldPrice = $rawMaterialsOrdered->getTotalPriceRawMaterial();
            // Get rawMaterial price
            $rawMaterial = $rawMaterialsOrdered->getRawMaterial();
            $rawMaterialPrice = $rawMaterial->getPrice();
            // Set new rawMaterialsOrdered quantity
            $rawMaterialsOrdered->setQuantity($inputQtty);
            // Set new rawMaterialsOrdered price
            $rawMaterialsOrderedNewPrice = $inputQtty * $rawMaterialPrice;
            $rawMaterialsOrdered->setTotalPriceRawMaterial($rawMaterialsOrderedNewPrice);
            // Calculate order new price
            $orderNewPrice = ($orderPrice - $rawMaterialsOrderedOldPrice) + $rawMaterialsOrderedNewPrice;
            $order->setTotalPrice($orderNewPrice);

            $rawMaterialsOrderedRepository->save($rawMaterialsOrdered, true);

            $datas = [$inputQtty, $orderNewPrice, $rawMaterialsOrderedNewPrice];

            $datasJson = json_encode($datas);

            // return $this->redirectToRoute('app_orders_show', ['id' => $orderId], Response::HTTP_SEE_OTHER);
            return $this->render('raw_materials_ordered/quick-edit.html.twig', [
                'datas' => $datasJson
            ]);
        }
    }
}
