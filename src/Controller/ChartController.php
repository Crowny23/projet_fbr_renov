<?php

namespace App\Controller;

use App\Repository\QuotationRepository;
use App\Repository\WorksitesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ChartController extends AbstractController
{
    #[Route('/chart', name: 'app_chart')]
    public function index(ChartBuilderInterface $chartBuilder, WorksitesRepository $worksitesRepository, QuotationRepository $quotationRepository ): Response
    {
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
            'datasets' => [
                [
                    'label' => 'Chantier',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 10, 100, 1000, 10000, 100000, 1000000],
                    // récuperer le montant total du devis.
                    'yAxisID'=> 'y',
                ],
                [
                    'label' => 'Location',
                    'backgroundColor' => 'blue',
                    'borderColor' => 'blue',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
                    'yAxisID'=> 'y1',
                ],
            ],
        ]);
        
        return $this->render('chart/index.html.twig', [
            'chart' => $chart,
            'worksites' => array_slice($worksitesRepository->findAll(), 0, 5),
            'quotation' => array_slice($quotationRepository->findAll(), 0, 5),
        ]);
    }
}
