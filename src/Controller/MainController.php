<?php

namespace App\Controller;

use App\Repository\RepairsRepository;
use App\Repository\WorksitesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(WorksitesRepository $worksitesRepository, RepairsRepository $repairsRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'worksites' => array_slice($worksitesRepository->findBy(array(), array('name_worksite' => 'ASC')), 0, 3),
            'repairs' => array_slice($repairsRepository->findBy(array(), array('name_repair' => 'ASC')), 0, 3),
        ]);
    }
}
