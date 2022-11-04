<?php

namespace App\Form;

use App\Entity\RawMaterials;
use App\Entity\RawMaterialsCategories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RawMaterialsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name_raw_material', TextType::class, ['label' => 'Nom du matériau', 'label_attr' => ['class' => "mb-1, mt-2"]])
            ->add('category', EntityType::class, ['label' => 'Catégorie', 'class' => RawMaterialsCategories::class,'label_attr' => ['class' => "mb-1, mt-2"]])
            ->add('unit', TextType::class, ['label' => 'Unité','label_attr' => ['class' => "mb-1, mt-2"]])
            ->add('price', MoneyType::class, ['label' => 'Prix HT (A titre indicatif) ', 'attr' => ["class" => "mb-3"], 'label_attr' => ['class' => "mb-1, mt-2"]])
            ->add('submit', SubmitType::class, ['label' => 'Enregisrer', 'attr' => ['class' => 'btn btn-success']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RawMaterials::class,
        ]);
    }
}
