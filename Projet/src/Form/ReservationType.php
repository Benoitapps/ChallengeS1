<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Composition;
use App\Entity\Country;
use App\Entity\Date;
use App\Entity\Reservation;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;



class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('by', EntityType::class,[
                // looks for choices from this entity
            'class' => User::class,
            'choice_label' => 'email',
            'placeholder' => 'email', //widget single_text
])

           // ->add('dates', DateType::class,[
           //     'widget' => 'single_text',


           // ])

            ->add('composition',EntityType::class,[
                'class' => Composition::class,
                'choice_label' => 'nb_adult',

            ])




            ->add('country',EntityType::class,[
                'class' => Country::class,
                'choice_label' => 'name',
                'placeholder' => 'Pays',
            ])
            ->add('company', EntityType::class,[
                'class'=> Company::class,
                'choice_label' => 'name',
                'placeholder' => "Entreprise",
            ])

            ->add('prix')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
