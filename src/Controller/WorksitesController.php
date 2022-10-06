<?php

namespace App\Controller;

use App\Entity\WorksiteCategories;
use App\Entity\Worksites;
use App\Form\WorksiteCategoriesType;
use App\Form\WorksitesType;
use App\Repository\WorksiteCategoriesRepository;
use App\Repository\WorksitesRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/chantiers')]
class WorksitesController extends AbstractController
{
    #[Route('/', name: 'app_worksites_index', methods: ['GET'])]
    public function index(WorksitesRepository $worksitesRepository): Response
    {
        return $this->render('worksites/index.html.twig', [
            'worksites' => $worksitesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_worksites_new', methods: ['GET', 'POST'])]
    public function newWorksite(Request $request, WorksitesRepository $worksitesRepository): Response
    {
        $worksite = new Worksites();
        $form = $this->createForm(WorksitesType::class, $worksite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $worksitesRepository->save($worksite, true);

            return $this->redirectToRoute('app_worksites_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('worksites/new.html.twig', [
            'worksite' => $worksite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_worksites_show', methods: ['GET'])]
    public function showWorksite(Worksites $worksite): Response
    {
        return $this->render('worksites/show.html.twig', [
            'worksite' => $worksite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_worksites_edit', methods: ['GET', 'POST'])]
    public function editWorksite(Request $request, Worksites $worksite, WorksitesRepository $worksitesRepository): Response
    {
        $form = $this->createForm(WorksitesType::class, $worksite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date = new \DateTimeImmutable();

            $worksite->setUpdatedAt($date);

            $worksitesRepository->save($worksite, true);

            return $this->redirectToRoute('app_worksites_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('worksites/edit.html.twig', [
            'worksite' => $worksite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_worksites_delete', methods: ['POST'])]
    public function deleteWorksite(Request $request, Worksites $worksite, WorksitesRepository $worksitesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$worksite->getId(), $request->request->get('_token'))) {
            $worksitesRepository->remove($worksite, true);
        }

        return $this->redirectToRoute('app_worksites_index', [], Response::HTTP_SEE_OTHER);
    }

    // Worksites Categories

    #[Route('-categories', name: 'app_worksite_categories_index', methods: ['GET'])]
    
    public function indexWorksiteCategories(WorksiteCategoriesRepository $worksiteCategoriesRepository): Response
    {
        return $this->render('worksite_categories/index.html.twig', [
            'worksite_categories' => $worksiteCategoriesRepository->findAll(),
        ]);
    }

    #[Route('-categories/new', name: 'app_worksite_categories_new', methods: ['GET', 'POST'])]
    public function newWorksiteCategories(Request $request, WorksiteCategoriesRepository $worksiteCategoriesRepository): Response
    {
        $worksiteCategory = new WorksiteCategories();
        $form = $this->createForm(WorksiteCategoriesType::class, $worksiteCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $worksiteCategoriesRepository->save($worksiteCategory, true);

            return $this->redirectToRoute('app_worksite_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('worksite_categories/new.html.twig', [
            'worksite_category' => $worksiteCategory,
            'form' => $form,
        ]);
    }

    #[Route('-categories/{id}', name: 'app_worksite_categories_show', methods: ['GET'])]
    public function showWorksiteCategories(WorksiteCategories $worksiteCategory): Response
    {
        return $this->render('worksite_categories/show.html.twig', [
            'worksite_category' => $worksiteCategory,
        ]);
    }

    #[Route('-categories/{id}/edit', name: 'app_worksite_categories_edit', methods: ['GET', 'POST'])]
    public function editWorksiteCategories(Request $request, WorksiteCategories $worksiteCategory, WorksiteCategoriesRepository $worksiteCategoriesRepository): Response
    {
        $form = $this->createForm(WorksiteCategoriesType::class, $worksiteCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date = new \DateTimeImmutable();

            $worksiteCategory->setUpdatedAt($date);

            $worksiteCategoriesRepository->save($worksiteCategory, true);

            return $this->redirectToRoute('app_worksite_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('worksite_categories/edit.html.twig', [
            'worksite_category' => $worksiteCategory,
            'form' => $form,
        ]);
    }

    #[Route('-categories/{id}', name: 'app_worksite_categories_delete', methods: ['POST'])]
    public function deleteWorksiteCategories(Request $request, WorksiteCategories $worksiteCategory, WorksiteCategoriesRepository $worksiteCategoriesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$worksiteCategory->getId(), $request->request->get('_token'))) {
            $worksiteCategoriesRepository->remove($worksiteCategory, true);
        }

        return $this->redirectToRoute('app_worksite_categories_index', [], Response::HTTP_SEE_OTHER);
    }
}
