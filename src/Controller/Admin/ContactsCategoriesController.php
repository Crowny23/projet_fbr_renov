<?php

namespace App\Controller\Admin;

use App\Entity\ContactsCategories;
use App\Form\ContactsCategoriesType;
use App\Repository\ContactsCategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/contacts/categories')]
class ContactsCategoriesController extends AbstractController
{
    #[Route('/', name: 'app_contacts_categories_index', methods: ['GET'])]
    public function index(ContactsCategoriesRepository $contactsCategoriesRepository): Response
    {
        return $this->render('contacts_categories/index.html.twig', [
            'contacts_categories' => $contactsCategoriesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_contacts_categories_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ContactsCategoriesRepository $contactsCategoriesRepository): Response
    {
        $contactsCategory = new ContactsCategories();
        $form = $this->createForm(ContactsCategoriesType::class, $contactsCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactsCategoriesRepository->save($contactsCategory, true);

            return $this->redirectToRoute('app_contacts_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contacts_categories/new.html.twig', [
            'contacts_category' => $contactsCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contacts_categories_show', methods: ['GET'])]
    public function show(ContactsCategories $contactsCategory): Response
    {
        return $this->render('contacts_categories/show.html.twig', [
            'contacts_category' => $contactsCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contacts_categories_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ContactsCategories $contactsCategory, ContactsCategoriesRepository $contactsCategoriesRepository): Response
    {
        $form = $this->createForm(ContactsCategoriesType::class, $contactsCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactsCategoriesRepository->save($contactsCategory, true);

            return $this->redirectToRoute('app_contacts_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contacts_categories/edit.html.twig', [
            'contacts_category' => $contactsCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contacts_categories_delete', methods: ['POST'])]
    public function delete(Request $request, ContactsCategories $contactsCategory, ContactsCategoriesRepository $contactsCategoriesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contactsCategory->getId(), $request->request->get('_token'))) {
            $contactsCategoriesRepository->remove($contactsCategory, true);
        }

        return $this->redirectToRoute('app_contacts_categories_index', [], Response::HTTP_SEE_OTHER);
    }
}
