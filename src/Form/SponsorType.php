<?php

namespace App\Form;

use App\Entity\Sponsor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class SponsorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'max' => 10,
                        'minMessage' => 'The name must be at least {{ limit }} characters long',
                        'maxMessage' => 'The name cannot be longer than {{ limit }} characters',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'Only letters are allowed in the name',
                    ]),
                ],
            ])
            ->add('adresse', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'max' => 30,
                        'minMessage' => 'The address must be at least {{ limit }} characters long',
                        'maxMessage' => 'The address cannot be longer than {{ limit }} characters',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'Only letters are allowed in the address',
                    ]),
                ],
            ])
            ->add('numero', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'max' => 8,
                        'exactMessage' => 'The number must be exactly {{ limit }} digits',
                    ]),
                    new Regex([
                        'pattern' => '/^[0-9]+$/',
                        'message' => 'Only numbers are allowed in the number',
                    ]),
                ],
            ])
            ->add('logo')
            ->add('evenement')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sponsor::class,
        ]);
    }
}

