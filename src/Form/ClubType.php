<?php

namespace App\Form;

use App\Entity\Club;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class ClubType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomclub')
            ->add('categorie')
            ->add('datecreation')
            ->add('nomcoach')
            ->add('nbmembres')
            ->add('localisation')
            ->add('descriptionclub')
            ->add('logo', FileType::class, [
                'label' => 'Logo (image file)',
                'mapped' => false, // Le champ n'est pas mappé directement à l'entité Club
                'required' => false, // Optionnel, selon vos besoins
            ]);
    }



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Club::class,
        ]);
    }
}
