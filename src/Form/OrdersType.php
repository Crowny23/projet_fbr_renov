<?php

namespace App\Form;

use App\Entity\Orders;
use App\Entity\Supplier;
use App\Entity\Worksites;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrdersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name_order', TextType::class, ['label' => 'Nom de la commande'])
            ->add('reference', TextType::class, ['label' => 'Numéro de commande'])
            // ->add('total_price', Integer::class, ['label' => 'Prix total HT'])
            ->add('worksite', EntityType::class, ['label' => 'Chantier', 'class' => Worksites::class])
            ->add('supplier', EntityType::class, ['label' => 'Fournisseur', 'class' => Supplier::class])
            ->add('submit', SubmitType::class, ['label' => 'Valider'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Orders::class,
        ]);
    }
}
