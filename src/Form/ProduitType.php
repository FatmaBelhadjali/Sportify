<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('imageFile', FileType::class, [
                'label' => 'Image (JPEG or PNG file)',
                'mapped' => false, 
                'required' => false, 
                'attr' => ['accept' => 'image/jpeg, image/png'], 
            ])
            ->add('prix', NumberType::class, [
                'label' => 'Prix',
                'html5' => true, 
                'attr' => [
                    'type' => 'number', 
                    'step' => '0.01', 
                    'min' => '0', 
                    'placeholder' => 'Enter price',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Type([
                        'type' => 'float',
                        'message' => 'Le prix doit être un nombre décimal (float).',
                    ]),
                ],
            ])
            ->add('categorie', EntityType::class, [
                'class' => 'App\Entity\CategorieProduit',
                'choice_label' => 'nom',
                'placeholder' => 'Select a category',
            ])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
