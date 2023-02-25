<?php

namespace App\Form;

use App\Entity\Payment;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NumCarte', TextType::class,[
                'attr' => [
                    'id' => 'numcarte',
                    'maxlength' => 10,
                    'minlength' => 10,
                    'pattern' => '[0-9]*' // autoriser que les chiffres
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\d+$/', // vérifier que le champ ne contient que des chiffres
                        'message' => 'Le champ ne doit contenir que des chiffres.'
                    ])
                ]
            ])
            ->add('expiration', DateType::class,[
                'attr'=>[
                    'id' =>'expiration'
                ]
            ])

            ->add('cvv', TextType::class,[
                'attr' => [
                    'id' => 'cvv',
                    'maxlength' => 3,
                    'maxlength' => 3,
                    'pattern' => '[0-9]*' // autoriser que les chiffres
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\d+$/', // vérifier que le champ ne contient que des chiffres
                        'message' => 'Le champ ne doit contenir que des chiffres.'
                    ])
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Payment::class,
        ]);
    }
}
