<?php

namespace App\Form;

use App\Entity\Quotation;
use App\Entity\Worksites;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuotationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference_quotation', TextType::class, ['label' => 'Référence du devis', 'label_attr' => ['class' => 'mb-1, mt-2']])
            ->add('price_quotation', MoneyType::class, ['label' => 'Prix du devis ', 'label_attr' => ['class' => 'mb-1, mt-2']])
            ->add('status_quotation', ChoiceType::class, ['label' => 'Statut', 'choices' => ['En attente' => 'En attente', 'Refusé' => 'Refusé', 'Accepté' => 'Accepté'], 'label_attr' => ['class' => 'mb-1, mt-2']])
            ->add('deposit_quotation',  MoneyType::class, ['label' => 'Montant de l\'acompte ', 'label_attr' => ['class' => 'mb-1, mt-2']])
            ->add('intermediate_payment_quotation', MoneyType::class, ['label' => 'Montant du paiement intermédiaire ', 'label_attr' => ['class' => 'mb-1, mt-2']])
            ->add('final_payment_quotation', MoneyType::class, ['label' => 'Montant du paiement final ', 'label_attr' => ['class' => 'mb-1, mt-2']])
            // ->add('second_deposit', MoneyType::class, ['label' => 'Second acompte', 'label_attr' => ['class' => 'mb-1, mt-2']])
            // ->add('discount', MoneyType::class, ['label' => 'Remise', 'label_attr' => ['class' => 'mb-1, mt-2']])
            ->add('worksite', EntityType::class, ['label' => 'Chantier', 'class' => Worksites::class, 'label_attr' => ['class' => 'mb-1, mt-2']])
            ->add('object', TextType::class, ['label' => 'Objet', 'label_attr' => ['class' => 'mb-1, mt-2']])
            ->add('submit', SubmitType::class, ['label' => 'Enregistrer', 'attr' => ['class' => 'btn btn-success mt-3']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quotation::class,
        ]);
    }
}
