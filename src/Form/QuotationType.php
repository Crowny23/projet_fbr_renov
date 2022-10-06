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
            ->add('reference_quotation', TextType::class, ['label' => 'Référence du devis'])
            ->add('price_quotation', MoneyType::class, ['label' => 'Prix du devis '])
            ->add('status_quotation', ChoiceType::class, ['label' => 'Statut', 'choices' => ['En attente' => 'En attente', 'Refusé' => 'Refusé', 'Accepté' => 'Accepté']])
            ->add('deposit_quotation',  MoneyType::class, ['label' => 'Montant de l\'accompte '])
            ->add('intermediate_payment_quotation', MoneyType::class, ['label' => 'Montant du paiement intermédiaire '])
            ->add('final_payment_quotation', MoneyType::class, ['label' => 'Montant du paiement final '])
            // ->add('created_at')
            // ->add('updated_at')
            ->add('worksite', EntityType::class, ['label' => 'Chantier', 'class' => Worksites::class])
            ->add('submit', SubmitType::class, ['label' => 'Valider'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quotation::class,
        ]);
    }
}
