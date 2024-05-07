<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder -> setAttribute('novalidate','novalidate');
        $builder
            ->add('nom_e')
            ->add('nbr_participants', NumberType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'nbr_participants must not be blank.',
                    ]),
                    new Range([
                        'min' => 1,
                        'max' => 1000,
                        'minMessage' => 'nbr_participants must be at least {{ limit }}.',
                        'maxMessage' => 'nbr_participants cannot be higher than {{ limit }}.',
                    ]), ],
                ])
            ->add('description_e')
            ->add('image')
            ->add('lieu')
            ->add('Etat')
            ->add('date_e')
            ->add('categorie')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
