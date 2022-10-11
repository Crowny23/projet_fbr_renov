<?php

namespace App\Controller;

use App\Entity\Designation;
use App\Form\DesignationType;
use App\Repository\DesignationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/designation')]
class DesignationController extends AbstractController
{
    #[Route('/', name: 'app_designation_index', methods: ['GET'])]
    public function index(DesignationRepository $designationRepository): Response
    {
        return $this->render('designation/index.html.twig', [
            'designations' => $designationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_designation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DesignationRepository $designationRepository): Response
    {
        $designation = new Designation();
        $form = $this->createForm(DesignationType::class, $designation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $designation->setPriceHt($request->get('designation')['quantity'], $request->get('designation')['price_unitary_ht']);
            $designationRepository->save($designation, true);

            return $this->redirectToRoute('app_quotation_show', ['id' => $request->get('designation')['quotation']], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('designation/new.html.twig', [
            'designation' => $designation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_designation_show', methods: ['GET'])]
    public function show(Designation $designation): Response
    {
        return $this->render('designation/show.html.twig', [
            'designation' => $designation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_designation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Designation $designation, DesignationRepository $designationRepository): Response
    {
        $form = $this->createForm(DesignationType::class, $designation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $designationRepository->save($designation, true);

            return $this->redirectToRoute('app_designation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('designation/edit.html.twig', [
            'designation' => $designation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_designation_delete', methods: ['POST'])]
    public function delete(Request $request, Designation $designation, DesignationRepository $designationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$designation->getId(), $request->request->get('_token'))) {
            $designationRepository->remove($designation, true);
        }

        return $this->redirectToRoute('app_quotation_index', [], Response::HTTP_SEE_OTHER);
    }
}
