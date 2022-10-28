<?php

namespace App\Controller\Admin;

use App\Entity\Customers;
use App\Entity\Users;
use App\Form\CustomersType;
use App\Repository\CustomersRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/clients')]
class CustomersController extends AbstractController
{
    #[Route('/', name: 'app_customers_index', methods: ['GET'])]
    public function index(CustomersRepository $customersRepository): Response
    {
        return $this->render('customers/index.html.twig', [
            'customers' => $customersRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_customers_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CustomersRepository $customersRepository, UsersRepository $usersRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $customer = new Customers();
        $user = new Users();

        $form = $this->createForm(CustomersType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $random = random_bytes(10);
            $plainPassword = bin2hex($random);
            $user->setEmail($customer->getMail());
            $user->addCustomer($customer);
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $plainPassword
                )
            );
            dd(bin2hex($random));
            $customersRepository->save($customer, true);

            return $this->redirectToRoute('app_customers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('customers/new.html.twig', [
            'customer' => $customer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_customers_show', methods: ['GET'])]
    public function show(Customers $customer): Response
    {
        return $this->render('customers/show.html.twig', [
            'customer' => $customer,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_customers_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Customers $customer, CustomersRepository $customersRepository): Response
    {
        $form = $this->createForm(CustomersType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $customersRepository->save($customer, true);

            return $this->redirectToRoute('app_customers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('customers/edit.html.twig', [
            'customer' => $customer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_customers_delete', methods: ['POST'])]
    public function delete(Request $request, Customers $customer, CustomersRepository $customersRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$customer->getId(), $request->request->get('_token'))) {
            $customersRepository->remove($customer, true);
        }

        return $this->redirectToRoute('app_customers_index', [], Response::HTTP_SEE_OTHER);
    }
}
