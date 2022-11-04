<?php

namespace App\Form;

use App\Entity\Repairs;
use App\Entity\RepairsImages;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RepairsImagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file', FileType::class, [
                'label' => 'Image',
                'empty_data' => '',
                'label_attr' => ['class' => 'mb-1, mt-2']
                ])
            ->add('repair', EntityType::class, [
                'class' => Repairs::class,
                'label' => 'Dépannage',
                'label_attr' => ['class' => 'mb-1, mt-2']
            ])
            ->add('submit', SubmitType::class, ['label' => 'Enregistrer', 'attr' => ['class' => 'btn btn-success mt-3']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RepairsImages::class,
        ]);
    }
}
