<?php

namespace App\Form;

use App\Entity\Rentals;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;


class RentalsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity_rental', NumberType::class, ['label' => 'Quntité'] )
            ->add('unit_price', Moneytype::class, ['label' => 'Prix Unitaire'])
            ->add('renter_rentals')
            ->add('materials_rental')
            ->add('worksite_rental')
            ->add('repair_rental')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rentals::class,
        ]);
    }
}
