<?php

namespace App\Controller\Admin;

use App\Entity\Rentals;
use App\Form\RentalsType;
use App\Repository\RentalsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/rentals')]
class RentalsController extends AbstractController
{
    #[Route('/', name: 'app_rentals_index', methods: ['GET'])]
    public function index(RentalsRepository $rentalsRepository): Response
    {
        return $this->render('rentals/index.html.twig', [
            'rentals' => $rentalsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_rentals_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RentalsRepository $rentalsRepository): Response
    {
        $rental = new Rentals();
        $form = $this->createForm(RentalsType::class, $rental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rentalsRepository->save($rental, true);

            return $this->redirectToRoute('app_rentals_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rentals/new.html.twig', [
            'rental' => $rental,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rentals_show', methods: ['GET'])]
    public function show(Rentals $rental): Response
    {
        return $this->render('rentals/show.html.twig', [
            'rental' => $rental,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_rentals_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Rentals $rental, RentalsRepository $rentalsRepository): Response
    {
        $form = $this->createForm(RentalsType::class, $rental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rentalsRepository->save($rental, true);

            return $this->redirectToRoute('app_rentals_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rentals/edit.html.twig', [
            'rental' => $rental,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rentals_delete', methods: ['POST'])]
    public function delete(Request $request, Rentals $rental, RentalsRepository $rentalsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rental->getId(), $request->request->get('_token'))) {
            $rentalsRepository->remove($rental, true);
        }

        return $this->redirectToRoute('app_rentals_index', [], Response::HTTP_SEE_OTHER);
    }
}
