<?php

namespace App\Controller\Admin;

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
    #[Route('/admin/statistiques', name: 'app_chart')]
    public function index(ChartBuilderInterface $chartBuilder, WorksitesRepository $worksitesRepository, RentalsRepository $rentalsRepository, CustomersRepository $customersRepository): Response
    {   
        // Worksites stats
        // Get all worksites
        $allWorksites = $worksitesRepository->findAll();
        // Count worksites
        $worksitesCount = count($allWorksites);
        // Get worksites by year
        $worksitesByYears = $worksitesRepository->findByYears(date("Y"));
        // Initialize data
        $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $total = 0;
        $allYearTot = 0;

        // Calcul total earnings for the year
        foreach( $allWorksites as $worksite) {
            if($worksite->getQuotationWorksite() !== null) {
                $allYearTot += $worksite->getQuotationWorksite()->getFinalPaymentQuotation();
            }
        }
        // Calcul total earnings all time
        foreach( $worksitesByYears as $worksite) {
            if($worksite->getQuotationWorksite() !== null) {
                $data[($worksite->getStartAt()->format('m')) - 1] += $worksite->getQuotationWorksite()->getFinalPaymentQuotation();
                $total += $worksite->getQuotationWorksite()->getFinalPaymentQuotation();
            }
        }
        // Rentals stats
        // Get all rentals
        $allRentals = $rentalsRepository->findAll();
        // Count rentals
        $rentalsCount = count($allRentals);
        // Get rentals by years
        $rentals = $rentalsRepository->findByYears(date("Y"));
        // initialize data
        $dataR = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $totalR = 0;

        // Calcul rentals cost for the year and number of rentals all time
        if($allRentals !== null) {
            foreach( $rentals as $rental) {
                $dataR[($rental->getCreatedAt()->format('m')) - 1] += $rental->getUnitPrice() * $rental->getQuantityRental();
                $totalR += $rental->getUnitPrice() * $rental->getQuantityRental(); 
            }
        }
        // Create chart worksites
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
            'datasets' => [
                [
                    'label' => 'Chiffre d\'affaire de l\'année en cours par mois',
                    'backgroundColor' => 'green',
                    'borderColor' => 'green',
                    'data' => $data,
                    // récuperer le montant total du devis.
                    'yAxisID'=> 'y',
                ],
            ],
        ]);
        
        // Create chart rentals
        $chartRentals = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chartRentals->setData([
            'labels' => ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
            'datasets' => [
                [
                    'label' => 'Coût total des locations de l\année en cours par mois',
                    'backgroundColor' => 'blue',
                    'borderColor' => 'blue',
                    'data' => $dataR,
                    'yAxisID'=> 'y',
                ],
            ],
        ]);

        // Calcul number of clients all time
        $allCustomers = $customersRepository->findAll();
        if($allCustomers !== null) {
            $customersTotal = count($allCustomers);
        } else {
            $customersTotal = 0;
        }

        // Render
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
