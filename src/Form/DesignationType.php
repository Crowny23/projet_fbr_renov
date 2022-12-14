<?php

namespace App\Form;

use App\Entity\Designation;
use App\Entity\Quotation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DesignationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('designation', TextareaType::class, ['label' => 'Désignation'])
            ->add('unity', TextType::class, ['label' => 'Unité'])
            ->add('quantity', IntegerType::class, ['label' => 'Quantité'])
            ->add('price_unitary_ht', MoneyType::class, ['label' => 'Prix unitaire HT(€)'])
            ->add('tva', IntegerType::class, ['label' => 'TVA(%)'])
            ->add('quotation', EntityType::class, ['label' => 'Devis', 'class' => Quotation::class])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Designation::class,
        ]);
    }
}
