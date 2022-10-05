<?php

namespace App\Form;

use App\Entity\Rentals;
use App\Entity\Materials;
use App\Entity\Repairs;
use App\Entity\Worksites;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RentalsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity_rental', NumberType::class, ['label' => 'Quntité'] )
            ->add('unit_price', Moneytype::class, ['label' => 'Prix Unitaire'])
            ->add('renter_rentals')
            ->add('materials_rental', EntityType::class, [
                'class' => Materials::class, 'label' => 'Matériel'
            ])
            ->add('worksite_rental', EntityType::class, [
                'class' => Worksites::class, 'label' => 'Chantier'
            ])
            ->add('repair_rental', EntityType::class, [
                'class' => Repairs::class, 'label' => 'Dépannage'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rentals::class,
        ]);
    }
}
