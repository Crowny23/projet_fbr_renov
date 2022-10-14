<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Form\OrdersType;
use App\Repository\OrdersRepository;
use App\Repository\RawMaterialsOrderedRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commandes')]
class OrdersController extends AbstractController
{
    #[Route('/', name: 'app_orders_index', methods: ['GET'])]
    public function index(OrdersRepository $ordersRepository): Response
    {
        return $this->render('orders/index.html.twig', [
            'orders' => $ordersRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_orders_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OrdersRepository $ordersRepository): Response
    {
        $order = new Orders();
        $form = $this->createForm(OrdersType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ordersRepository->save($order, true);

            return $this->redirectToRoute('app_orders_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('orders/new.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_orders_show', methods: ['GET'])]
    public function show(Orders $order, RawMaterialsOrderedRepository $rawMaterialsOrderedRepository): Response
    {
        // Get all rawMaterialsOrdered
        $raw_materials_ordered = $rawMaterialsOrderedRepository->findBy(['orders' => $order]);

        return $this->render('orders/show.html.twig', [
            'order' => $order,
            'raw_materials_ordered' => $raw_materials_ordered
        ]);
    }

    #[Route('/{id}/edit', name: 'app_orders_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Orders $order, OrdersRepository $ordersRepository): Response
    {
        $form = $this->createForm(OrdersType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date = new DateTimeImmutable();

            $order->setUpdatedAt($date);

            $ordersRepository->save($order, true);

            return $this->redirectToRoute('app_orders_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('orders/edit.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_orders_delete', methods: ['POST'])]
    public function delete(Request $request, Orders $order, OrdersRepository $ordersRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $ordersRepository->remove($order, true);
        }

        return $this->redirectToRoute('app_orders_index', [], Response::HTTP_SEE_OTHER);
    }
}
