<?php

namespace App\Controller;

use App\Entity\Quotation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;

class PdfGeneratorController extends AbstractController
{
    #[Route('/pdf/generator/{id}', name: 'app_pdf_generator', methods: 'GET')]
    public function index(Quotation $quotation): Response
    {
        $data = [
            'reference' => $quotation->getReferenceQuotation(),
            'price' => $quotation->getPriceQuotation(),
            'status' => $quotation->getStatusQuotation(),
            'deposit' => $quotation->getDepositQuotation(),
            'interPayment' => $quotation->getIntermediatePaymentQuotation(),
            'finalPayment' => $quotation->getFinalPaymentQuotation(),
            'worksite' => $quotation->getWorksite(),
            'firstname' => $quotation->getWorksite()->getClientWorksite()->getFirstname(),
            'lastname' => $quotation->getWorksite()->getClientWorksite()->getLastname(),
            'address' => $quotation->getWorksite()->getClientWorksite()->getAddress(),
            'city' => $quotation->getWorksite()->getClientWorksite()->getTown(),
            'cp' => $quotation->getWorksite()->getClientWorksite()->getPostalcode()
        ];
        $html = $this->renderView('pdf_generator/index.html.twig', $data);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();

        return new Response(
            $dompdf->stream('devis'.$quotation->getReferenceQuotation() , ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }
}
