<?php

namespace App\Form;

use App\Entity\WorksiteImages;
use App\Entity\Worksites;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorksiteImagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('file', FileType::class, [
            'label' => 'Image',
            'empty_data' => ''
        ])
        ->add('worksite', EntityType::class, [
            'class' => Worksites::class,
            'label' => 'Chantier'
        ])
        ->add('submit', SubmitType::class, ['label' => 'Valider'])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WorksiteImages::class,
        ]);
    }
}
