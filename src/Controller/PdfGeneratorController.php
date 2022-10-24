<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Repository\RawMaterialsOrderedRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;

class PdfGeneratorController extends AbstractController
{
    #[Route('/pdf-generator/order/{id}', name: 'app_pdf_generator_order', methods: 'GET')]
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
