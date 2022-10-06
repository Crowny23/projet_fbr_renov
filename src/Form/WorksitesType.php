<?php

namespace App\Form;

use App\Entity\Customers;
use App\Entity\Quotation;
use App\Entity\WorksiteCategories;
use App\Entity\Worksites;
use Doctrine\DBAL\Types\DateTimeImmutableType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorksitesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name_worksite', TextType::class, ['label' => 'Nom du chantier'])
            ->add('city_worksite', TextType::class, ['label' => 'Ville'])
            ->add('cp_worksite', IntegerType::class, ['label' => 'Code Postal'])
            ->add('adress_worksite', TextType::class, ['label' => 'Adresse'])
            ->add('client_worksite', EntityType::class, ['label' => 'Client', 'class' => Customers::class])
            ->add('start_at', DateTimeType::class, ['label' => 'Date de début', 'input' => 'datetime_immutable'])
            ->add('duration_worksite', IntegerType::class, ['label' => 'Durée des travaux (en jours)'])
            ->add('supplement_worksite', IntegerType::class, ['label' => 'Travaux supplémentaires (en heures)'])
            ->add('travel_distance_worksite', IntegerType::class, ['label' => 'Distance'])
            ->add('note_client_worksite', TextareaType::class, ['label' => 'Note du client', 'required' => false])
            ->add('note_admin_worksite', TextareaType::class, ['label' => 'Note personnelle', 'required' => false])
            ->add('is_urgent', CheckboxType::class, ['label' => 'Urgent', 'mapped' => false, 'required' => false])
            ->add('status_worksite', ChoiceType::class, ['label' => 'Statut', 'choices' => ['Non commencé' => 'Non commencé', 'En cours' => 'En cours', 'Terminé' => 'Terminé']])
            ->add('category_worksite', EntityType::class, ['label' => 'Catégorie', 'class' => WorksiteCategories::class])
            // ->add('images_worksite', EntityType::class, ['label' => 'Images', 'class' => WorksiteImages::class])
            ->add('quotation_worksite', EntityType::class, ['label' => 'Devis', 'class' => Quotation::class])
            ->add('submit', SubmitType::class, ['label' => 'Valider'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Worksites::class,
        ]);
    }
}
