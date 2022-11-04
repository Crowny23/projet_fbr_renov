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
            ->add('firstname', TextType::class, ['label' => 'Prénom', 'label_attr' => ['class' => 'mb-1, mt-2']])
            ->add('lastname', TextType::class, ['label' => 'Nom', 'label_attr' => ['class' => 'mb-1, mt-2']])
            ->add('Town', TextType::class, ['label' => 'Ville', 'label_attr' => ['class' => 'mb-1, mt-2']])
            ->add('postalcode', NumberType::class, ['label' => 'Code Postal', 'label_attr' => ['class' => 'mb-1, mt-2']])
            ->add('address', TextType::class, ['label' => 'Adresse', 'label_attr' => ['class' => 'mb-1, mt-2']])
            ->add('mail', EmailType::class, ['label' => 'E-mail', 'label_attr' => ['class' => 'mb-1, mt-2']])
            ->add('phone', TelType::class, ['label' => 'Téléphone', 'label_attr' => ['class' => 'mb-1, mt-2']])
            ->add('social_reason', TextType::class, ['label' => 'Raison Sociale', 'label_attr' => ['class' => 'mb-1, mt-2']])
            // ->add('customer_note', TextType::class, ['label' => 'Note', 'label_attr' => ['class' => 'mb-1, mt-2']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Customers::class,
        ]);
    }
}
