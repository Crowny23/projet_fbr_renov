<?php

namespace App\Form;

use App\Entity\Rentals;
use App\Entity\Renter;
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
            ->add('quantity_rental', NumberType::class, ['label' => 'Quntité', 'label_attr' => ['class' => 'mb-1, mt-2']] )
            ->add('unit_price', Moneytype::class, ['label' => 'Prix Unitaire', 'label_attr' => ['class' => 'mb-1, mt-2']])
            ->add('renter_rentals', EntityType:: class, ['class'=> Renter::class, 'label' => 'Locatier Location', 'label_attr' => ['class' => 'mb-1, mt-2']])
            ->add('materials_rental', EntityType::class, [
                'class' => Materials::class, 'label' => 'Matériel', 'label_attr' => ['class' => 'mb-1, mt-2']
            ])
            ->add('worksite_rental', EntityType::class, [
                'class' => Worksites::class, 'label' => 'Chantier', 'label_attr' => ['class' => 'mb-1, mt-2']
            ])
            ->add('repair_rental', EntityType::class, [
                'class' => Repairs::class, 'label' => 'Dépannage', 'label_attr' => ['class' => 'mb-1, mt-2']
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
