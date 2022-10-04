<?php

namespace App\Form;

use App\Entity\Repairs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RepairsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name_repair')
            ->add('city_repair')
            ->add('cp_repair')
            ->add('adress_repair')
            ->add('price_repair')
            ->add('reference_repair')
            ->add('schedule_repair')
            ->add('travel_distance_repair')
            ->add('note_admin_repair')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Repairs::class,
        ]);
    }
}
