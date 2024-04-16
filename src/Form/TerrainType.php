<?php

namespace App\Form;

use App\Entity\Sport;
use App\Entity\Terrain;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TerrainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomterrain')
            ->add('localisation')
            ->add('taille')
            ->add('sport', EntityType::class, [
                'class' => Sport::class,
                'choice_label' => 'nom', 
                'placeholder' => 'Sélectionnez un sport', 
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Terrain::class,
        ]);
    }
}
