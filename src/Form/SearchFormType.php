<?php

namespace App\Form;

use App\Entity\RawMaterials;
use App\Entity\RawMaterialsCategories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name_raw_material', TextType::class, ['label' => 'Rechercher un matériau', 'required' => false])
            ->add('category', EntityType::class, ['class' => RawMaterialsCategories::class, 'label' => 'Catégorie', 'required' => false, 'placeholder' => 'Choisissez une catégorie'])
            ->add('Submit', SubmitType::class, ['label' => '->'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RawMaterials::class,
        ]);
    }
}
