<?php

namespace App\Form;

use App\Entity\Contacts;
use App\Entity\ContactsCategories;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Intitulé'])
            ->add('lastname', TextType::class, ['label' => 'Nom'])
            ->add('firstname', TextType::class, ['label' => 'Prénom'])
            ->add('city', TextType::class, ['label' => 'Ville'])
            ->add('mail', EmailType::class, ['label' => 'E-mail'])
            ->add('tel', TelType::class, ['label' => 'Téléphone'])
            ->add('contactsCategories', EntityType::class, ['class' => ContactsCategories::class, 'label' => 'Catégorie'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contacts::class,
        ]);
    }
}
