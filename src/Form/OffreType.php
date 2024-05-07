<?php

namespace App\Form;

use App\Entity\Offre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'max' => 20,
                        'minMessage' => 'The title must be at least {{ limit }} characters long',
                        'maxMessage' => 'The title cannot be longer than {{ limit }} characters',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'Only letters are allowed in the title',
                    ]),
                ],
            ])
            ->add('description', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'max' => 300,
                        'minMessage' => 'The description must be at least {{ limit }} characters long',
                        'maxMessage' => 'The description cannot be longer than {{ limit }} characters',
                    ]),
                ],
            ])
            ->add('reduction', TextType::class, [
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\d+%$/',
                        'message' => 'The reduction must be in the format "X%", where X is a number between 1 and 100.',
                    ]),
                ],
            ])
            ->add('produit')
            ->add('idSponsor')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}
