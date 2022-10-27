<?php

namespace App\Form;

use App\Entity\Supplier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupplierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name_supplier', TextType::class, ['label' => 'Nom du fournisseur'])
            ->add('email', TextType::class, ['label' => 'Email'])
            ->add('phone', IntegerType::class, ['label' => 'Numéro de téléphone'])
            ->add('city', TextType::class, ['label' => 'Ville'])
            ->add('cp', IntegerType::class, ['label' => 'Code postal'])
            ->add('adress', TextType::class, ['label' => 'Adresse'])
            ->add('submit', SubmitType::class, ['label' => 'Valider'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Supplier::class,
        ]);
    }
}