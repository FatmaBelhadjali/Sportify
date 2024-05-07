<?php

namespace App\Form;

use App\Entity\Club;
use App\Entity\Equipement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EquipementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomequipement')
            ->add('qteequipement')
            ->add('imageequipement')
            ->add('club', EntityType::class, [
                'class' => Club::class,
                'choice_label' => 'nomclub', 
                'placeholder' => 'Sélectionnez un club', 
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Equipement::class,
        ]);
    }
}
