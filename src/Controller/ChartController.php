<?php

namespace App\Controller;

use App\Repository\CustomersRepository;
use App\Repository\RentalsRepository;
use App\Repository\WorksitesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ChartController extends AbstractController
{
    #[Route('/chart', name: 'app_chart')]
    public function index(ChartBuilderInterface $chartBuilder, WorksitesRepository $worksitesRepository, RentalsRepository $rentalsRepository, CustomersRepository $customersRepository): Response
    {
        $worksitesTot = $worksitesRepository->findAll();
        $worksitesCount = $worksitesRepository->findAll();
        $worksitesCount = count($worksitesCount);
        $worksites = $worksitesRepository->findByYears(date("Y"));
        $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $total = 0;
        $allYearTot = 0;
        foreach( $worksitesTot as $worksiteTot) {
            $allYearTot += $worksiteTot->getQuotationWorksite()->getFinalPaymentQuotation();
        }
        foreach( $worksites as $worksite) {
            // $test[] = ($worksite->getStartAt()->format('m')) - 1;
            $data[($worksite->getStartAt()->format('m')) - 1] += $worksite->getQuotationWorksite()->getFinalPaymentQuotation();
            $total += $worksite->getQuotationWorksite()->getFinalPaymentQuotation();
        }
        
        $rentalsCount = $rentalsRepository->findAll();
        $rentalsCount = count($rentalsCount);
        $rentals = $rentalsRepository->findByYears(date("Y"));
        $dataR = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $totalR = 0;
        foreach( $rentals as $rental) {
            $dataR[($rental->getCreatedAt()->format('m')) - 1] += $rental->getUnitPrice() * $rental->getQuantityRental();
            $totalR += $rental->getUnitPrice() * $rental->getQuantityRental(); 
        }

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
            'datasets' => [
                [
                    'label' => 'Coût Chantier',
                    'backgroundColor' => 'green',
                    'borderColor' => 'green',
                    'data' => $data,
                    // récuperer le montant total du devis.
                    'yAxisID'=> 'y',
                ],
            ],
        ]);

        // calcul de clients
        $customersTotal = $customersRepository->findAll();
        $customersTotal = count($customersTotal);

        $chartRentals = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chartRentals->setData([
            'labels' => ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
            'datasets' => [
                [
                    'label' => 'Coût Location',
                    'backgroundColor' => 'blue',
                    'borderColor' => 'blue',
                    'data' => $dataR,
                    'yAxisID'=> 'y',
                ],
            ],
        ]);

        return $this->render('chart/index.html.twig', [
            'chart' => $chart,
            'chartRentals' => $chartRentals,
            'total' => $total,
            'allYearTot' => $allYearTot,
            'totalR' => $totalR,
            'CustomersTotal' => $customersTotal,
            'worksitesCount' => $worksitesCount,
            'rentalsCount' => $rentalsCount,
        ]);
    }

}
