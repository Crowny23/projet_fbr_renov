<?php

namespace App\Form;

use App\Entity\Renter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class RenterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name_renter', TextType::class, ['label' => 'Nom Locatier'])
            ->add('city_renter', TextType::class, ['label' => 'Ville'])
            ->add('cp_renter', NumberType::class, ['label' => 'Code Postal'])
            ->add('adress_renter', TextType::class, ['label' => 'Adresse'])
            ->add('website_renter', TextType::class, ['label' => 'Site Internet'])
            ->add('email_renter', EmailType::class, ['label' => 'E-mail'])
            ->add('phone_renter', TelType::class, ['label' => 'Téléphone'])
            ->add('note_admin_renter', TextType::class, ['label' => 'Note'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Renter::class,
        ]);
    }
}
