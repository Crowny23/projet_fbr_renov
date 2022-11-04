<?php

namespace App\Controller\Admin;

use App\Entity\Renter;
use App\Form\RenterType;
use App\Repository\RenterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/renter')]
class RenterController extends AbstractController
{
    #[Route('/', name: 'app_renter_index', methods: ['GET'])]
    public function index(RenterRepository $renterRepository): Response
    {
        return $this->render('renter/index.html.twig', [
            'renters' => $renterRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_renter_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RenterRepository $renterRepository): Response
    {
        $renter = new Renter();
        $form = $this->createForm(RenterType::class, $renter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $renterRepository->save($renter, true);

            return $this->redirectToRoute('app_renter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('renter/new.html.twig', [
            'renter' => $renter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_renter_show', methods: ['GET'])]
    public function show(Renter $renter): Response
    {
        return $this->render('renter/show.html.twig', [
            'renter' => $renter,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_renter_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Renter $renter, RenterRepository $renterRepository): Response
    {
        $form = $this->createForm(RenterType::class, $renter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $renterRepository->save($renter, true);

            return $this->redirectToRoute('app_renter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('renter/edit.html.twig', [
            'renter' => $renter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_renter_delete', methods: ['POST'])]
    public function delete(Request $request, Renter $renter, RenterRepository $renterRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$renter->getId(), $request->request->get('_token'))) {
            $renterRepository->remove($renter, true);
        }

        return $this->redirectToRoute('app_renter_index', [], Response::HTTP_SEE_OTHER);
    }
}
