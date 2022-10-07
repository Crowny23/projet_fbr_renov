<?php

namespace App\Form;

use App\Entity\Customers;
use App\Repository\UsersRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class CustomersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, ['label' => 'Prenom'])
            ->add('lastname', TextType::class, ['label' => 'Nom'])
            ->add('Town', TextType::class, ['label' => 'Ville'])
            ->add('postalcode', NumberType::class, ['label' => 'Code Postale'])
            ->add('address', TextType::class, ['label' => 'Addresse'])
            ->add('mail', EmailType::class, ['label' => 'E-mail'])
            ->add('phone', TelType::class, ['label' => 'Téléphone'])
            ->add('social_reason', TextType::class, ['label' => 'Raison Sociale'])
            ->add('customer_note', TextType::class, ['label' => 'Note'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Customers::class,
        ]);
    }
}
