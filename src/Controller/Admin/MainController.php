<?php

namespace App\Controller\Admin;

use App\Repository\RepairsRepository;
use App\Repository\WorksitesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/admin', name: 'app_main')]
    public function index(WorksitesRepository $worksitesRepository, RepairsRepository $repairsRepository): Response
    {
        $worksitesByStatus = $worksitesRepository->findBy(['status_worksite' => 'En cours'], null, 5);
        // dd($worksitesByStatus);
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'worksites' => $worksitesByStatus,
            'repairs' => array_slice($repairsRepository->findBy(array(), array('name_repair' => 'DESC')), 0, 3),
        ]);
    }
}
