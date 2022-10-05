<?php

namespace App\Form;

use App\Entity\Repairs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RepairsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name_repair', TextType::class, ['label' => 'Nom'])
            ->add('city_repair', TextType::class, ['label' => 'Ville'])
            ->add('cp_repair', IntegerType::class, ['label' => 'Code postal'])
            ->add('adress_repair', TextType::class, ['label' => 'Adresse'])
            ->add('price_repair', IntegerType::class, ['label' => 'Prix'])
            ->add('reference_repair', IntegerType::class, ['label' => 'Référence du dépannage'])
            ->add('schedule_repair', ChoiceType::class, [
                'choices' => [
                    'jour' => 'jour',
                    'nuit' => 'nuit',
                    'weekend' => 'weekend'
                ],
                'label' => 'horaire'
            ])
            ->add('travel_distance_repair', IntegerType::class, ['label' => 'Distance'])
            ->add('note_admin_repair', TextType::class, ['label' => 'petite note'])
            ->add('client')
            ->add('category')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Repairs::class,
        ]);
    }
}
