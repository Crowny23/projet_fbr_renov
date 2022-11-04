<?php

namespace App\Form;

use App\Entity\Repairs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Customers;
use App\Entity\RepairsCategories;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RepairsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name_repair', TextType::class, ['label' => 'Nom', 'label_attr' => ['class' => 'mb-1, mt-2']])
            ->add('city_repair', TextType::class, ['label' => 'Ville', 'label_attr' => ['class' => 'mb-1, mt-2']])
            ->add('cp_repair', IntegerType::class, ['label' => 'Code postal', 'label_attr' => ['class' => 'mb-1, mt-2']])
            ->add('adress_repair', TextType::class, ['label' => 'Adresse', 'label_attr' => ['class' => 'mb-1, mt-2']])
            ->add('price_repair', IntegerType::class, ['label' => 'Prix(€)', 'label_attr' => ['class' => 'mb-1, mt-2']])
            ->add('reference_repair', IntegerType::class, ['label' => 'Référence du dépannage', 'label_attr' => ['class' => 'mb-1, mt-2']])
            ->add('schedule_repair', ChoiceType::class, [
                'choices' => [
                    'Jour' => 'Jour',
                    'Nuit' => 'Nuit',
                    'Weekend' => 'Weekend'
                ],
                'label' => 'horaire',
                'label_attr' => ['class' => 'mb-1, mt-2']
            ])
            ->add('travel_distance_repair', IntegerType::class, ['label' => 'Distance(km)', 'label_attr' => ['class' => 'mb-1, mt-2']])
            ->add('note_admin_repair', TextType::class, ['label' => 'Note', 'label_attr' => ['class' => 'mb-1, mt-2']])
            ->add('client', EntityType::class, ['class' => Customers::class, 'label_attr' => ['class' => 'mb-1, mt-2']])
            ->add('category', EntityType::class, ['class' => RepairsCategories::class, 'label_attr' => ['class' => 'mb-1, mt-2']])
            ->add('submit', SubmitType::class, ['label' => 'Enregistrer', 'attr' => ['class' => 'btn btn-success mt-3']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Repairs::class,
        ]);
    }
}
