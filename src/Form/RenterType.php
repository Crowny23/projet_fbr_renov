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
            ->add('name_renter', TextType::class, ['label' => 'Nom Locatier', 'label_attr' => ['class' => 'mb-2, mt-2']])
            ->add('city_renter', TextType::class, ['label' => 'Ville', 'label_attr' => ['class' => 'mb-2, mt-3']])
            ->add('cp_renter', NumberType::class, ['label' => 'Code Postal', 'label_attr' => ['class' => 'mb-2, mt-2']])
            ->add('adress_renter', TextType::class, ['label' => 'Adresse', 'label_attr' => ['class' => 'mb-2, mt-2']])
            ->add('website_renter', TextType::class, ['label' => 'Site Internet', 'label_attr' => ['class' => 'mb-2, mt-2']])
            ->add('email_renter', EmailType::class, ['label' => 'E-mail', 'label_attr' => ['class' => 'mb-2, mt-2']])
            ->add('phone_renter', TelType::class, ['label' => 'Téléphone', 'label_attr' => ['class' => 'mb-2, mt-2']])
            ->add('note_admin_renter', TextType::class, ['label' => 'Note', 'label_attr' => ['class' => 'mb-2, mt-2']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Renter::class,
        ]);
    }
}
