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

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NumCarte', TextType::class,[
                'attr' => [
                    'id' => 'numcarte',
                    'maxlength' => 10,
                    'minlength' => 10
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
                    'maxlength' => 3
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
