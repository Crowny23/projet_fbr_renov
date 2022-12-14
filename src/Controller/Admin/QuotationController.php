<?php

namespace App\Controller\Admin;

use App\Entity\Quotation;
use App\Form\QuotationType;
use App\Repository\DesignationRepository;
use App\Repository\QuotationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/devis')]
class QuotationController extends AbstractController
{
    #[Route('/', name: 'app_quotation_index', methods: ['GET'])]
    public function index(QuotationRepository $quotationRepository): Response
    {
        return $this->render('quotation/index.html.twig', [
            'quotations' => $quotationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_quotation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, QuotationRepository $quotationRepository): Response
    {
        $quotation = new Quotation();
        $form = $this->createForm(QuotationType::class, $quotation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quotationRepository->save($quotation, true);

            return $this->redirectToRoute('app_quotation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('quotation/new.html.twig', [
            'quotation' => $quotation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_quotation_show', methods: ['GET'])]
    public function show(Quotation $quotation, DesignationRepository $designationRepository): Response
    {
        return $this->render('quotation/show.html.twig', [
            'quotation' => $quotation,
            'designations' => $designationRepository->findByIdQuotation($quotation->getId())
        ]);
    }

    #[Route('/{id}/edit', name: 'app_quotation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Quotation $quotation, QuotationRepository $quotationRepository): Response
    {
        $form = $this->createForm(QuotationType::class, $quotation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quotationRepository->save($quotation, true);

            return $this->redirectToRoute('app_quotation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('quotation/edit.html.twig', [
            'quotation' => $quotation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_quotation_delete', methods: ['POST'])]
    public function delete(Request $request, Quotation $quotation, QuotationRepository $quotationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quotation->getId(), $request->request->get('_token'))) {
            $quotationRepository->remove($quotation, true);
        }

        return $this->redirectToRoute('app_quotation_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/secdepot', name: 'app_quotation_secdepot_add', methods: ['POST'])]
    public function secdepot(Request $request, Quotation $quotation, QuotationRepository $quotationRepository): Response
    {
    
        $quotation->setSecondDeposit($request->request->get('second_deposit'));
    
        $quotationRepository->save($quotation, true);
    
        return $this->redirectToRoute('app_quotation_show', ['id' => $quotation->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/discount', name: 'app_quotation_discount_add', methods: ['POST'])]
    public function discount(Request $request, Quotation $quotation, QuotationRepository $quotationRepository): Response
    {
    
        $quotation->setDiscount($request->request->get('discount'));
    
        $quotationRepository->save($quotation, true);
    
        return $this->redirectToRoute('app_quotation_show', ['id' => $quotation->getId()], Response::HTTP_SEE_OTHER);
    }
}
