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
        if (sizeof($quotation->getDesignations()) > 7 && sizeof($quotation->getDesignations()) < 10) {
            $page_break = true;
        }else {
            $page_break = false;
        }
        $data = [
            'logo' => $this->imageToBase64($this->getParameter('kernel.project_dir') . '/public/img/logo-bg-white.png'),
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
            'cp' => $quotation->getWorksite()->getClientWorksite()->getPostalcode(),
            'object' => $quotation->getObject(),
            'designations' => $quotation->getDesignations(),
            'page_break' => $page_break
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

    private function imageToBase64($path) {
        $path = $path;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }
}
