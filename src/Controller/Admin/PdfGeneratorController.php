<?php

namespace App\Controller\Admin;

use App\Entity\Quotation;
use App\Entity\Orders;
use App\Repository\RawMaterialsOrderedRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;

class PdfGeneratorController extends AbstractController
{
    #[Route('/admin/pdf/facture/{id}', name: 'app_pdf_generator_facture', methods: 'GET')]
    public function facture(Quotation $quotation): Response
    {
        if (sizeof($quotation->getDesignations()) > 3 && sizeof($quotation->getDesignations()) < 7 || sizeof($quotation->getDesignations()) > 10 && sizeof($quotation->getDesignations()) < 13) {
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
            'secondDeposit' => $quotation->getSecondDeposit(),
            'discount' => $quotation->getDiscount(),
            'designations' => $quotation->getDesignations(),
            'page_break' => $page_break
        ];
        $html = $this->renderView('pdf_generator/index.html.twig', $data);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $dompdf->getCanvas()->page_text(575, 775, "{PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0,0,0));

        return new Response(
            $dompdf->stream('facture '.$quotation->getReferenceQuotation() , ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }

    #[Route('/pdf/devis/{id}', name: 'app_pdf_generator_quotation', methods: 'GET')]
    public function quotation(Quotation $quotation): Response
    {
        if (sizeof($quotation->getDesignations()) > 3 && sizeof($quotation->getDesignations()) < 7 || sizeof($quotation->getDesignations()) > 10 && sizeof($quotation->getDesignations()) < 13) {
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
        $html = $this->renderView('pdf_generator/quotation.html.twig', $data);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $dompdf->getCanvas()->page_text(575, 775, "{PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0,0,0));

        return new Response(
            $dompdf->stream('devis '.$quotation->getReferenceQuotation() , ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }

    #[Route('/pdf/order/{id}', name: 'app_pdf_generator_order', methods: 'GET')]
    public function order(Orders $order, RawMaterialsOrderedRepository $rawMaterialsOrderedRepository): Response
    {
        // dd($rawMaterialsOrderedRepository->findBy(['orders' => $order]));
        // if (sizeof($quotation->getDesignations()) > 7 && sizeof($quotation->getDesignations()) < 10 || sizeof($quotation->getDesignations()) > 21 && sizeof($quotation->getDesignations()) < 24) {
        //     $page_break = true;
        // }else {
        //     $page_break = false;
        // }
        $data = [
            'logo' => $this->imageToBase64($this->getParameter('kernel.project_dir') . '/public/img/logo-bg-white.png'),
            'reference' => $order->getReference(),
            'worksite' => $order->getWorksite(),
            'supplier' => $order->getSupplier(),
            'rawMaterialsOrdered' => $rawMaterialsOrderedRepository->findBy(['orders' => $order])
            // 'page_break' => $page_break
        ];

        $html = $this->renderView('pdf_generator/orders.html.twig', $data);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $dompdf->getCanvas()->page_text(575, 775, "{PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0,0,0));

        return new Response(
            $dompdf->stream('order'. $order->getReference() , ["Attachment" => false]),
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
