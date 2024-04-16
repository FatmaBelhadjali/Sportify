<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('imageFile', FileType::class, [
                'label' => 'Image (JPEG or PNG file)',
                'mapped' => false, // This field is not mapped to any entity property
                'required' => false, // The image is optional
                'attr' => ['accept' => 'image/jpeg, image/png'], // Allow only JPEG and PNG files
            ])
            ->add('prix')
            ->add('categorie', EntityType::class, [
                'class' => 'App\Entity\CategorieProduit',
                'choice_label' => 'nom',
                'placeholder' => 'Select a category',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
